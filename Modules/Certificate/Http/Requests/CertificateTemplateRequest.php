<?php

namespace Modules\Certificate\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertificateTemplateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type_id' => 'required',
            'name' => 'required',
            'layout' => 'required',
            'height' => 'required',
            'width' => 'required',
            'background_image' => 'required_if:id,|nullable',
            // 'signature_image' => 'required_if:id,|nullable',
            'type_role_id' => 'required',
            'user_photo_style' => 'required',
            'user_image_size' => 'required_unless:user_photo_style,0',
            'qr_code_student' => 'required_if:type_role_id,2',
            'qr_code_staff' => 'required_unless:type_role_id,2',
            'content' => 'required',
            'user_image_size' => 'required',
            'qr_image_size' => 'required|integer|min:100',
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

    public function messages()
    {
        return [
            'type_id.required' => _trans('response.Certificate Type is required'),
            'name' => _trans('response.Certificate Name is required'),
            'layout' => _trans('response.Certificate Layout is required'),
            'height' => _trans('response.Certificate Height is required'),
            'width' => _trans('response.Certificate Width is required'),
            'background_image' => _trans('response.Certificate Background Image is required'),
            'signature_image' => _trans('response.Certificate Signature Image is required'),
            'content' => _trans('response.Certificate Content is required'),
            'qr_code_student.required_if' => _trans('response.Certificate QR Code is required'),
            'qr_code_staff.required_if' => _trans('response.Certificate QR Code is required'),
            'user_photo_style.required' => _trans('response.User Image Shape is required'),
            'user_image_size.required' => _trans('response.User Image Size is required'),
            'qr_image_size.required' => _trans('response.QR Image Size is required'),
        ];
    }
}
