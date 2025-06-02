@extends('backEnd.master')
@section('title')
    @lang('admin.generate_certificate')
@endsection

@section('mainContent')
    <style>
        table.dataTable thead .sorting_asc::after {
            left: 38px !important;
        }
    </style>
    <section class="sms-breadcrumb mb-20 up_breadcrumb">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1> @lang('admin.generate_certificate')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">{{ _trans('certificate.Certificate') }}</a>
                    <a href="#">@lang('admin.generate_certificate')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'certificate.generate-staff-certificate-search', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
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
                        <div class="row">
                            <input type="hidden" name="url" id="url" value="{{ URL::to('/') }}">
                            
                                <div class="col-lg-6 mt-30-md">
                                    <label class="primary_input_label" for="">{{_trans('certificate.Role')}} <span
                                            class="text-danger"> *</span></label>
                                    <select
                                        class="primary_select  form-control {{ @$errors->has('role') ? ' is-invalid' : '' }}"
                                        id="select_role" name="role">
                                        <option data-display="{{_trans('certificate.Select Role')}}*" value="">
                                            {{_trans('certificate.Select Role')}} *</option>
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
                                        name="certificate" id="certificate">
                                        <option data-display="@lang('admin.select_certificate') *" value="">
                                            @lang('admin.select_certificate') *</option>
                                        @foreach ($templates as $template)
                                            <option value="{{ @$template->id }}" {{ isset($certificate_id) ? ($certificate_id == $template->id ? 'selected' : '') : (old('certificate') == $template->id ? 'selected' : '') }}> {{ @$template->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('certificate'))
                                        <span class="text-danger invalid-select" role="alert">
                                            {{ @$errors->first('certificate') }}
                                        </span>
                                    @endif
                                </div>
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


    @if (isset($users))
        <section class="admin-visitor-area up_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row mt-40">
                    <div class="col-lg-12">
                        <div class="white-box">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                @if(!empty($existing_certificate))
                                    <div class="alert alert-warning">
                                       {{_trans('certificate.Previously Generated Certificate need to be deleted before generating new one')}}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2 no-gutters">
                                <div class="main-title">
                                    <h3 class="mb-15">
                                        {{_trans('certificate.Staff List')}}
                                    </h3>
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <a href="#" id="genearte-certificate"
                                    class="primary-btn small fix-gr-bg" style="display: none">
                                    @lang('admin.generate')
                                </a>
                            </div>
                        </div>

                        

                        <div class="row">
                            <div class="col-lg-12">
                                <x-table>
                                    <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="10%">
                                                    <input type="checkbox" id="checkAll"
                                                        class="common-checkbox generate-certificate-print-all"
                                                        name="checkAll"
                                                        value="">
                                                    <label for="checkAll">@lang('admin.all')</label>
                                                </th>
                                                <th>{{_trans('certificate.Staff ID')}}</th>
                                                <th>{{_trans('certificate.Name')}}</th>
                                                <th>{{_trans('certificate.Department')}}</th>
                                                <th>{{_trans('certificate.Designation')}}</th>
                                                <th>{{_trans('certificate.Joining Date')}}</th>
                                                <th>{{_trans('certificate.Mobile')}}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($users as $user)
                                            {{-- @dd($user->staff); --}}
                                                <tr>
                                                    <td>
                                                        @if(in_array($user->id , $existing_certificate))
                                                            <p>
                                                                <span class="small text-danger border-0">
                                                                    {{_trans('certificate.Generated')}}
                                                                </span>
                                                            </p>
                                                        @else
                                                        <input type="checkbox" id="student.{{ @$user->id }}"
                                                                class="common-checkbox generate-certificate-select"
                                                                name="student_checked[]" value="{{ @$user->id }}">
                                                            <label for="student.{{ @$user->id }}"></label>
                                                        @endif
                                                        
                                                    </td>
                                                    <td>{{ @$user->staff->staff_no }}</td>
                                                    <td>{{ @$user->full_name }}</td>
                                                    <td>{{ @$user->staff != '' ? @$user->staff->departments->name : '' }}</td>
                                                    <td>{{ @$user->staff != '' ? @$user->staff->designations->title : '' }}</td>
                                                    <td>{{ @$user->staff->date_of_joining != '' ? dateConvert(@$user->staff->date_of_joining) : '' }}</td>
                                                    <td>{{ @$user->staff->mobile }}</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </x-table>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif


@endsection
@include('backEnd.partials.data_table_js')

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
       
        function checkSelectStd(){
            if ($('.generate-certificate-select:checked').length > 0) {
                console.log('show');
                $('#genearte-certificate').show();
            } else {
                console.log('hide');
                $('#genearte-certificate').hide();
            }
        }

        $('#genearte-certificate').on('click', function() {
            var staffs = [];
            $('.generate-certificate-select:checked').each(function() {
                staffs.push($(this).val());
            });
            var selected_class = $('#select_class').val();
            var section = "{{ isset($section_id) ? $section_id : 0 }}";
            // console.log('value: '+section);
            var exam = $('#exam').val();
            var certificate = $('#certificate').val();
            var url = $('#url').val();
            if (staffs.length > 0) {
                window.open(url + '/certificate/generate-certificate-staff?staffs=' + staffs + '&certificate=' + certificate, '_blank');
            }
        });
       
    </script>
@endpush
