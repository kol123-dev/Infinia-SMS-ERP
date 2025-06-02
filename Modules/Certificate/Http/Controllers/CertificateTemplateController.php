<?php

namespace Modules\Certificate\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Modules\Certificate\Entities\CertificateSetting;
use Modules\Certificate\Entities\CertificateType;
use Modules\Certificate\Entities\CertificateTemplate;
use Modules\Certificate\Entities\CertificateTemplateDesign;
use Modules\Certificate\Http\Requests\CertificateTemplateRequest;

class CertificateTemplateController extends Controller
{
    private function common()
    {
        $data = [];
        $data['templates'] = CertificateTemplate::with('type',)->get();
        $data['types'] = CertificateType::get();
        return $data;
    }
    public function index()
    {
        $data = [];
        $data['page_title'] = _trans('admin.Certificate Templates');
        $data = array_merge($data, $this->common());
        return view('certificate::certificate_templates', $data);
    }
    public function create()
    {
        $data = [];
        $data['page_title'] = _trans('admin.Create Certificate Template');
        $data['types'] = CertificateType::get();
        return view('certificate::certificate_create_template', $data);
    }

    public function edit($template_id)
    {
        $data = [];
        $data['page_title'] = _trans('admin.Edit Certificate Template');
        $data['types'] = CertificateType::get();
        $data['editData'] = CertificateTemplate::with('type')->find($template_id);
        return view('certificate::certificate_create_template', $data);
    }
    public function storeOrUpdate(CertificateTemplateRequest $request)
    {
        // return $request;
        try {
            $template = CertificateTemplate::findOrNew($request->id);
            $template->certificate_type_id = $request->type_id;
            $template->name = $request->name;
            $template->status = $request->status;
            $template->layout = $request->layout;
            $template->height = floatval($request->height).'mm';
            $template->width = floatval($request->width).'mm';
            $template->qr_code = $request->type_role_id == 2 ? json_encode($request->qr_code_student) : json_encode($request->qr_code_staff);
            $template->qr_image_size = $request->qr_image_size;
            $template->user_photo_style = $request->user_photo_style;
            $template->user_image_size = $request->user_image_size;
            if ($request->hasFile('background_image')) {
                $template->background_image = fileUpload($request->background_image, 'public/uploads/certificate/');
            }
            if ($request->hasFile('signature_image')) {
                $template->signature_image = fileUpload($request->signature_image, 'public/uploads/certificate/');
            }
            if ($request->hasFile('logo_image')) {
                $template->logo_image = fileUpload($request->logo_image, 'public/uploads/certificate/');
            }

            $template->content = $request->content;
            $template->save();

            if ($template->design) {
                $template->design->design_content = null;
                $template->design->save();
            }
            if ($request->id) {
                $message = _trans('admin.Certificate Template Update Successfully');
                Toastr::success($message, _trans('common.Success'));
            } else {
                $message = _trans('admin.Certificate Template Create Successfully');
                Toastr::success($message, _trans('common.Success'));
            }
            return redirect()->route('certificate.templates');
        } catch (\Throwable $th) {
            Toastr::error($th->getMessage(), _trans('common.Error'));
            return redirect()->back();
        }
    }

    public function templateType(Request $request)
    {
        try {
            $certificate_type = CertificateType::find($request->type_id);
            $html = view('certificate::useable_tags', compact('certificate_type'))->render();
            return response()->json([
                'status' => 'success',
                'data' => $html,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'data' => $th->getMessage(),
            ]);
        }
    }

    public function design($template_id)
    {
        $data = [];
        $data['page_title'] = _trans('admin.Design Certificate Template');
        $data['types'] = CertificateType::get();
        $data['editData'] = CertificateTemplate::with('type')->find($template_id);
        return view('certificate::design', $data);
    }
    public function designReset($template_id)
    {
        try {
            $template = CertificateTemplate::find($template_id);
            $template->design->design_content = "";
            $template->design->save();
            Toastr::success(_trans('certificate.Certificate Template Design Reset Successfully'), _trans('common.Success'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error($th->getMessage(), _trans('common.Error'));
            return redirect()->back();
        }
    }

    public function updateDesign(Request $request)
    {
        try {
            $design = CertificateTemplateDesign::where('certificate_template_id', $request->template_id)->first();
            if (!$design) {
                $design = new CertificateTemplateDesign();
            }
            $design->certificate_template_id = $request->template_id;
            $design->design_content = $request->design_content;
            $design->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Design Update Successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function delete($template_id){
        try {
            $template=CertificateTemplate::with('design')->find($template_id);
            if ($template->design) {
                $template->design->delete();
            }
            $template->delete();

            $message = _trans('admin.Certificate Template Deleted Successfully');
            Toastr::success($message, _trans('common.Success'));
        
        return redirect()->route('certificate.templates');
        } catch (\Throwable $th) {
            Toastr::error($th->getMessage(), _trans('common.Error'));
            return redirect()->back();
        }
    }

    public function preview(Request $request){
        try {
            $certificate_setting=CertificateSetting::where('school_id',auth()->user()->school_id)->where('key','prefix')->first();
            $certificate=CertificateTemplate::with('design')->find($request->template);

            $certificate_logo = asset($certificate->logo_image);

            $certificate_signature =asset($certificate->signature_image);
            $logo_image = asset('Modules/Certificate/Resources/assets/signature.png');
            $logo_image = '<img src="' . $logo_image . '">';

            $qrCode=asset('Modules/Certificate/Resources/assets/qr.jpg');
            $qrCode = '<img src="' . $qrCode . '" style="width:' . $certificate->qr_image_size . 'px; height: auto;">';

            $photo = asset('Modules/Certificate/Resources/assets/user.png');
            $radius = $certificate->user_photo_style == 1 ? '50' : '0';
            $user_image = '<img src="' . $photo . '" style="width:' . $certificate->user_image_size . 'px; height: auto; border-radius:' . $radius . '%;">';

            $design_content=$request->design_content;
            $design_content = str_replace('{certificate_logo}', $certificate_logo, $design_content);
            $design_content = str_replace('{user_image}', $user_image, $design_content);
            $design_content = str_replace('{certificate_no}', $certificate_setting->value.'445', $design_content);
            $design_content = str_replace('{logo_image}', $logo_image, $design_content);
            $design_content = str_replace('{issue_date}', date('d-m-Y'), $design_content);
            $design_content = str_replace('{qrCode}', $qrCode, $design_content);

            return response()->json([
                'status' => 'success',
                'data' => $design_content,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'data' => $th->getMessage(),
            ]);
            
        }

    }
}
