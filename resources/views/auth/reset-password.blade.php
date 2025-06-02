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
    <link rel="shortcut icon" href="{{ asset('img/icons/LogoTracerOrange.png') }}" />

    <title>Reset Password</title>

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
        .overlay {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background-color: rgba(255, 255, 255, 0.5); /* transparansi putih */
    z-index: 0;
}

    </style>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>

</head>

<body style="background: url('{{ asset('img/gedung_jti.png') }}') no-repeat center center fixed; background-size: cover; font-family: 'Poppins'; position: relative;">
    <div class="overlay"></div>
    <div class="d-flex align-items-center justify-content-center vh-100 position-relative" style="z-index: 1;">
        <div class="card shadow-lg p-4" style="width: 100%; max-width: 500px; border-radius: 12px;">
            <h3 class="text-center fw-bold mb-4"><span class="text-dark">Reset</span> <span class="text-primary">Password</span></h3>
            <form action="javascript:onReset(this)" method="post" id="form_reset" name="form_reset" autocomplete="off">
                @csrf
                <input type="hidden" name="email" id="email" value="{{ $email }}">
                <input type="hidden" name="token" id="token" value="{{ $token }}">
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input class="form-control form-control-lg" type="password" name="password" id="password" placeholder="Enter new password" required />
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input class="form-control form-control-lg" type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm new password" required />
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100">Reset Password</button>
            </form>
        </div>
    </div>

    </section>

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
