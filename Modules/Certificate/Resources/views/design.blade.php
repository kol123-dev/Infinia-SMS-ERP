@extends('backEnd.master')
@section('title')
    {{ @$page_title }}
@endsection
@php
    $page_width = number_format(floatval($editData->width) * 3.7795275591, 2, '.', '');
    $page_height = number_format(floatval($editData->height) * 3.7795275591, 2, '.', '');
@endphp
@push('css')
    <link rel="stylesheet" href="{{ asset('Modules/Certificate/Resources/assets/css/editor.css') }}">
    <style>
        .view_certificate {
            width: 100%;
            height: 100vh;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .certificate_text {
            max-width: 98%;
        }

        //card-content

        .draggable {
            border: 2px dashed #8d8d8d;
            padding: 0px 5px;
            cursor: move;
            background-color: #15b57e33;
            /* top: 0; */
            width: auto;
            height: auto;
            max-width: {{ $page_width }}px;

        }

        .hidden-position {
            background-color: #ffffffba !important;
            border: 2px dashed #ff0000 !important;
        }
        .offer_title {
            font-size: 16px;
            font-weight: 500;
            color: #373737;
            margin-bottom: 0;
        }
    
        .certificate_container {
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
            <div class="price_loader"></div>
            <div class="white-box">
            @if (userPermission('certificate.template-create'))
                <div class="row">
                    <div class="offset-lg-9 col-lg-3 text-right col-md-12 mb-0">
                        <a href="{{ route('certificate.templates') }}" class="primary-btn small fix-gr-bg">
                            {{ _trans('certificate.Certificate List') }}
                        </a>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0">{{ _trans('certificate.Certificate Templates') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-20">
                        {{-- <div class="col-lg-12" style="height: 10px">

                        </div> --}}
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6 main-title">
                                    <h3 class="mb-0">
                                        {{ @$editData->layoutString }} -({{ @$page_width }} x {{ @$page_height }}) px
                                    </h3>
                                </div>
                                <div class="col-lg-6 text-lg-right mt-3 mt-lg-0">
                                    <a href="#" class="primary-btn small fix-gr-bg" id="elementStyle"
                                        data-toggle="modal" data-target="#editModal">
                                        <span class="ti-pencil-alt"></span>
                                        {{ _trans('certificate.Element Style') }}
                                    </a>
                                    <a href="{{ route('certificate.template_design_reset', $editData->id) }}"
                                        class="primary-btn small fix-gr-bg">
                                        {{ _trans('certificate.Reset Design') }}
                                    </a>
                                    <a href="#" class="primary-btn small fix-gr-bg" id="certificatePreview">
                                        <span class="ti-eye"></span>
                                        {{ _trans('certificate.Preview') }}
                                    </a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    @if (userPermission('certificate.template-store'))
                                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'certificate.template-store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'student_form']) }}
                                    @endif
                                    <div class="white-box">
                                        <div class="add-visitor">
                                            <div class="col-lg-12 mb-2 overflow-auto pb-2" id="certificate_content">
                                                @if (isset($editData->design) && $editData->design->design_content != null)
                                                    {!! $editData->design->design_content !!}
                                                @else
                                                    <div class="this-template"
                                                        style="width: {{ $page_width }}px; height: {{ $page_height }}px; position: relative;">
                                                        <img width="100%" src="{{ asset($editData->background_image) }}"
                                                            style=" position: absolute;">
                                                        @if (file_exists($editData->signature_image))
                                                            <div class="draggable box signature " data-el="signature"
                                                                style="position: absolute; width: 65px; height: 65px; text-align: center; font-size: 10px; top: 373.892px; left: 553.889px;">
                                                            <img src="{{asset($editData->signature_image)}}" class="signature_img" data-el="signature_img" style="position: revert; width: 65px; height: 65px;" alt="">
                                                        </div>
                                                        @endif
                                                        @if ($editData->user_photo_style == 1)
                                                            <div class="draggable box user_image" data-el="user_image"
                                                                style="position: absolute; width: {{ $editData->user_image_size ?? 100 }}px; height: {{ $editData->user_image_size ?? 100 }}px; cursive; font-size: 10px; top:13%; left: 10%;">
                                                                {user_image}
                                                            </div>
                                                        @else
                                                            <div class="draggable box user_image" data-el="user_image"
                                                                style="position: absolute; width: {{ $editData->user_image_size ?? 100 }}px; height: {{ $editData->user_image_size ?? 100 }}px; cursive; font-size: 10px; top:13%; left: 10%;">
                                                                {user_image}
                                                            </div>
                                                        @endif

                                                        @if ($editData->logo_image != null && file_exists($editData->logo_image))
                                                            <div class="draggable box logo_image" data-el="logo_image"
                                                                style="position: absolute; width: {{ $editData->user_image_size ?? 100 }}px; height: {{ $editData->user_image_size ?? 100 }}px; cursive; font-size: 10px; top: 373.92px; left: 59.9063px;">
                                                                {{-- {logo_image} --}}
                                                                <img src="{{asset($editData->logo_image)}}" class="logo_image_img" data-el="logo_image_img" style="position: revert; width: 65px; height: 65px;" alt="">
                                                            </div>
                                                        @endif
                                                        <div class="draggable issue_date" data-el="issue_date"
                                                            style="position: absolute; font-size: 10px; top: 74%; left: 12%;">
                                                            {issue_date}</div>
                                                        <div class="draggable certificate_name" data-el="certificate_name"
                                                            style="position: absolute; font-size: 10px; top: 33%; left: 44%;">
                                                            {certificate_name}</div>
                                                        <div class="draggable certificate_no" data-el="certificate_no"
                                                            style="position: absolute; font-size: 10px; top: 37%; left: 76%;">
                                                            {certificate_no}</div>
                                                        <div class="draggable certificate_text " data-el="certificate_text"
                                                            style="position: absolute; width: 85% ;top: 228.948px;left: 123.903px;">
                                                            {certificate_text}</div>

                                                        <div class="draggable box qrCode " data-el="qrCode"
                                                            style="position: absolute; width: {{ $editData->qr_image_size ?? 65 }}px; height: {{ $editData->qr_image_size ?? 65 }}px; text-align: center; font-size: 10px; top: 13%; left: 80%;">
                                                            {qrCode}
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <style>
                                                .draggable {
                                                    border: 2px dashed #8d8d8d;
                                                    padding: 0px 5px;
                                                    cursor: move;
                                                    background-color: #15b57e33;
                                                    width: auto;
                                                    height: auto;
                                                    /* max-width: {{ $page_width }}px; */

                                                }
                                            </style>
                                            @php
                                                $tooltip = '';
                                                if (userPermission('certificate.template-store')) {
                                                    $tooltip = '';
                                                } else {
                                                    $tooltip = 'You have no permission to add';
                                                }
                                            @endphp
                                            <div class="row" style="margin-top: 60px">
                                                <div class="col-lg-12 text-center">
                                                    <button class="primary-btn fix-gr-bg designSubmit"
                                                        data-toggle="tooltip" title="{{ @$tooltip }}">
                                                        <span class="ti-check"></span>
                                                        @if (isset($editData->design))
                                                            {{ _trans('common.update') }}
                                                        @else
                                                            {{ _trans('common.save') }}
                                                        @endif
                                                        {{ _trans('certificate.Design') }}
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
                <div class="content d-none">{!! $editData->content !!}</div>
                <div class="certificate_title d-none">{{ $editData->name }}</div>

                <div class="modal fade admin-query" id="previewModal">
                    <div class="modal-dialog modal_1000px modal-dialog-centered" style="max-width: 1200px">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">
                                    {{ _trans('certificate.Certificate Preview') }}
                                </h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">
                                <div class="certificate_modal_preview">

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal fade admin-query" id="editModal">
                    <div class="modal-dialog modal_1000px modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">
                                    {{ _trans('certificate.Element Style') }}
                                </h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="primary_input_label" for="">
                                            {{ _trans('certificate.Select Element') }}
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <select class="primary_select form-control" name="element_list">
                                            <option data-display=" {{ _trans('certificate.Select Element') }} *"
                                                value=""> {{ _trans('certificate.Select Element') }} *</option>
                                            <option value="certificate_name">Certificate Name</option>
                                            <option value="issue_date">Issue Date</option>
                                            <option value="certificate_no">Certificate No</option>
                                            @if (file_exists($editData->signature_image))
                                                <option value="signature">Signature</option>
                                            @endif
                                            @if (file_exists($editData->logo_image))
                                                <option value="logo_image">Logo Image</option>
                                            @endif
                                            {{-- <option value="user_image">User Image</option> --}}
                                        </select>

                                    </div>
                                </div>
                                <div class="row  mt-20 style_box" style="display: none">
                                    <div class="col-lg-4">
                                        <div class="primary_input">
                                            <label for="font_size">{{ _trans('certificate.Font Weight') }} <span
                                                    class="text-danger"></span></label>
                                            <select class="primary_select form-control" name="font-weight"
                                                id="font-weight" onchange="updateStyle()">
                                                <option data-display=" {{ _trans('certificate.Font Weight') }}"
                                                    value=""> {{ _trans('certificate.Font Weight') }}</option>
                                                <option value="100">100</option>
                                                <option value="200">200</option>
                                                <option value="300">300</option>
                                                <option value="400">400</option>
                                                <option value="500">500</option>
                                                <option value="600">600</option>
                                                <option value="700">700</option>
                                                <option value="bold">Bold</option>
                                                <option value="normal">Normal</option>
                                                <option value="lighter">Lighter</option>
                                                <option value="bolder">Bolder</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="primary_input">
                                            <label for="font_size">{{ _trans('certificate.Font') }} <span
                                                    class="text-danger"></span></label>
                                            <select class="primary_select form-control" name="font-family"
                                                id="font-family" onchange="updateStyle()">
                                                <option data-display=" {{ _trans('certificate.Font') }}" value=""> {{ _trans('certificate.Font') }}</option>
                                                <option value="Arial">Arial</option>
                                                <option value="Arial Black">Arial Black</option>
                                                <option value="Pinyon Script">Pinyon Script</option>
                                                <option value="Comic Sans MS">Comic Sans MS</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="primary_input">
                                            <label for="font_size">{{ _trans('certificate.Font size (px)') }} <span
                                                    class="text-danger"></span></label>
                                            <input class="primary_input_field form-control" type="number"
                                                onkeyup="updateStyle()" autocomplete="off" id="font_size"
                                                placeholder="{{ _trans('certificate.Font size') }}"value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row  mt-20 style_box" style="display: none">
                                    <div class="col-lg-4">
                                        <div class="primary_input">
                                            <label for="height">{{ _trans('certificate.Height (px)') }} <span
                                                    class="text-danger"></span></label>
                                            <input class="primary_input_field form-control" type="number"
                                                onkeyup="updateStyle()" autocomplete="off" id="height"
                                                placeholder="{{ _trans('certificate.Height (px)') }}"value="">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="primary_input">
                                            <label for="width">{{ _trans('certificate.Width (px)') }} <span
                                                    class="text-danger"></span></label>
                                            <input class="primary_input_field form-control" type="number"
                                                onkeyup="updateStyle()" autocomplete="off" id="width"
                                                placeholder="{{ _trans('certificate.Width (px)') }}"value="">
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <div class="primary_input">
                                            <label for="font_size">{{ _trans('certificate.Font Color') }} <span
                                                    class="text-danger"></span></label>
                                            <input class="primary_input_field form-control" type="color"
                                                onchange="updateStyle()" autocomplete="off" id="font_Color"
                                                placeholder="{{ _trans('certificate.Font size (px)') }}"value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row  mt-20" style="display: none">
                                    <div class="col-lg-12">
                                        <textarea name="" class="form-control" id="custom_css" cols="30" onkeyup="updateStyle()"
                                            rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12" style="min-height: 50px;">
                                    <div class="preview_element">

                                    </div>
                                </div>


                                <div class="mt-40 d-flex justify-content-between">
                                    <button type="button" class="primary-btn tr-bg"
                                        data-dismiss="modal">@lang('common.cancel')</button>
                                    <a href="#" class="text-light">
                                        <button class="primary-btn fix-gr-bg"
                                            data-dismiss="modal">{{ _trans('common.Done') }}</button>
                                    </a>
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
    <script src="{{ asset('Modules/Certificate/Resources/assets/js/jquery.draggableTouch.js') }}"></script>
    <script>
    

        function showLoader() {
            console.log('show');
            $('.price_loader').show();
        }

        function hideLoader() {
            $('.price_loader').hide();
        }

        $('input[name="canvas_mode"]').on('change', function() {
            let mode = $(this).val();
            if (mode == 1) {
                $(".draggable").draggableTouch("enable");
            } else {
                $(".draggable").draggableTouch("disable");
            }
            console.log(mode);
        })
        $('select[name="element_list"]').on('change', function() {
            $('.certificate_modal_preview').html('');
            let el = $(this).val();
            let element = $('#certificate_content').find(`[data-el="${el}"]`);
            let element_styles = element.attr('style');

            let font_weight = element.css('font-weight');
            let font_size = element.css('font-size');
            let font_color = element.css('color');
            let preview_element = $('.preview_element');

            //rgb to hex
            var rgb = font_color.replace(/\s/g, '').match(/^rgba?\((\d+),(\d+),(\d+)/i);
            font_color = (rgb && rgb.length === 4) ? "#" +
                ("0" + parseInt(rgb[1], 10).toString(16)).slice(-2) +
                ("0" + parseInt(rgb[2], 10).toString(16)).slice(-2) +
                ("0" + parseInt(rgb[3], 10).toString(16)).slice(-2) : font_color;

            $('#font-weight').val(font_weight);
            $('#font_size').val(font_size);
            $('#font_Color').val(font_color);

            console.log(font_weight, font_size, font_color);
            $('#font-weight').niceSelect('update');

            $('.style_box').show();

            element.attr('data-old_top', element.css('top'));
            element.attr('data-old_left', element.css('left'));
            element.css('top', '40%');
            element.css('left', '40%');
            preview_element.html(element.clone());
        })

        function updateStyle() {
            $('.certificate_modal_preview').html('');
            let target_element = $('select[name="element_list"]').val();
            let element = $('.this-template').find(`[data-el="${target_element}"]`);
            let font_weight = $('#font-weight').val();
            let font_size = $('#font_size').val();
            let font_color = $('#font_Color').val();
            let font_family = $('#font-family').val();
            let height = $('#height').val();
            let width = $('#width').val();
            let element_styles = element.attr('style');
            let preview_element = $('.preview_element');
            let new_style = '';
            if (font_weight != '') {
                new_style += `font-weight: ${font_weight};`;
            }
            if (font_size != '') {
                new_style += `font-size: ${font_size}px;`;
            }
            if (font_color != '') {
                new_style += `color: ${font_color};`;
            }
            if (font_family != '') {
                new_style += `font-family: ${font_family};`;
            }
            if (height != '') {
                new_style += `height: ${height}px;`;
            }
            if (width != '') {
                new_style += `width: ${width}px;`;
            }

            element.attr('style', element_styles + new_style);

            if (target_element=='signature') {
                let signature_img = $('.signature_img');
                signature_img.css('width', width+'px');
                signature_img.css('height', height+'px');
            }
            if (target_element=='logo_image') {
                let logo_image_img = $('.logo_image_img');
                logo_image_img.css('width', width+'px');
                logo_image_img.css('height', height+'px');
            }

            preview_element.html(element.clone());
        }

        $('#certificatePreview').on('click',function(){
            let content = $('#certificate_content').html();
            content = content.replaceAll('draggable', 'draggable_preview');
            content = content.replaceAll('hidden-position', 'd-none');

            showLoader();
            $.ajax({
                url: "{{ route('certificate.preview') }}",
                type: "POST",
                data: {
                    design_content: content,
                    template: "{{ @$editData->id }}",
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    console.log(response);
                    if (response.status == 'success') {

                        $('.certificate_modal_preview').html(response.data);
                        $('#previewModal').modal('show');
                        hideLoader();
                    } else {
                        toastr.error(response.message);
                        hideLoader();
                    }
                }
            })
        })
        function detectCertificateDivPosition() {
            let this_template = $('.this-template');
            let top_px = this_template.offset().top;
            let left_px = this_template.offset().left;
            let width_px = this_template.width();
            let height_px = this_template.height();
            let right_px = left_px + width_px;

            let position = {
                top: top_px,
                left: left_px,
                width: width_px,
                height: height_px,
                right: right_px
            }
            return position;
        }

        function elementPosition(el) {
            let element = $(el);
            let top_px = element.offset().top;
            let left_px = element.offset().left;
            let width_px = element.width();
            let height_px = element.height();
            let right_px = left_px + width_px;


            let parentDiv = $(".this-template");
            let childDiv = element;

            let parentWidth = parentDiv.width();
            let parentHeight = parentDiv.height();

            let childPosition = childDiv.position();

            let percentageTop = (childPosition.top / parentHeight) * 100;
            let percentageLeft = (childPosition.left / parentWidth) * 100;



            element.attr('data-top', percentageTop);
            element.attr('data-left', percentageLeft);

            //set element style top set as percentageTop
            element.css('top', percentageTop + '%')
            element.css('left', percentageLeft + '%')

            let position = {
                top: top_px,
                left: left_px,
                width: width_px,
                height: height_px,
                right: right_px
            }
            console.log(position);
            let parent_position = detectCertificateDivPosition();

            if (position.left <= parent_position.left || position.top <= parent_position.top || position.right >=
                parent_position.right) {
                console.log('out of the div');
                if (!element.hasClass('hidden-position')) {
                    element.addClass('hidden-position');
                }
            } else {
                console.log('in the div');
                if (element.hasClass('hidden-position')) {
                    element.removeClass('hidden-position');
                }
            }
        }
        $(document).ready(function() {
            let content = $('.content').html();
            let certificate_title = $('.certificate_title').html();
            $('.certificate_text').html(content);
            $('.certificate_name').html(certificate_title);
            $('.hidden-position').show();
            $(".draggable").draggableTouch();

            $(".draggable").on("dragstart", function(e, pos) {}).on("dragend", function(e, pos) {
                detectCertificateDivPosition();
                elementPosition(this);
            });


        });
        //editModal modal dismiss
        $('#editModal').on('hidden.bs.modal', function() {
            let target_element = $('select[name="element_list"]').val();
            let element = $('.this-template').find(`[data-el="${target_element}"]`);
            element.css('top', element.attr('data-old_top'));
            element.css('left', element.attr('data-old_left'));
        })
        $('.designSubmit').on('click', function(e) {
            e.preventDefault();
            //this button ti-check icon change to loader icon 
            let button= this.closest('button');
            button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';

            
            let _certificate_body = $('.content').html();
            let _certificate_name = $('.certificate_title').html();
            $('.certificate_text').html('{certificate_text}');
            $('.certificate_name').html('{certificate_name}');

            let content = $('#certificate_content').html();
            $.ajax({
                url: "{{ route('certificate.template_design_update') }}",
                type: "POST",
                data: {
                    design_content: content,
                    _token: "{{ csrf_token() }}",
                    template_id: "{{ @$editData->id }}"
                },
                success: function(response) {
                    console.log(response);
                    if (response.status == 'success') {
                        toastr.success(response.message);
                        button.innerHTML = '<span class="ti-check"></span> {{_trans("certificate.Save Design")}}';
                    } else {
                        toastr.error(response.message);
                        button.innerHTML = '<span class="ti-check"></span> {{_trans("certificate.Save Design")}}';
                    }
                }
            })
            $('.certificate_text').html(_certificate_body);
            $('.certificate_name').html(_certificate_name);
            //this button loader icon change to ti-check icon
            
        })
    </script>
@endpush
@include('backEnd.partials.data_table_js')
@include('backEnd.partials.multi_select_js')
