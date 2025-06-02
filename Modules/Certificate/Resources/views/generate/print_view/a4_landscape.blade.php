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
    @endphp
    <style>
        .hidden-position {
            display: none;
        }

        text {
            display: none;
        }

        /* @page { size: A4 landscape } */

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
        }

        .sheet:last-child {
            page-break-after: auto;
        }
    </style>

</head>


<body class="A4 landscape">
    <div class="certificate ">
        @foreach ($student_certificates as $std_certificate)
            <section class="sheet">
                {!! $std_certificate !!}
            </section>
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
