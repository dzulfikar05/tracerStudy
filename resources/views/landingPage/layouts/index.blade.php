<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Tracer Study - Politeknik Negeri Malang</title>
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Sweet Alert -->
    <link href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">

    <!-- Select2 -->
    <link href="{{ asset('plugins/select2/select2.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --bs-primary: #15359E;
        }

        .btn-primary {
            background-color: #15359E !important;
            border-color: #15359E !important;
        }

        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active {
            background-color: #0f2979 !important;
            /* lebih gelap dari #15359E */
            border-color: #0f2979 !important;
        }

        .bg-primary {
            background-color: #15359E !important;
        }

        .text-primary {
            color: #15359E !important;
        }
    </style>

    <style>
        body {
            font-family: 'Poppins', sans-serif !important;
        }
    </style>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>


    @include('landingPage.layouts.style')

</head>

<body>
    <!-- Header -->
    @include('landingPage.layouts.header')

    {!! $content !!}

    <!-- Footer -->
    @include('landingPage.layouts.footer')


    <!-- jQuery and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Smooth scrolling for anchor links
            $('a[href^="#"]').on('click', function(event) {
                if (this.hash !== "") {
                    event.preventDefault();

                    var hash = this.hash;

                    $('html, body').animate({
                        scrollTop: $(hash).offset().top - 70
                    }, 800);
                }
            });

            // Add animation to sections
            $(window).scroll(function() {
                $('.feature-card, .about-title, .benefits-title, .goals-title').each(function() {
                    var position = $(this).offset().top;
                    var scroll = $(window).scrollTop();
                    var windowHeight = $(window).height();

                    if (scroll > position - windowHeight + 100) {
                        $(this).addClass('animated fadeInUp');
                    }
                });
            });

            // Navbar active state
            $('.navbar-nav .nav-link').on('click', function() {
                $('.navbar-nav .nav-link').removeClass('active');
                $(this).addClass('active');
            });

            // Mobile menu collapse on click
            $('.navbar-nav .nav-link').on('click', function() {
                $('.navbar-collapse').collapse('hide');
            });
        });
    </script>

    <!-- Sweet Alerts -->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- Block UI -->
    <script src="{{ asset('plugins/blockui-master/jquery.blockUI.js') }}"></script>

    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/select2.min.js') }}"></script>

    <!-- Helper Functions -->
    <script src="{{ asset('assets/helpers/helper.js') }}"></script>
</body>

</html>
