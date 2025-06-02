<?php

namespace Modules\Certificate\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertificateRecordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'role_id'=>'required',
            'class'=>'required_if:role_id,==,2',
            'std_certificate'=>'required_if:role_id,==,2',
            'role'=>'required_if:role_id,==,3',
            'staff_certificate'=>'required_if:role_id,==,3',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    public function messages(){
        return [
            'role_id.required'=>'Please Select Role',
            'class.required_if'=>'Please Select Class',
            'std_certificate.required_if'=>'Please Select Certificate',
            'role.required_if'=>'Please Select Role',
            'staff_certificate.required_if'=>'Please Select Certificate',
        ];
    }
}
