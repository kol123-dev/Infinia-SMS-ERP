<?php

namespace Modules\Certificate\Http\Controllers;

use ZipArchive;
use App\SmClass;
use App\SmStaff;
use App\SmStudent;
use App\SmExamType;
use Illuminate\Http\Request;
use App\Models\StudentRecord;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;
use Modules\RolePermission\Entities\InfixRole;
use App\Http\Requests\CertificateTemplateRequest;
use Modules\Certificate\Entities\CertificateType;
use Modules\Certificate\Entities\CertificateRecord;
use Modules\Certificate\Entities\CertificateTemplate;
use Modules\Certificate\Http\Requests\CertificateRecordRequest;

class CertificateController extends Controller
{
    public function index()
    {
        $data = [];

        return view('certificate::verify', $data);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'certificate_number' => 'required',
        ]);
        try {
            $certificate_record = CertificateRecord::where('certificate_number', $request->certificate_number)->first();
            if ($request->method() == 'POST') {
                if ($certificate_record) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Certificate Found',
                        'data' => $certificate_record,
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Certificate Not Found',
                    ]);
                }
            } else {
                return view('certificate::verify', compact('certificate_record'));
            }
        } catch (\Throwable $th) {
            
        }
    }

    public function certificates(Request $request)
    {
        $data = [];
        $data['title'] = _trans('certificate.Certificate Record');
        $data['types'] = CertificateType::get();
        $data['roles'] = InfixRole::whereNotIn('id', [2, 3])->where('school_id', Auth::user()->school_id)->get();
        $data['classes'] = SmClass::where('active_status', 1)->get();
        $data['exams'] = SmExamType::where('active_status', 1)->get();
        $data['templates'] = CertificateTemplate::with('type','generatedCertificates')
        ->where('school_id', Auth::user()->school_id)
        #->whereHas('generatedCertificates')
        ->get();
        return view('certificate::certificates', $data);
    }

    public function searchCertificates(CertificateRecordRequest $request)
    {
        try {

            $certificate_id = $request->role_id == 2 ? $request->std_certificate : $request->staff_certificate;

            $users = [];
            if ($request->role_id == 2) {
                $std_users = StudentRecord::with('student', 'student.user')->where('class_id', $request->class)
                    ->when($request->section, function ($query) use ($request) {
                        return $query->where('section_id', $request->section);
                    })->get();
                $users = $std_users->pluck('student.user.id')->toArray();
            } else {
                $users = SmStaff::where('role_id', $request->role)->where('school_id', Auth::user()->school_id)->pluck('user_id')->toArray();
            }
            $certificate_records = CertificateRecord::where('template_id', $certificate_id)
                ->when($request->exam, function ($query) use ($request) {
                    return $query->where('exam_id', $request->exam);
                })
                ->whereIn('user_id', $users)
                ->get();

            $data = [];
            $data['title'] = _trans('certificate.Certificate Record');
            $data['types'] = CertificateType::get();
            $data['roles'] = InfixRole::whereNotIn('id', [2, 3])->where('school_id', Auth::user()->school_id)->get();
            $data['classes'] = SmClass::where('active_status', 1)->get();
            $data['exams'] = SmExamType::where('active_status', 1)->get();
            $data['templates'] = CertificateTemplate::with('type')->get();
            $data['certificate_records'] = $certificate_records;
            $data['request'] = $request;
            return view('certificate::certificates', $data);
        } catch (\Throwable $th) {
           
        }
    }
    public function delete($record_id)
    {
        try {
            $record = CertificateRecord::find($record_id);
            if (file_exists($record->certificate_path)) {
                unlink($record->certificate_path);
            }
            $record->delete();
            Toastr::success(_trans('certificate.Certificated Deleted Successfully'), _trans('common.Success'));
            return redirect()->route('certificate.records');
        } catch (\Throwable $th) {
            Toastr::error($th->getMessage(), _trans('common.Error'));
            return redirect()->back();
        }
    }
    public function deleteMultiple(Request $request)
    {
        try {
            $records = explode(',', $request->ids);
            foreach ($records as $key => $record_id) {
                $record = CertificateRecord::find($record_id);
                if (file_exists($record->certificate_path)) {
                    unlink($record->certificate_path);
                }
                $record->delete();
            }
            Toastr::success(_trans('certificate.Certificated Deleted Successfully'), _trans('common.Success'));
            return redirect()->route('certificate.records');
        } catch (\Throwable $th) {
            Toastr::error($th->getMessage(), _trans('common.Error'));
            return redirect()->back();
        }
    }

    public function download(Request $request)
    {
        try {

            $ids = explode(',', $request->input('ids'));
            $zip = new \ZipArchive();
            $zipFileName = 'certificates.zip';
            $publicZipPath = public_path($zipFileName);
            $pngFiles = CertificateRecord::whereIn('id', $ids)->pluck('certificate_path')->toArray();

           $publicZipPath = public_path($zipFileName);

            if ($zip->open($publicZipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                foreach ($pngFiles as $filePath) {
                    $fileName = pathinfo($filePath, PATHINFO_BASENAME);
                    $zip->addFile($filePath, $fileName);
                }
                $zip->close();
            }
            if (file_exists($publicZipPath)) {
                return response()->download($publicZipPath)->deleteFileAfterSend(true);
            } else {
                Toastr::error('File not found', 'Failed');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error($th->getMessage(), _trans('common.Error'));
            return redirect()->back();
        }
    }
}
