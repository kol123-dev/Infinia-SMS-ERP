@extends('backEnd.master')
@section('title')
    {{ @$page_title }}
@endsection
@push('css')
    <link href="{{ asset('public/backEnd/vendors/editor/summernote-bs4.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('Modules/Certificate/Resources/assets/css/editor.css')}}">
    <style>
        .offer_title {
            font-size: 16px;
            font-weight: 500;
            color: #373737;
            margin-bottom: 0;
        }

        #price-container {
            position: relative;
        }

        .price_loader {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            z-index: 9999;
        }

        .price_loader::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--gradient_1);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        .edu_summernote p {
            max-width: 600px; /* Adjust the maximum line width as needed */
            margin-left: auto;
            margin-right: auto;
        }
    </style>
@endpush
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{ @$page_title }}</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">{{ _trans('certificate.Certificate') }}</a>
                    <a href="#">{{ @$page_title }}</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="white-box">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-6 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-15">{{ _trans('certificate.Certificate Templates') }}</h3>
                            </div>
                        </div>
                        @if (userPermission('certificate.template-create'))
                        <!-- <div class="row"> -->
                            <div class="col-md-6 text-md-right mb-15">
                                <a href="{{ route('certificate.templates') }}" class="primary-btn small fix-gr-bg">
                                    {{ _trans('certificate.Certificate List') }}
                                </a>
                            </div>
                        <!-- </div> -->
                    @endif
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    @if (userPermission('certificate.template-store'))
                                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'certificate.template-store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'student_form']) }}
                                    @endif
                                    <div>
                                        <div class="add-visitor">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="primary_input">
                                                        <label for="levelText">@lang('common.name') <span class="text-danger">
                                                                *</span></label>
                                                        <input
                                                            class="primary_input_field form-control{{ @$errors->has('name') ? ' is-invalid' : '' }}"
                                                            type="text" name="name" autocomplete="off" id="levelText"
                                                            placeholder="{{ _trans('certificate.Certificate Name') }}"
                                                            value="{{ isset($editData) ? $editData->name : old('name') }}">
                                                        <input type="hidden" name="id"
                                                            value="{{ isset($editData) ? $editData->id : '' }}">
                                                        @if ($errors->has('name'))
                                                            <span class="text-danger">{{ @$errors->first('name') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <input type="hidden" name="type_role_id" id="type_role_id" value="">
                                                <div class="col-lg-4 mb-30">
                                                    <label class="primary_input_label" for="">
                                                        {{ _trans('certificate.Certificate Type') }}
                                                        <span class="text-danger"> *</span>
                                                    </label>
                                                    <select
                                                        class="primary_select  form-control{{ $errors->has('type_id') ? ' is-invalid' : '' }}"
                                                        name="type_id" id="type_id">
                                                        <option
                                                            data-display=" {{ _trans('certificate.Certificate Type') }} *"
                                                            value=""> {{ _trans('certificate.Certificate Type') }}
                                                            *</option>
                                                        @foreach ($types as $type)
                                                            <option
                                                                value="{{ $type->id }}" data-role_id="{{$type->role_id}}" {{ isset($editData) ? ($editData->certificate_type_id == $type->id ? 'selected' : '') : '' }}>
                                                                {{ $type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('type_id'))
                                                        <span class="text-danger invalid-select" role="alert">
                                                            {{ $errors->first('type_id') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-lg-4 mb-30">
                                                    <label class="primary_input_label" for="">
                                                        {{ _trans('certificate.Page Layout') }}
                                                        <span class="text-danger"> *</span>
                                                    </label>
                                                    <select
                                                        class="primary_select select_layout form-control{{ $errors->has('layout') ? ' is-invalid' : '' }}"
                                                        name="layout" id="layout">
                                                        <option data-display=" {{ _trans('certificate.Page Layout') }} *"
                                                            value=""> {{ _trans('certificate.Page Layout') }} *
                                                        </option>
                                                        <option value="1"
                                                            {{ isset($editData) ? ($editData->layout == 1 ? 'selected' : '') : '' }}>
                                                            {{ _trans('certificate.A4 (Portrait)') }} </option>
                                                        <option value="2"
                                                            {{ isset($editData) ? ($editData->layout == 2 ? 'selected' : '') : '' }}>
                                                            {{ _trans('certificate.A4 (Landscape)') }} </option>
                                                        <option value="3"
                                                            {{ isset($editData) ? ($editData->layout == 3 ? 'selected' : '') : '' }}>
                                                            {{ _trans('certificate.Custom') }} </option>

                                                    </select>
                                                    @if ($errors->has('layout'))
                                                        <span class="text-danger invalid-select" role="alert">
                                                            {{ $errors->first('layout') }}
                                                        </span>
                                                    @endif
                                                </div>

                                            </div>
                                            @php
                                                $selected_qr_options=[];
                                                if(isset($editData)){
                                                    $selected_qr_options = json_decode($editData->qr_code) ?? [];
                                                }
                                            @endphp
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="primary_input">
                                                        <label for="height">{{ _trans('certificate.Height') }}(mm) <span
                                                                class="text-danger">*</span></label>
                                                        <input
                                                            class="primary_input_field certificate_hright form-control{{ @$errors->has('height') ? ' is-invalid' : '' }}"
                                                            type="text" name="height" autocomplete="off" id="height"
                                                            placeholder="{{ _trans('certificate.Enter Height (mm)') }}"
                                                            value="{{ isset($editData) ? $editData->height : old('height') }}">
                                                        @if ($errors->has('height'))
                                                            <span
                                                                class="text-danger">{{ @$errors->first('height') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="primary_input">
                                                        <label for="width">{{ _trans('certificate.Width') }}(mm) <span
                                                                class="text-danger">*</span></label>
                                                        <input
                                                            class="primary_input_field certificate_width form-control{{ @$errors->has('width') ? ' is-invalid' : '' }}"
                                                            type="text" name="width" autocomplete="off" id="width"
                                                            placeholder="{{ _trans('certificate.Enter Width (mm)') }}"
                                                            value="{{ isset($editData) ? $editData->width : old('width') }}">
                                                        @if ($errors->has('width'))
                                                            <span class="text-danger">{{ @$errors->first('width') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 mb-30" id="status_section">
                                                    <label class="primary_input_label" for="">
                                                        {{ _trans('certificate.Status') }}
                                                        <span class="text-danger"> *</span>
                                                    </label>
                                                    <select
                                                        class="primary_select form-control{{ $errors->has('status') ? ' is-invalid' : '' }}"
                                                        name="status" id="status">
                                                        <option data-display=" {{ _trans('certificate.Status') }} *"
                                                            value=""> {{ _trans('certificate.Status') }} *</option>
                                                        <option value="1"
                                                            {{ isset($editData) ? ($editData->status == 1 ? 'selected' : '') : 'selected' }}>
                                                            {{ _trans('certificate.Active') }} </option>
                                                        <option value="2"
                                                            {{ isset($editData) ? ($editData->status == 2 ? 'selected' : '') : '' }}>
                                                            {{ _trans('certificate.Inactive') }} </option>

                                                    </select>
                                                    @if ($errors->has('status'))
                                                        <span class="text-danger invalid-select" role="alert">
                                                            {{ $errors->first('status') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-lg-4 mb-30" id="student_qr_section" style="display: none">
                                                    <label class="primary_input_label" for="">
                                                        {{ _trans('certificate.QR Code Text') }}
                                                        <span class="text-danger"> *</span>
                                                    </label> 

                                                    
                                                   
                                                    <select multiple="multiple" class="multypol_check_select active position-relative {{ $errors->has('qr_code_student') ? ' is-invalid' : '' }}" id="selectStaff"
                                                name="qr_code_student[]" style="width:300px">
                                                        <option value="admission_no" {{ isset($editData) ? (in_array('admission_no',$selected_qr_options)  ? 'selected' : '') : 'selected' }}> {{ _trans('certificate.Admission No') }} </option>
                                                        <option value="roll_no" {{ isset($editData) ? (in_array('roll_no',$selected_qr_options)  ? 'selected' : '') : '' }}> {{ _trans('certificate.Roll No') }} </option>
                                                        <option value="date_of_birth" {{ isset($editData) ? (in_array('date_of_birth',$selected_qr_options) ? 'selected' : '') : '' }}> {{ _trans('certificate.Date of birth') }} </option>
                                                        <option value="certificate_number" {{ isset($editData) ? (in_array('certificate_number',$selected_qr_options)  ? 'selected' : '') : '' }}> {{ _trans('certificate.Certificate Number') }} </option>
                                                        <option value="link" {{ isset($editData) ? (in_array('link',$selected_qr_options)  ? 'selected' : '') : '' }}> {{ _trans('certificate.Certificate Link') }} </option>
                                                    </select>


                                                    @if ($errors->has('qr_code_student'))
                                                        <span class="text-danger invalid-select" role="alert">
                                                            {{ $errors->first('qr_code_student') }}
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="col-lg-4 mb-30" id="employee_qr_section" style="display: none">
                                                    <label class="primary_input_label" for="">
                                                        {{ _trans('certificate.QR Code Text') }}
                                                        <span class="text-danger"> *</span>
                                                    </label>
                                                    <select multiple="multiple" class="multypol_check_select active position-relative {{ $errors->has('qr_code_staff') ? ' is-invalid' : '' }}" id="selectStaff"
                                                        name="qr_code_staff[]" style="width:300px">
                                                        <option value="staff_id" {{ isset($editData) ? (in_array('staff_id',$selected_qr_options) == 'staff_id' ? 'selected' : '') : 'selected' }}> {{ _trans('certificate.Staff ID') }} </option>
                                                        <option value="joining_date" {{ isset($editData) ? (in_array('joining_date',$selected_qr_options) == 'joining_date' ? 'selected' : '') : '' }}> {{ _trans('certificate.Joining Date') }} </option>
                                                        <option value="certificate_number" {{ isset($editData) ? (in_array('certificate_number',$selected_qr_options) == 'certificate_number' ? 'selected' : '') : '' }}> {{ _trans('certificate.Certificate Number') }} </option>
                                                        <option value="link" {{ isset($editData) ? (in_array('link',$selected_qr_options)  ? 'selected' : '') : '' }}> {{ _trans('certificate.Certificate Link') }} </option>
                                                    </select>
                                                    @if ($errors->has('qr_code_staff'))
                                                        <span class="text-danger invalid-select" role="alert">
                                                            {{ $errors->first('qr_code_staff') }}
                                                        </span>
                                                    @endif
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4 mb-30">
                                                    <label class="primary_input_label" for="">
                                                        {{ _trans('certificate.User Image Shape') }}
                                                    </label>
                                                    <select
                                                        class="primary_select form-control{{ $errors->has('user_photo_style') ? ' is-invalid' : '' }}"
                                                        name="user_photo_style" id="user_photo_style">
                                                        <option data-display=" {{ _trans('certificate.User Image Shape') }}"
                                                            value=""> {{ _trans('certificate.User Image Shape') }}</option>
                                                        <option value="0" {{ isset($editData) ? ($editData->user_photo_style == 0 ? 'selected' : '') : 'selected' }}> {{ _trans('certificate.No Photo') }} </option>
                                                        <option value="1" {{ isset($editData) ? ($editData->user_photo_style == 1 ? 'selected' : '') : '' }}> {{ _trans('certificate.Circle') }} </option>
                                                        <option value="2" {{ isset($editData) ? ($editData->user_photo_style == 2 ? 'selected' : '') : '' }}> {{ _trans('certificate.Square') }} </option>

                                                    </select>
                                                    @if ($errors->has('user_photo_style'))
                                                        <span class="text-danger invalid-select" role="alert">
                                                            {{ $errors->first('user_photo_style') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="primary_input">
                                                        <label for="width">{{ _trans('certificate.User Image Size') }} <span
                                                                class="text-danger" id="user_image_size_required" style="display:none">*</span></label>
                                                        <input class="primary_input_field  form-control{{ @$errors->has('user_image_size') ? ' is-invalid' : '' }}"
                                                            type="number" name="user_image_size" autocomplete="off"
                                                            placeholder="{{ _trans('certificate.Photo Size (px)') }}"
                                                            value="{{ isset($editData) ? $editData->user_image_size : old('user_image_size') }}">
                                                            
                                                        @if ($errors->has('user_image_size'))
                                                            <span class="text-danger">{{ @$errors->first('user_image_size') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="primary_input">
                                                        <label for="width">{{ _trans('certificate.QR Code Size') }} <span
                                                                class="text-danger">*</span></label>
                                                        <input class="primary_input_field  form-control{{ @$errors->has('qr_image_size') ? ' is-invalid' : '' }}"
                                                            type="number" name="qr_image_size" autocomplete="off"
                                                            placeholder="{{ _trans('certificate.QR Code Size (px)') }}"
                                                            value="{{ isset($editData) ? $editData->qr_image_size : old('qr_image_size') }}">

                                                        @if ($errors->has('qr_image_size'))
                                                            <span class="text-danger">{{ @$errors->first('qr_image_size') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-20">

                                                <div class="col-lg-4">
                                                    <label
                                                        for="background_image">{{ _trans('certificate.Background Image') }}
                                                        <span class="text-danger">*</span></label>
                                                    <div class="primary_input">
                                                        <div class="primary_file_uploader">
                                                            <input
                                                                class="primary_input_field form-control {{ $errors->has('background_image') ? ' is-invalid' : '' }}"
                                                                readonly="true" type="text"
                                                                placeholder="{{ isset($editData->background_image) && @$editData->background_image != '' ? getFileName(@$editData->background_image) : _trans('certificate.Background Image') . '' }}"
                                                                id="placeholderUploadContent">
                                                            <button class="" type="button">
                                                                <label class="primary-btn small fix-gr-bg"
                                                                    for="upload_background_image">{{ __('common.browse') }}</label>
                                                                <input type="file" class="d-none file_upload"
                                                                    name="background_image" id="upload_background_image"
                                                                    accept=".jpg,.png,.jpeg">
                                                            </button>
                                                            <code>(jpg,png,jpeg are allowed for upload)</code>
                                                        </div>
                                                        @if ($errors->has('background_image'))
                                                            <span
                                                                class="text-danger">{{ @$errors->first('background_image') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label
                                                        for="signature_image">{{ _trans('certificate.Signature Image') }}</label>
                                                    <div class="primary_input">
                                                        <div class="primary_file_uploader">
                                                            <input
                                                                class="primary_input_field form-control {{ $errors->has('signature_image') ? ' is-invalid' : '' }}"
                                                                readonly="true" type="text"
                                                                placeholder="{{ isset($editData->signature_image) && @$editData->signature_image != '' ? getFileName(@$editData->signature_image) : _trans('certificate.Signature Image') . '' }}"
                                                                id="placeholderUploadContent">
                                                            <button class="" type="button">
                                                                <label class="primary-btn small fix-gr-bg"
                                                                    for="upload_signature_image">{{ __('common.browse') }}</label>
                                                                <input type="file" class="d-none file_upload"
                                                                    name="signature_image" id="upload_signature_image"
                                                                    accept=".jpg,.png,.jpeg">
                                                            </button>
                                                            <code>(jpg,png,jpeg are allowed for upload)</code>
                                                        </div>
                                                        @if ($errors->has('signature_image'))
                                                            <span
                                                                class="text-danger">{{ @$errors->first('signature_image') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label for="logo_image">{{ _trans('certificate.Logo Image') }} <span
                                                            class="text-danger"></span></label>
                                                    <div class="primary_input">
                                                        <div class="primary_file_uploader">
                                                            <input
                                                                class="primary_input_field form-control {{ $errors->has('logo_image') ? ' is-invalid' : '' }}"
                                                                readonly="true" type="text"
                                                                placeholder="{{ isset($editData->logo_image) && @$editData->logo_image != '' ? getFileName(@$editData->logo_image) : _trans('certificate.Logo Image') . '' }}"
                                                                id="placeholderUploadContent">
                                                            <button class="" type="button">
                                                                <label class="primary-btn small fix-gr-bg"
                                                                    for="upload_logo_image">{{ __('common.browse') }}</label>
                                                                <input type="file" class="d-none file_upload"
                                                                    name="logo_image" id="upload_logo_image"
                                                                    accept=".jpg,.png,.jpeg">
                                                            </button>
                                                            <code>(jpg,png,jpeg are allowed for upload)</code>
                                                        </div>
                                                    </div>
                                                    @if ($errors->has('logo_image'))
                                                        <span
                                                            class="text-danger">{{ @$errors->first('logo_image') }}</span>
                                                    @endif
                                                </div>

                                            </div>
                                            <div class="row mt-20 price-container">
                                                <div class="col-lg-12">
                                                    <div class="primary_input">
                                                        <label class="primary_input_label"
                                                            for="">{{ _trans('certificate.Body Content') }} <span
                                                                class="text-danger"> *</span></label>
                                                        <textarea class="edu_summernote" cols="0" rows="4" name="content">{{ @$editData->content }}</textarea>

                                                        @if ($errors->has('content'))
                                                            <span
                                                                class="text-danger">{{ @$errors->first('content') }}</span>
                                                        @endif

                                                    </div>
                                                </div>
                                                <div class="col-lg-12 price_show_tag mt-20" id="useable_tags">

                                                </div>
                                                <div class="price_loader"></div>
                                            </div>
                                            @php
                                                $tooltip = '';
                                                if (userPermission('certificate.template-store')) {
                                                    $tooltip = '';
                                                } else {
                                                    $tooltip = 'You have no permission to add';
                                                }
                                            @endphp
                                            <div class="row mt-40">
                                                <div class="col-lg-12 text-center">
                                                    <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip"
                                                        title="{{ @$tooltip }}">
                                                        <span class="ti-check"></span>
                                                        @if (isset($editData))
                                                            {{ _trans('common.update') }}
                                                        @else
                                                            {{ _trans('common.save') }}
                                                        @endif
                                                        {{ _trans('certificate.Template') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script src="{{ asset('public/backEnd/vendors/editor/summernote-bs4.js') }}"></script>
    <script>
        $(document).ready(function() {
            var edu_summernote = $('.edu_summernote').summernote({
                height: 400,
                maxWidth: 840,
                fontNames: ['Arial', 'Arial Black','Pinyon Script', 'Comic Sans MS', 'Courier New'],
                toolbar: [
                    ['style', ['style']],
                    // ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript',
                        'subscript', 'clear'
                    ]],
                    ['fontSizes', ['8', '9', '10', '11', '12', '13', '14', '15', '16', '18', '20', '22' , '24', '28', '32', '36', '40', '48']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'hr']],
                    ['view', ['fullscreen' /*, 'codeview' */ ]], // remove codeview button
                    ['help', ['help']]
                ],
            });
            // $('#insertTextButton').click(function(e) {
            //     e.preventDefault();
            //     var textToInsert = 'This is the text to insert.';
            //     edu_summernote.summernote('pasteHTML', textToInsert);
            // });
        });


        $('.select_layout').on('change', function() {
            let layout = $(this).val();
            let height = $('.certificate_hright');
            let width = $('.certificate_width');

            if (layout == 1) {
                // Portrait
                height.val('297mm');
                width.val('210mm');
                height.attr('readonly', true);
                width.attr('readonly', true);
            } else if (layout == 2) {
                // Landscape
                height.val('210mm');
                width.val('297mm');
                height.attr('readonly', true);
                width.attr('readonly', true);
            } else {
                height.val('');
                width.val('');
                height.attr('readonly', false);
                width.attr('readonly', false);
            }
        })
        $('#user_photo_style').on('change',function(){
            let user_photo_style = $(this).val();
            console.log(user_photo_style);
            let user_image_size = $('input[name="user_image_size"]');
            if(user_photo_style == 0){
                user_image_size.val('');
                user_image_size.attr('readonly',true);
                $('#user_image_size_required').hide();
            }else{
                user_image_size.attr('readonly',false);
                $('#user_image_size_required').show();
            }
        })

        function showLoader() {
            $('.price_loader').show();
        }

        function hideLoader() {
            $('.price_loader').hide();
        }


        $('#type_id').on('change', function() {
            let type_id = $(this).val();
            if (type_id != '') {
                showLoader();
                $.ajax({
                    url: "{{ route('certificate.templateType') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        type_id: type_id
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            $('#useable_tags').html(response.data);
                            hideLoader();
                        } else {
                            $('#useable_tags').html('');
                            toastr.error(response.message);
                            hideLoader();
                        }
                    }
                });
            }

            let role_id = $(this).find(':selected').data('role_id');
            let status_section = $('#status_section');
            let student_qr_section = $('#student_qr_section');
            let employee_qr_section = $('#employee_qr_section');

            $('#type_role_id').val(role_id);

            if (role_id == 2) {
                status_section.hide();
                student_qr_section.show();
                employee_qr_section.hide();
            } else if (role_id != 2) {
                status_section.hide();
                student_qr_section.hide();
                employee_qr_section.show();
            } else {
                status_section.show();
                student_qr_section.hide();
                employee_qr_section.hide();
            }

        })

        $(document).ready(function() {
            $('#useable_tags').on('click', '.btn_tag', function() {
                var value = $(this).data('value');
                var content = $('.edu_summernote').summernote();
                content.summernote({
                    focus: true
                });
                content.summernote('pasteHTML', value);
            });
            let editData = `{{ isset($editData) ? true : false }}`;
            if (editData) {
                $('#type_id').trigger('change');
            }
        });
    </script>
@endpush
@include('backEnd.partials.data_table_js')
@include('backEnd.partials.multi_select_js')
