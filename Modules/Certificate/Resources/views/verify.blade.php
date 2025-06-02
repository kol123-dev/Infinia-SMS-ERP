@php $page_title="All about Infix School management system; School management software"; @endphp
@extends('frontEnd.home.front_master')
@push('css')
    <link rel="stylesheet" href="{{ asset('public/') }}/frontend/css/new_style.css" />
    <link rel="stylesheet" href="{{ url('/public/') }}/landing/css/toastr.css">
    <link rel="stylesheet" href="{{ url('/public/') }}/backEnd/assets/vendors/static_style2.css">
    <link rel="stylesheet" href="{{ url('/public/') }}/backEnd/assets/vendors/vendors_static_style.css">
@endpush
@section('main_content')
    <section class="container box-1420">
        <div class="banner-area"
            style="background: linear-gradient(0deg, rgba(124, 50, 255, 0.6), rgba(199, 56, 216, 0.6)), url({{ @$page->image != '' ? @$page->image : '../img/client/common-banner1.jpg' }}) no-repeat center;">
            <div class="banner-inner">
                <div class="banner-content">
                    <h2>{{ _trans('certificate.Verify Certificate') }}</h2>
                    <p>
                        {{ _trans('certificate.Use the form below to verify your certificate') }}
                    </p>
                </div>
            </div>
        </div>
    </section>
    <style>
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
    
   
    <!--================ Start Facts Area =================-->
    <section class="fact-area section-gap" style="padding: 25px 0px;">
        <div class="container">
            <form method="post" action="{{ route('certificate.get-verify-certificate') }}" id="verification_form">
                <div class="row align-items-center" style="background-color: #edeff6; padding: 25px;">
                    @csrf
                    <div class="offset-3 col-lg-4 mt-30-md md_mb_20">
                        <div class="primary_input">
                            <label class="primary_input_label"
                                for="">{{ _trans('certificate.Certificate Number') }}<span class="text-danger">
                                    *</span></label>
                            <input
                                class="primary_input_field form-control{{ $errors->has('certificate_number') ? ' is-invalid' : '' }}"
                                placeholder="{{ _trans('certificate.Certificate Number') }}*" type="text"
                                name="certificate_number" value="{{isset($certificate_record) ? $certificate_record->certificate_number : ''}}">
                        </div>
                        @if ($errors->has('certificate_number'))
                            <span class="text-danger invalid-select" role="alert">
                                {{ $errors->first('certificate_number') }}
                            </span>
                        @endif
                    </div>
                    <div class="col-lg-4 mt-20" style="margin-top: 30px;">
                        <button type="submit" class="primary-btn small fix-gr-bg">
                            <span class="ti-search"></span>
                            {{ _trans('certificate.Verify') }}
                        </button>
                    </div>
                </div>
            </form>

            <div class="row align-items-center certificate_container" style="background-color: #edeff6; padding: 25px;">
                <div class="col-lg-12" id="certificate_body" style="text-align: center;">
                    @if(isset($certificate_record))
                        <img src="{{ asset($certificate_record->certificate_path) }}" style="width: 100%; height: auto;">
                        <a href="{{ asset($certificate_record->certificate_path) }}" class="primary-btn small fix-gr-bg" style="margin-top: 10px;" download>
                            <span class="ti-download"></span>
                            Download</a>
                    @else
                        <h3>
                            Please enter valid certificate number to verify your certificate
                        </h3>
                    @endif
                </div>
                <div class="price_loader"></div>
            </div>

        </div>
    </section>
    <!--================ End Facts Area =================-->
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('public/backEnd/') }}/vendors/js/toastr.min.js"></script>
    {!! Toastr::message() !!}

    <script>
        function showLoader() {
            $('.price_loader').show();
        }

        function hideLoader() {
            $('.price_loader').hide();
        }


        $(document).ready(function() {
            $('#verification_form').on('submit', function(e) {
                e.preventDefault();
                showLoader();
                var url = $(this).attr('action');
                var formData = $(this).serialize();
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(data) {
                        if (data.status == 'success') {
                            let certificate_path = data.data.certificate_path;
                            var image =
                                `<img src="{{ asset('${certificate_path}') }}" style="width: 100%; height: auto;">`;
                                //download button
                                image += `<a href="{{ asset('${certificate_path}') }}" class="primary-btn small fix-gr-bg" style="margin-top: 10px;" download>
                                    <span class="ti-download"></span>
                                    Download</a>`;
                            $('#certificate_body').html(image);
                        } else {
                            toastr.error(data.message);
                            $('#certificate_body').html('');
                        }
                        hideLoader();
                    },
                    error: function(data) {
                        let errors = data.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            toastr.error(value);
                        });
                        hideLoader();
                    }
                });
            });
        });
    </script>
@endsection
