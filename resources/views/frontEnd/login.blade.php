@php
    $gs = generalSetting();
@endphp
<!DOCTYPE html>
@php
    App::setLocale(getUserLanguage());
    $ttl_rtl = userRtlLtl();

    $login_background = App\SmBackgroundSetting::where([['is_default', 1], ['title', 'Login Background']])->first();

    if (empty($login_background)) {
        $css = 'background: linear-gradient(-45deg, #1a1a1a, #2c2c2c, #d4af37, #b8860b, #000000, #1a1a1a); background-size: 400% 400%; animation: gradient 15s ease infinite;';
    } else {
        if (!empty($login_background->image)) {
            $css = "background: url('" . url($login_background->image) . "') no-repeat center; background-size: cover;";
        } else {
            $css = 'background:' . $login_background->color;
        }
    }
@endphp
<html lang="{{ app()->getLocale() }}" @if (isset($ttl_rtl) && $ttl_rtl == 1) dir="rtl" class="rtl" @endif>

<head>
    <!-- All Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset(generalSetting()->favicon) }}" type="image/png" />
    <title>@lang('auth.login')</title>
    <meta name="_token" content="{!! csrf_token() !!}" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('public/theme/edulia/css/bootstrap.min.css') }}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('public/theme/edulia/css/fontawesome.all.min.css') }}">

    @if(userRtlLtl() ==1)
    <link rel="stylesheet" href="{{ asset('public/theme/edulia/css/style_rtl.css') }}">
    @else
    <link rel="stylesheet" href="{{ asset('public/theme/edulia/css/style.css') }}">
    @endif
    <style>
        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
            100% {
                transform: translateY(0px);
            }
        }

        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.9;
        }

        .animated-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(-45deg, #1a1a1a, #2c2c2c, #d4af37, #b8860b, #000000, #1a1a1a);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        .animated-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .shape {
            position: absolute;
            background: rgba(212, 175, 55, 0.1);
            backdrop-filter: blur(5px);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.2);
        }

        .shape:nth-child(1) {
            width: 300px;
            height: 300px;
            top: -150px;
            left: -150px;
            animation-delay: 0s;
            background: linear-gradient(45deg, rgba(212, 175, 55, 0.1), rgba(184, 134, 11, 0.1));
        }

        .shape:nth-child(2) {
            width: 200px;
            height: 200px;
            top: 50%;
            right: -100px;
            animation-delay: 2s;
            background: linear-gradient(45deg, rgba(26, 26, 26, 0.1), rgba(44, 44, 44, 0.1));
        }

        .shape:nth-child(3) {
            width: 150px;
            height: 150px;
            bottom: -75px;
            left: 50%;
            animation-delay: 4s;
            background: linear-gradient(45deg, rgba(212, 175, 55, 0.1), rgba(0, 0, 0, 0.1));
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        .login {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .login_wrapper {
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            padding: 2.5rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(212, 175, 55, 0.1);
        }

        .login_wrapper:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(212, 175, 55, 0.2);
        }

        .login_wrapper_logo {
            margin-bottom: 2rem;
        }

        .login_wrapper_logo img {
            max-height: 60px;
            width: auto;
        }

        .login_wrapper_content h4 {
            color: #1a1a1a;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .input-control {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .input-control-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
        }

        .input-control-input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.9375rem;
            color: #1a1a1a;
            background: #fff;
            transition: all 0.2s ease;
        }

        .input-control-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .input-control-input::placeholder {
            color: #9ca3af;
        }

        .checkbox {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .checkbox-input {
            width: 1rem;
            height: 1rem;
            border-radius: 4px;
            border: 1px solid #e5e7eb;
            cursor: pointer;
        }

        .checkbox-title {
            color: #4b5563;
            font-size: 0.875rem;
        }

        .text-danger {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .forgot-password {
            color: #d4af37;
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.2s ease;
        }

        .forgot-password:hover {
            color: #b8860b;
            text-decoration: underline;
        }

        .submit-btn {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%);
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 0.9375rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
            background: linear-gradient(135deg, #b8860b 0%, #d4af37 100%);
        }

        @media (max-width: 480px) {
            .login_wrapper {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="animated-bg">
        <div class="animated-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
    </div>
    <section class="login">
        <div class="login_wrapper">
            <div class="login_wrapper_login_content">
                <div class="login_wrapper_logo text-center">
                    <img src="{{ asset(generalSetting()->logo) }}" alt="Logo">
                </div>
                <div class="login_wrapper_content">
                    <h4>@lang('auth.login_details')</h4>
                    <form action="{{ route('login') }}" method='POST'>
                        @csrf
                        <input type="hidden" name="username" id="username-hidden">
                        <div class="input-control">
                            <label for="#" class="input-control-icon"><i class="fal fa-envelope"></i></label>
                            <input type="text" name="email" class="input-control-input"
                                placeholder="@lang('auth.enter_email_address')" value="{{ old('email') }}">
                        </div>
                        @if ($errors->has('email'))
                            <span class="text-danger" role="alert">
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                        <div class="input-control">
                            <label for="#" class="input-control-icon"><i class="fal fa-lock-alt"></i></label>
                            <input type="password" name='password' class="input-control-input"
                                placeholder='@lang('auth.enter_password')'>
                        </div>
                        @if ($errors->has('password'))
                            <span class="text-danger" role="alert">
                                {{ $errors->first('password') }}
                            </span>
                        @endif
                        <div class="input-control d-flex justify-content-between align-items-center">
                            <label class="checkbox">
                                <input type="checkbox" class="checkbox-input" name="remember" id="rememberMe"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <span class="checkbox-title">@lang('auth.remember_me')</span>
                            </label>
                            <a href="{{ route('recoveryPassord') }}" class="forgot-password">@lang('auth.forget_password')?</a>
                        </div>
                        <div class="input-control">
                            <button type="submit" class="submit-btn">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- jQuery JS -->
    <script src="{{ asset('public/theme/edulia/js/jquery.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('public/theme/edulia/js/script.js') }}"></script>
    <script src="{{ asset('public/backEnd/') }}/js/login.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#email-address").keyup(function() {
                $("#username-hidden").val($(this).val());
            });
        });
    </script>
    <script>
        @if(Session::has('toast_message'))
            toastr.{{ Session::get('toast_message')['type'] }}('{{ Session::get('toast_message')['message'] }}');
        @endif
    </script>
</body>
</html>
