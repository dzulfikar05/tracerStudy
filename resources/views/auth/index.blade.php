<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="{{ asset('img/icons/icon-48x48.png') }}" />

    <title>App Starter</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/light.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- DataTables -->
    <link href="{{ asset('plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">

    <!-- Sweet Alert -->
    <link href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/select2/select2.min.css') }}" rel="stylesheet">

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

    <style>
        .btn-ungu {
            background-color: #2B00D7;
            color: white;
        }
        .btn-ungu:hover {
            background-color: #2704b5;
            color: white;
        }
    </style>
</head>

<body data-theme="colored" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default"
    style="font-family: 'Poppins'">
    <section class="welcome-container">
        <div>
            <h1 class="fw-bold text-primary">Selamat Datang di <span class="text-dark">Tracer Study</span></h1>
            <p class="mt-3">Temukan peluang karir terbaik dan tetap terhubung dengan almamater Anda.</p>
            <div class="mt-4">
                <a href="{{ route('auth.login') }}" class="btn btn-custom">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary ms-3">Register</a>
            </div>
        </div>
    </section>

    <script src="{{ asset('js/app.js') }}"></script>

    @include('auth.javascript')

    <script src="{{ asset('js/app.js') }}"></script>

    <!-- DataTables -->
    <script src="{{ asset('plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- Sweet Alerts -->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- Block UI -->
    <script src="{{ asset('plugins/blockui-master/jquery.blockUI.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/select2.min.js') }}"></script>

    <script src="{{ asset('assets/helpers/helper.js') }}"></script>

</body>

</html>
