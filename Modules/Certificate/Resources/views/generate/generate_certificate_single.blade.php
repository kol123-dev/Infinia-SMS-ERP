<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $certificate->name }} ({{ $certificate->width }} X {{ $certificate->height }})</title>
    <link rel="stylesheet" href="{{ asset('Modules/Certificate/Resources/assets/css/editor.css') }}">
    @php
        $settings=Modules\Certificate\Entities\CertificateSetting::where('school_id',Auth::user()->school_id)->pluck('value','key');
    @endphp
    <style>
        .hidden-position {
            display: none;
        }

        text {
            display: none;
        }


        @page {
            margin: -2px;
        }

        @media print {
            .page {
                margin: -2px;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                /* background: initial; */
                /* page-break-after: always; */
                vertical-align: middle;
            }

            .certificate {
                /* width: 296mm;
                height: 210mm; */
                width: {{ $certificate->width }};
                height: {{ $certificate->height }};

                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                vertical-align: middle;
                
            }

            @if($certificate->layout == 1 && $settings['portrait_certificate_in_a_page'] == 1)
                .this-template{
                    page-break-after: always;
                }
            @endif
            
        }
    </style>

</head>


<body>
    <div class="certificate">
        {!! $certificate_content !!}
    </div>

 
</body>

</html>
