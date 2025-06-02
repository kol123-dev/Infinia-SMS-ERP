@extends('backEnd.master')
@section('title')
    {{ @$page_title }}
@endsection
@push('css')
@endpush
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{ @$page_title }}</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">{{ _trans('admin.Certificate') }}</a>
                    <a href="#">{{ @$title }}</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'certificate.searchCertificates', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box">
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="main-title">
                                <h3 class="mb-15">@lang('common.select_criteria') </h3>
                            </div>
                        </div>
                    </div>
                        <input type="hidden" name="url" id="url" value="{{ URL::to('/') }}">
                        <div class="row">
                            <div class="col-lg-12 mb-30">
                                <label class="primary_input_label" for="">
                                    {{ _trans('admin.Certificate For') }}
                                    <span class="text-danger"> *</span>
                                </label>
                                <select
                                    class="primary_select  form-control{{ $errors->has('role_id') ? ' is-invalid' : '' }}"
                                    name="role_id" id="select_role">
                                    <option data-display=" {{ _trans('admin.Certificate For') }} *" value="">
                                        {{ _trans('admin.Applicable For') }}*</option>
                                    <option value="2"
                                        {{ isset($editData) ? ($editData->role_id == 2 ? 'selected' : '') : '' }}>
                                        {{ _trans('certificate.Student') }}</option>
                                    <option value="3"
                                        {{ isset($editData) ? ($editData->role_id == 3 ? 'selected' : '') : '' }}>
                                        {{ _trans('certificate.Employee') }}</option>
                                </select>
                                @if ($errors->has('role_id'))
                                    <span class="text-danger invalid-select" role="alert">
                                        {{ $errors->first('role_id') }}
                                    </span>
                                @endif
                            </div>

                        </div>
                        <div class="row" id="student_filter" style="display: none">

                            <div class="col-lg-3 mt-30-md">
                                <label class="primary_input_label" for="">@lang('common.class') <span
                                        class="text-danger"> *</span></label>
                                <select
                                    class="primary_select  form-control {{ @$errors->has('class') ? ' is-invalid' : '' }}"
                                    id="select_class" name="class">
                                    <option data-display="@lang('common.select_class')*" value="">
                                        @lang('common.select_class') *</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ @$class->id }}"
                                            {{ isset($class_id) ? ($class_id == $class->id ? 'selected' : '') : '' }}>
                                            {{ @$class->class_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('class'))
                                    <span class="text-danger invalid-select" role="alert">
                                        {{ @$errors->first('class') }}
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-3 mt-30-md" id="select_section_div">
                                <label class="primary_input_label" for="">@lang('common.section') <span
                                        class="text-danger"> </span></label>
                                <select class="primary_select " id="select_section" name="section">
                                    <option data-display="@lang('common.select_section')" value="">
                                        @lang('common.select_section')</option>
                                </select>
                                @if ($errors->has('section'))
                                    <span class="text-danger invalid-select" role="alert">
                                        {{ @$errors->first('section') }}
                                    </span>
                                @endif
                                <div class="pull-right loader loader_style" id="select_section_loader">
                                    <img class="loader_img_style" src="{{ asset('public/backEnd/img/demo_wait.gif') }}"
                                        alt="loader">
                                </div>
                            </div>
                            <div class="col-lg-3 mt-30-md">
                                <label class="primary_input_label" for="">{{ _trans('certificate.Exam') }}</label>
                                <select
                                    class="primary_select  form-control {{ @$errors->has('exam') ? ' is-invalid' : '' }}"
                                    name="exam" id="exam">
                                    <option data-display="{{ _trans('certificate.Select Exam') }}" value="">
                                        {{ _trans('certificate.Exam') }}</option>
                                    @foreach ($exams as $exam)
                                        <option value="{{ @$exam->id }}"
                                            {{ isset($exam_id) ? ($exam_id == $exam->id ? 'selected' : '') : (old('certificate') == $exam->id ? 'selected' : '') }}>
                                            {{ @$exam->title }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('exam'))
                                    <span class="text-danger invalid-select" role="alert">
                                        {{ @$errors->first('exam') }}
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-3 mt-30-md">
                                <label class="primary_input_label" for="">@lang('admin.certificate') <span
                                        class="text-danger"> *</span></label>
                                <select
                                    class="primary_select  form-control {{ @$errors->has('certificate') ? ' is-invalid' : '' }}"
                                    name="std_certificate" id="certificate">
                                    <option data-display="@lang('admin.select_certificate') *" value="">
                                        @lang('admin.select_certificate') *</option>
                                    @php
                                        $std_templates = $templates->where('type.role_id', 2);
                                    @endphp
                                    @foreach ($std_templates as $template)
                                        <option value="{{ @$template->id }}"
                                            {{ isset($certificate_id) ? ($certificate_id == $template->id ? 'selected' : '') : (old('certificate') == $template->id ? 'selected' : '') }}>
                                            {{ @$template->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('certificate'))
                                    <span class="text-danger invalid-select" role="alert">
                                        {{ @$errors->first('certificate') }}
                                    </span>
                                @endif
                            </div>

                        </div>
                        <div class="row" id="staff_filter" style="display: none">

                            <div class="col-lg-6 mt-30-md">
                                <label class="primary_input_label" for="">{{ _trans('certificate.Role') }} <span
                                        class="text-danger"> *</span></label>
                                <select
                                    class="primary_select  form-control {{ @$errors->has('role') ? ' is-invalid' : '' }}"
                                    id="select_role" name="role">
                                    <option data-display="{{ _trans('certificate.Select Role') }}*" value="">
                                        {{ _trans('certificate.Select Role') }} *</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ @$role->id }}"
                                            {{ isset($role_id) ? ($role_id == $role->id ? 'selected' : '') : '' }}>
                                            {{ @$role->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('role'))
                                    <span role="text-danger invalid-select" role="alert">
                                        {{ @$errors->first('role') }}
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-6 mt-30-md">
                                <label class="primary_input_label" for="">@lang('admin.certificate') <span
                                        class="text-danger"> *</span></label>
                                <select
                                    class="primary_select  form-control {{ @$errors->has('certificate') ? ' is-invalid' : '' }}"
                                    name="staff_certificate" id="certificate">
                                    <option data-display="@lang('admin.select_certificate') *" value="">
                                        @lang('admin.select_certificate') *</option>
                                    @php
                                        $staff_templates = $templates->where('type.role_id', 3);
                                    @endphp
                                    @foreach ($staff_templates as $template)
                                        <option value="{{ @$template->id }}"
                                            {{ isset($certificate_id) ? ($certificate_id == $template->id ? 'selected' : '') : (old('certificate') == $template->id ? 'selected' : '') }}>
                                            {{ @$template->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('certificate'))
                                    <span class="text-danger invalid-select" role="alert">
                                        {{ @$errors->first('certificate') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 mt-20 text-right">
                                <button type="submit" class="primary-btn small fix-gr-bg">
                                    <span class="ti-search pr-2"></span>
                                    @lang('common.search')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </section>
    @if (isset($certificate_records))
        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="white-box mt-40">
                        <div class="row">
                            <div class="col-lg-2 no-gutters">
                                <div class="main-title">
                                    <h3 class="mb-15">{{ _trans('admin.Generated Certificate List') }}</h3>
                                </div>
                            </div>
                           
                            <div class="col-lg-4">
                                <div class="" id="records_dropdown" style="display: none">
                                    <a href="" class="primary-btn small fix-gr-bg" id="deleteMultipleRecord">{{ _trans('common.delete') }}</a>
                                    <a href="" class="primary-btn small fix-gr-bg" id="downloadMultipleRecord">{{ _trans('certificate.Download (Zip)') }}</a>
                                </div>
                              
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <x-table>
                                    <table id="table_id" class="table Crm_table_active3" cellspacing="0"
                                        width="100%">

                                        <thead>

                                            <tr>
                                                <th width="10%">
                                                    <input type="checkbox" id="checkAll"
                                                        class="common-checkbox generate-certificate-print-all"
                                                        name="checkAll" value="">
                                                    <label for="checkAll">@lang('admin.all')</label>
                                                </th>
                                                <th>{{ _trans('common.Name') }}</th>
                                                <th>{{ _trans('certificate.Template') }}</th>
                                                <th>{{ _trans('certificate.Generated At') }}</th>
                                                <th>{{ _trans('certificate.Certificate') }}</th>
                                                <th>@lang('common.action')</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($certificate_records as $certificate_record)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox"
                                                            id="student.{{ @$certificate_record->id }}"
                                                            class="common-checkbox generate-certificate-select"
                                                            name="student_checked[]"
                                                            value="{{ @$certificate_record->id }}">
                                                        <label for="student.{{ @$certificate_record->id }}"></label>
                                                    </td>
                                                    <td>{{ @$certificate_record->user->full_name }}</td>
                                                    <td>{{ @$certificate_record->template->name }}</td>
                                                    <td>{{ dateConvert(@$certificate_record->created_at) }}</td>
                                                    <td>
                                                        <img src="{{ asset($certificate_record->certificate_path) }}"
                                                            width="100px" height="auto" alt="">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $routeList = [
                                                                '<a class="dropdown-item" data-toggle="modal"
                                                                    data-target="#viewCertificateModal' .
                                                                $certificate_record->id .
                                                                '"
                                                                    href="#">' .
                                                                __('common.view') .
                                                                '</a>',
                                                                userPermission('certificate.record_delete')
                                                                    ? '<a class="dropdown-item" data-toggle="modal"
                                                                    data-target="#deleteSectionModal' .
                                                                        $certificate_record->id .
                                                                        '"
                                                                    href="#">' .
                                                                        __('common.delete') .
                                                                        '</a>'
                                                                    : null,
                                                            ];
                                                        @endphp
                                                        <x-drop-down-action-component :routeList="$routeList" />
                                                    </td>
                                                </tr>
                                                <div class="modal fade admin-query"
                                                    id="deleteSectionModal{{ @$certificate_record->id }}">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">
                                                                    {{ _trans('certificate.Delete Certificate') }}
                                                                </h4>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="text-center">
                                                                    <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                                </div>

                                                                <div class="mt-40 d-flex justify-content-between">
                                                                    <button type="button" class="primary-btn tr-bg"
                                                                        data-dismiss="modal">@lang('common.cancel')</button>
                                                                    <a href="{{ route('certificate.record_delete', [@$certificate_record->id]) }}"
                                                                        class="text-light">
                                                                        <button class="primary-btn fix-gr-bg"
                                                                            type="submit">@lang('common.delete')</button>
                                                                    </a>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade admin-query"
                                                    id="viewCertificateModal{{ @$certificate_record->id }}">
                                                    <div class="modal-dialog modal_1000px modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">
                                                                    {{ _trans('certificate.View Certificate') }}
                                                                </h4>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div id="view_certificate">
                                                                    <img src="{{ asset($certificate_record->certificate_path) }}"
                                                                        width="100%" height="auto" alt="">
                                                                </div>
                                                                <div class="row" id="download_certificate">
                                                                    <div class="col-lg-12 text-center mt-40">
                                                                        {{-- <button class="primary-btn fix-gr-bg"
                                                                        onclick="javascript:printDiv(`{{asset($certificate_record->certificate_path)}}`)">{{_trans('certificate.Print')}}</button> --}}
                                                                        <a href="{{ asset($certificate_record->certificate_path) }}"
                                                                            download>
                                                                            <button class="primary-btn fix-gr-bg"
                                                                                type="submit">{{ _trans('certificate.Download') }}</button>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </x-table>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="modal fade admin-query" id="deleteMultipleCertificate">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">
                                        {{ _trans('certificate.Delete Multiple Certificate') }}
                                    </h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body">
                                    <div class="text-center">
                                        <h4>@lang('common.are_you_sure_to_delete')</h4>
                                    </div>

                                    <div class="mt-40 d-flex justify-content-between">
                                        <button type="button" class="primary-btn tr-bg"
                                            data-dismiss="modal">@lang('common.cancel')</button>
                                        <a href="#" id="multiple_delete_url" class="text-light">
                                            <button class="primary-btn fix-gr-bg"
                                                type="submit">@lang('common.delete')</button>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
@push('script')
    <script>
        $('.generate-certificate-select').on('click', function() {
            if ($('.generate-certificate-select:checked').length == $('.generate-certificate-select').length) {
                $('#checkAll').prop('checked', true);
            } else {
                $('#checkAll').prop('checked', false);
            }
            checkSelectStd();

        });
        $('#checkAll').on('click', function() {
            checkSelectStd();
        });

        function checkSelectStd() {
            if ($('.generate-certificate-select:checked').length > 0) {
                console.log('show');
                $('#records_dropdown').show();
            } else {
                console.log('hide');
                $('#records_dropdown').hide();
            }
        }

        $('#select_role').on('change', function() {
            var role_id = $(this).val();
            if (role_id == 2) {
                $('#student_filter').show();
                $('#staff_filter').hide();
            } else if (role_id == 3) {
                $('#student_filter').hide();
                $('#staff_filter').show();
            } else {
                $('#student_filter').hide();
                $('#staff_filter').hide();
            }
        });

        $('#deleteMultipleRecord').on('click',function(){
            let selected = [];
            $('.generate-certificate-select:checked').each(function() {
                selected.push($(this).val());
            });
            let url = "{{ route('certificate.record_delete_multiple') }}";
            url = url + '?ids=' + selected;
            $('#multiple_delete_url').attr('href',url);
            $('#deleteMultipleCertificate').modal('show');
        })
        $('#downloadMultipleRecord').on('click',function(e){
            e.preventDefault();
            let selected = [];
            $('.generate-certificate-select:checked').each(function() {
                selected.push($(this).val());
            });
            let url = "{{ route('certificate.record_download') }}";
            url = url + '?ids=' + selected;
            $(this).attr('href',url);
            window.open(url,);
        })
        function printDiv(file_url) {
            var divToPrint = document.getElementById('view_certificate');
            var newWin = window.open(file_url, 'Print-Window');
            newWin.document.open();
            newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
            newWin.document.close();
            setTimeout(function() {
                newWin.close();
            }, 10);

        }
    </script>
@endpush
@include('backEnd.partials.data_table_js')
@include('backEnd.partials.multi_select_js')
