<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $certificate->name }} {{ $certificate->layoutString }} ({{ $certificate->width }} X {{ $certificate->height }})
    </title>
    <link rel="stylesheet" href="{{ asset('Modules/Certificate/Resources/assets/css/editor.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/Certificate/Resources/assets/css/paper/normalize.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/Certificate/Resources/assets/css/paper/paper.css') }}">
    @php
        $settings = Modules\Certificate\Entities\CertificateSetting::where('school_id', Auth::user()->school_id)->pluck('value', 'key');

        $certificate_height=floatval($certificate->height);
        $certificate_width=floatval($certificate->width);
        $half_of_a4_sheet=297/2;
        $half_of_a4_sheet_height=210/2;

        //check is possible to print 2 certificate in a page
        if($certificate_height <= $half_of_a4_sheet_height && $certificate_width <= $half_of_a4_sheet){
            $is_possible_to_print_2_certificate_in_a_page=true;
        }else{
            $is_possible_to_print_2_certificate_in_a_page=false;
        }

    @endphp


    <style>
        .hidden-position {
            display: none;
        }

        text {
            display: none;
        }

        @page { size: A4
         }

        /* remove blank page in print */
        @page {
            size: auto;
            margin: 0;
        }

        @media print {
            body {
                width: 100%;
                margin: 0;
                padding: 0;
            }
            @page {
                size: A4
            }
        }

        .certificate:last-child {
            page-break-after: auto;
        }
        /* //for portrait certificate in a page 2 certificate */
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

            @if($certificate->layout == 3 && $settings['custom_page_break_after_certificate'] == 1)
                .this-template{
                    page-break-after: always;
                }
            @endif
            @if(!$is_possible_to_print_2_certificate_in_a_page && $settings['custom_page_break_after_certificate'] == 2)
                .this-template{
                    page-break-after: always;
                }
            @endif
            
        }
    </style>

</head>


<body class="A4">
    <div class="certificate">
        @foreach ($student_certificates as $std_certificate)
            {!! $std_certificate !!}
        @endforeach
    </div>



    <script src="{{ asset('/public/backEnd/vendors/js/jquery-3.2.1.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>

    <script>
        $(document).ready(function() {
        //jquery save .this-template save as image in public folder
        let count_certificate = $(".this-template").length;
        let time_for_each_certificate = 1000 * count_certificate;

        $(".this-template").each(function(index) {
            var currentDiv = $(this);
            // console.log(currentDiv);
            let certificate_details = $(this).find('.certificate_details');

            html2canvas(currentDiv[0]).then(function(canvas) {
                // Convert the canvas to a data URL (image)
                var imageDataURL = canvas.toDataURL("image/png");

                // Send the image data to the server using AJAX (you need to specify your server-side endpoint)
                $.ajax({
                    method: "POST",
                    url: "{{ route('certificate.certificate-save') }}",
                    data: {
                        image: imageDataURL,
                        certificate_details: certificate_details.val(),
                        template_id: "{{ $certificate->id }}",
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        // Handle the server's response
                        console.log("Image saved on the server:", response);
                    },
                    error: function(error) {
                        console.error("Error saving image on the server:", error);
                    }
                });
            });
        });

        setTimeout(function() {
            window.print();
            //if print is successful, redirect to the certificate list
            // window.onafterprint = function() {
            //     window.location.href = "{{ route('certificate.generate') }}";
            // }
        }, time_for_each_certificate);
        });
    </script>
</body>

</html>
