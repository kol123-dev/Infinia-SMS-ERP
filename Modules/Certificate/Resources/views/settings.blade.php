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
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (userPermission('certificate.settings-store'))
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'certificate.settings-store', 'method' => 'POST']) }}
                            @endif
                            <div class="white-box">
                                <div class="add-visitor">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="primary_input">
                                                <label for="levelText"> {{_trans('certificate.Certificate Number Prefix')}}
                                                </label>
                                                <input class="primary_input_field form-control" type="text" name="key_value[prefix]" autocomplete="off" id="levelText" placeholder="{{_trans('admin.Enter Certificate Number Prefix')}}"
                                                    value="{{ isset($settings) ? $settings->where('key','prefix')->first()->value : old('key_value.prefix') }}">
                                            </div>
                                        </div>
                                        {{-- <div class="col-lg-6">
                                            <div class="primary_input">
                                                <label for="levelText"> {{_trans('certificate.Certificate Per Page (Portrait)')}}
                                                </label>
                                                <input class="primary_input_field form-control" type="number" name="key_value[portrait_certificate_in_a_page]" max="2" min="1" autocomplete="off" id="levelText" placeholder="{{_trans('certificate.Certificate Per Page (Portrait)')}}"
                                                    value="{{ isset($settings) ? $settings->where('key','portrait_certificate_in_a_page')->first()->value : old('key_value.portrait_certificate_in_a_page') }}">
                                            </div>
                                        </div> --}}
                                        <div class="col-lg-6">
                                            <div class="primary_input">
                                                <label for="levelText"> {{_trans('certificate.Page break after certificate (Custom Layout)')}}
                                                </label>
                                                <select
                                                class="primary_select form-control{{ $errors->has('status') ? ' is-invalid' : '' }}"
                                                name="key_value[custom_page_break_after_certificate]">
                                                <option data-display=" {{ _trans('certificate.Page break after certificate (Custom Layout)') }} *"value=""> {{ _trans('certificate.Page break after certificate (Custom Layout)') }} *</option>
                                                <option value="1" {{ isset($settings) ? ($settings->where('key','custom_page_break_after_certificate')->first()->value== 1 ? 'selected' : '') : '' }}> {{ _trans('certificate.Yes') }} </option>
                                                <option value="0" {{ isset($settings) ? ($settings->where('key','custom_page_break_after_certificate')->first()->value== 0 ? 'selected' : '') : '' }}> {{ _trans('certificate.No') }} </option>
                                                <option value="2" {{ isset($settings) ? ($settings->where('key','custom_page_break_after_certificate')->first()->value== 2 ? 'selected' : '') : 'selected' }}> {{ _trans('certificate.Auto') }} </option>
                                              

                                            </select>
                                            </div>
                                        </div>

                                    </div>
                                    @php
                                        $tooltip = '';
                                        if (userPermission('certificate.settings-store')) {
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
                                                 {{ _trans('common.update') }} {{ _trans('certificate.Settings') }}
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
    </section>
@endsection
@include('backEnd.partials.data_table_js')
@include('backEnd.partials.multi_select_js')
