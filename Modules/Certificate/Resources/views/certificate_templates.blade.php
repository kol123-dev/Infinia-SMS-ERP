@extends('backEnd.master')
@section('title')
{{ @$page_title }}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('public/backEnd/multiselect/css/magicsuggest.css') }}">
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
                @if (userPermission('certificate.template-create'))
                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                            <a href="{{ route('certificate.template-create') }}" class="primary-btn small fix-gr-bg">
                                <span class="ti-plus pr-2"></span>
                                @lang('common.add')
                            </a>
                        </div>
                    </div>
                @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box">
                    <div class="row">
                        <div class="col-lg-4 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-15">{{ _trans('admin.Certificate Templates List')}}</h3>
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
                                            <th>{{ _trans('common.User Type') }}</th>
                                            <th>{{ _trans('common.Page Layout') }}</th>
                                            <th>{{ _trans('common.Background') }}</th>
                                            <th>{{ _trans('common.Status') }}</th>
                                            <th>@lang('common.action')</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($templates as $template)
                                            <tr>
                                                <td>{{ @$template->name }}</td>
                                                <td>{{ @$template->type->roleType}}</td>
                                                <td>{{ @$template->layoutString }}</td>
                                                <td>
                                                    <img src="{{asset($template->background_image)}}" width="100px" height="auto" alt="">
                                                </td>
                                                <td>
                                                    <label class="switch_toggle" for="active_checkbox{{@$template->id }}">
                                                        <input type="checkbox" class="status_enable_disable"
                                                            id="active_checkbox{{ @$template->id }}"
                                                            {{ @$template->status == 1 ? 'checked' : '' }}
                                                            value="{{ @$template->id }}">
                                                        <i class="slider round"></i>
                                                    </label>
                                                </td>
                                                <td>
                                                    @php
                                                        $routeList = [
                                                            userPermission('certificate.template_edit')
                                                                ? '  <a class="dropdown-item"
                                                                    href="' .
                                                                    route('certificate.template_edit', [$template->id]) .
                                                                    '">' .
                                                                    __('common.edit') .
                                                                    '</a>'
                                                                : null,
                                                            userPermission('certificate.template_design')
                                                                ? '  <a class="dropdown-item"
                                                                    href="' .
                                                                    route('certificate.template_design', [$template->id]) .
                                                                    '">' .
                                                                    _trans('certificate.Design') .
                                                                    '</a>'
                                                                : null,
                                                        
                                                            userPermission('certificate.template_delete')
                                                                ? '<a class="dropdown-item" data-toggle="modal"
                                                                    data-target="#deleteSectionModal' .
                                                                    $template->id .
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
                                            <div class="modal fade admin-query" id="deleteSectionModal{{ @$template->id }}">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">
                                                                {{_trans('certificate.Delete Certificate Template')}}
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
                                                                <a href="{{ route('certificate.template_delete', [@$template->id]) }}"
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
    <script src="{{ asset('public/backEnd/multiselect/js/magicsuggest.js') }}"></script>
    <script>
        $(function() {
            var ms1 = $('#short_codes').magicSuggest({
                data: ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Philadelphia', 'Phoenix',
                    'San Antonio', 'San Diego', 'Dallas', 'San Jose', 'Jacksonville'
                ],

            });
        });

        $('.short_code_select').niceSelete1();
    </script>
@endpush
@include('backEnd.partials.data_table_js')
@include('backEnd.partials.multi_select_js')
