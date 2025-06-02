@extends('backEnd.master')
@section('title')
    {{ @$page_title }}
@endsection
@push('css')
    {{-- <link rel="stylesheet" href="{{ asset('public/backEnd/multiselect/css/magicsuggest.css') }}"> --}}
@endpush
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{ @$page_title }}</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">{{ _trans('admin.Certificate') }}</a>
                    <a href="#">{{ @$page_title }}</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            @if (isset($editData))
                @if (userPermission('section_store'))
                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                            <a href="{{ url('section') }}" class="primary-btn small fix-gr-bg">
                                <span class="ti-plus pr-2"></span>
                                @lang('common.add')
                            </a>
                        </div>
                    </div>
                @endif
            @endif
            <div class="row">
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (userPermission('certificate.type_store'))
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'certificate.type_store', 'method' => 'POST']) }}
                            @endif
                            <div class="white-box">
                            <div class="main-title">
                                <h3 class="mb-15">
                                    @if (isset($editData))
                                        {{ _trans('common.edit') }}
                                    @else
                                        {{ _trans('common.add') }}
                                    @endif
                                    {{ _trans('admin.Certificate Type') }}
                                </h3>
                            </div>
                                <div class="add-visitor">
                                    @if (isset($parentSection))
                                        <input type="hidden" name="parentSection" value="{{ $parentSection }}">
                                    @endif
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label for="levelText">@lang('common.name') <span class="text-danger">
                                                        *</span></label>
                                                <input
                                                    class="primary_input_field form-control{{ @$errors->has('name') ? ' is-invalid' : '' }}"
                                                    type="text" name="name" autocomplete="off" id="levelText"
                                                    placeholder="{{ _trans('admin.Enter Certificate Type') }}"
                                                    value="{{ isset($editData) ? $editData->name : old('name') }}">
                                                <input type="hidden" name="id"
                                                    value="{{ isset($editData) ? $editData->id : '' }}">
                                                @if ($errors->has('name'))
                                                    <span class="text-danger">{{ @$errors->first('name') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 mb-30">
                                            <label class="primary_input_label" for="">
                                                {{ _trans('admin.Applicable For') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                            <select
                                                class="primary_select  form-control{{ $errors->has('role_id') ? ' is-invalid' : '' }}"
                                                name="role_id" id="select_role">
                                                <option data-display=" {{ _trans('admin.Applicable For') }} *"
                                                    value=""> {{ _trans('admin.Applicable For') }}*</option>
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


                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="primary_input_label" for="">
                                                {{ _trans('admin.Short Code') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                        </div>
                                        @php
                                            $short_code_array = isset($editData) ? json_decode($editData->short_code) : [];
                                        @endphp
                                        <div class="col-lg-6 radio-btn-flex">
                                            <input type="checkbox" id="select_all" 
                                                class="common-radio relationButton copy_per_th">
                                            <label for="select_all">{{ _trans('common.Select All') }}</label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row radio-btn-flex" id="user_short_codes" >

                                    </div>
                                    @if ($errors->has('short_code'))
                                        <span class="text-danger invalid-select" role="alert">
                                            {{ $errors->first('short_code') }}
                                        </span>
                                    @endif

                                    @php
                                        $tooltip = '';
                                        if (userPermission('certificate.type_store')) {
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
                                                @if (isset($section))
                                                    {{ _trans('common.update') }}
                                                @else
                                                    {{ _trans('common.save') }}
                                                @endif
                                                {{ _trans('admin.Certificate') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="white-box">
                    <div class="row">
                        <div class="col-lg-4 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-15">{{ _trans('admin.Certificate Types List') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <x-table>
                                <table id="table_id" class="table Crm_table_active3" cellspacing="0" width="100%">

                                    <thead>

                                        <tr>
                                            <th>{{ _trans('common.Name') }}</th>
                                            <th>{{ _trans('common.Role') }}</th>

                                            <th>@lang('common.action')</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($types as $type)
                                            <tr>
                                                <td>{{ @$type->name }}</td>
                                                <td>{{ @$type->roleType }}</td>
                                                <td>
                                                    @php
                                                        $routeList = [
                                                            userPermission('certificate.type_edit')
                                                                ? '  <a class="dropdown-item"
                                                                    href="' .
                                                                    route('certificate.type_edit', [$type->id]) .
                                                                    '">' .
                                                                    __('common.edit') .
                                                                    '</a>'
                                                                : null,

                                                            userPermission('certificate.type_delete')
                                                                ? '<a class="dropdown-item" data-toggle="modal"
                                                                        data-target="#deleteSectionModal' .
                                                                    $type->id .
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
                                            <div class="modal fade admin-query" id="deleteSectionModal{{ @$type->id }}">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">
                                                                {{ _trans('certificate.Delete Certificate Type') }}
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
                                                                <a href="{{ route('certificate.type_delete', [@$type->id]) }}"
                                                                    class="text-light">
                                                                    <button class="primary-btn fix-gr-bg"
                                                                        type="submit">@lang('common.delete')</button>
                                                                </a>
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
            </div>
        </div>
    </section>
@endsection
@push('script')
    {{-- <script src="{{ asset('public/backEnd/multiselect/js/magicsuggest.js') }}"></script> --}}
    <script>
        let staff_short_codes = `
            @foreach ($staff_short_codes as $key => $short_code)
            <div class="col-lg-6" >
                                                <input type="checkbox" name="short_code[]"
                                                    id="applicable_for_{{ $key }}"
                                                    class="common-radio relationButton short_code copy_per_th"
                                                    value="{{ $short_code }}">
                                                <label for="applicable_for_{{ $key }}"
                                                    id="applicable_for_{{ $key }}">{{ Str::upper(Str::replace('_', ' ', $short_code)) }}</label>
                                            </div>
            @endforeach
        `;

        let student_short_codes = `
            
            @foreach ($short_codes as $key => $short_code)
            <div class="col-lg-6" >
                                                <input type="checkbox" name="short_code[]"
                                                    id="applicable_for_{{ $key }}"
                                                    class="common-radio relationButton short_code copy_per_th"
                                                    value="{{ $short_code }}">
                                                <label for="applicable_for_{{ $key }}"
                                                    id="applicable_for_{{ $key }}">{{ Str::upper(Str::replace('_', ' ', $short_code)) }}</label>
                                            </div>
            @endforeach
        `;

        $('#select_role').on('change', function() {
            let select_role = $(this).val();
            $('#user_short_codes').empty();


            if (select_role == 2) {
                $('#user_short_codes').append(student_short_codes);
            } else if (select_role == 3) {
                $('#user_short_codes').append(staff_short_codes);
            } else {
                $('#user_short_codes').empty();
            }

            let selected_short_codes = @json($short_code_array);

            selected_short_codes.forEach(function(short_code) {
                $('#user_short_codes').find('input[value="' + short_code + '"]').prop('checked', true);
            })

        })

        $('#user_short_codes').on('change', function() {
            checkAllCheckbox();
        })
        $(document).ready(function() {
            $('#select_role').trigger('change');
            checkAllCheckbox();
        })

        function checkAllCheckbox() {
            let short_code_length = $('#user_short_codes').find('input[type="checkbox"]').length;
            let checked_length = $('#user_short_codes').find('input[type="checkbox"]:checked').length;
            if (short_code_length == checked_length && short_code_length != 0) {
                $('#select_all').prop('checked', true);
            } else {
                $('#select_all').prop('checked', false);
            }
        }
        $('#select_all').on('change', function() {
            if ($(this).is(':checked')) {
                $('#user_short_codes').find('input[type="checkbox"]').prop('checked', true);
            } else {
                $('#user_short_codes').find('input[type="checkbox"]').prop('checked', false);
            }
        })
    </script>
@endpush
@include('backEnd.partials.data_table_js')
@include('backEnd.partials.multi_select_js')
