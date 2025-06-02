<?php

namespace Modules\Certificate\Http\Controllers;

use App\SmStudent;
use Illuminate\Http\Request;
use App\Models\SmCustomField;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;
use Modules\Certificate\Entities\CertificateTemplate;
use Modules\Certificate\Entities\CertificateTemplateDesign;
use Modules\RolePermission\Entities\InfixRole;
use Modules\Certificate\Entities\CertificateType;
use Modules\Certificate\Http\Requests\CertificateTypeRequest;

class CertificateTypeController extends Controller
{
    public function shortCodes()
    {
        $short_codes = "name, dob, present_address, guardian, created_at, admission_no, roll_no,  gender, admission_date, category, cast, father_name, mother_name, religion, email, phone, 
        average_mark,grade, gpa_with_optional, gpa_without_optional, evaluation,exam_total_mark,std_total_mark,position,exam";
        $short_codes = preg_replace('/\s+/', '', $short_codes);
        $short_codes = explode(',', $short_codes);
        if (moduleStatusCheck('University')) {
            array_push($short_codes, "arabic_name", "faculty", "session", "department", "academic", "semester", "semester_label", "graduation_date");
        } else {
            array_push($short_codes, "class", "section");
        }
      $custom_fields=  SmCustomField::where('form_name', 'student_registration')->where('school_id', Auth::user()->school_id)->get();
        if ($custom_fields != null) {
            foreach ($custom_fields as $key => $custom_field) {
                $label='_'.$custom_field->label;
                array_push($short_codes, $label);
            }
        }
        return $short_codes;
    }

    public function shortCodesStaff()
    {
        $short_codes = "name,gender,staff_id,joining_date,designation,department,qualification,total_experience,birthday,email,mobileno,present_address,permanent_address";
        $short_codes = preg_replace('/\s+/', '', $short_codes);
        $short_codes = explode(',', $short_codes);
       
        $custom_fields=  SmCustomField::where('form_name', 'staff_registration')->where('school_id', Auth::user()->school_id)->get();
        if ($custom_fields != null) {
            foreach ($custom_fields as $key => $custom_field) {
                $label='_'.$custom_field->label;
                array_push($short_codes, $label);
            }
        }
        return $short_codes;

    }
    private function common()
    {
        $data = [];
        $data['types'] = CertificateType::get();
        $data['roles'] = InfixRole::whereNotIn('id', [1, 5])->get();
        $data['short_codes'] = $this->shortCodes();
        $data['staff_short_codes'] = $this->shortCodesStaff();
        return $data;
    }
    public function index()
    {
        $data = [];
        $data['page_title'] = _trans('admin.Certificate Type');
        $data = array_merge($data, $this->common());
        return view('certificate::certificate_type', $data);
    }

    public function edit($type_id)
    {
        $data = [];
        $data['page_title'] = _trans('admin.Edit Certificate Type');
        $data = array_merge($data, $this->common());
        $data['editData'] = CertificateType::find($type_id);
        return view('certificate::certificate_type', $data);
    }
    public function storeOrUpdate(CertificateTypeRequest $request)
    {
        try {

            $type = CertificateType::findOrNew($request->id);
            $type->name = $request->name;
            $type->short_code = json_encode($request->short_code);
            $type->role_id = $request->role_id;
            $type->save();
            if ($request->id) {
                $message = _trans('admin.Certificate Type Update Successfully');
                Toastr::success($message, _trans('common.Success'));
            } else {
                $message = _trans('admin.Certificate Type Create Successfully');
                Toastr::success($message, _trans('common.Success'));
            }
            return redirect()->route('certificate.types');
        } catch (\Throwable $th) {
            Toastr::error($th->getMessage(), _trans('common.Error'));
            return redirect()->back();
        }
    }

    public function delete($type_id){
        try {
            $type=CertificateType::with('templates')->find($type_id);
            if ($type->templates->count()>0) {
                Toastr::error(_trans('certificate.Type used in templates'),_trans('common.Error'));
                return redirect()->back();
            }
            $type->delete();
            Toastr::success(_trans('certificate.Type Deleted Successfully'), _trans('common.Success'));
            return redirect()->route('certificate.types');
        } catch (\Throwable $th) {
            Toastr::error($th->getMessage(), _trans('common.Error'));
            return redirect()->back();
        }
    }
}
