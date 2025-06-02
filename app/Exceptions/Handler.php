<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {  
              return redirect('login');
        }

        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException || 
            $exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException && $exception->getStatusCode() == 403) {
            
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Not Found'], 404);
            }

            if (Auth::check()) {
                $message = $exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException && $exception->getStatusCode() == 403 
                    ? 'You do not have permission to access this page'
                    : 'The page you are looking for could not be found';
                
                session()->flash('error', $message);
                return redirect()->route('dashboard');
            } else {
                // For guests, redirect to login
                return redirect()->route('login');
            }
        }

        // Handle all other exceptions
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Server Error'], 500);
        }

        if (Auth::check()) {
            session()->flash('error', 'An unexpected error occurred. Please try again later.');
            return redirect()->route('dashboard');
        }

        return parent::render($request, $exception);
    }
}
