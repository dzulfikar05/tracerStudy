<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Tracer Study - Politeknik Negeri Malang</title>
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Base Styles */
        :root {
            --primary-color: #1a3c8f;
            --secondary-color: #ffcc00;
            --text-color: #333;
            --light-gray: #f8f9fa;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
            overflow-x: hidden;
        }

        /* Header Styles */
        .header {
            background-color: var(--secondary-color);
            padding: 10px 0;
        }

        .logo-container1 {
            display: flex;
            align-items: center;
        }

        .logo-container img {
            height: 40px;
            margin-right: 10px;
        }

        .logo-text {
            font-weight: bold;
            font-size: 1.2rem;
            margin: 0;
            line-height: 1.2;
        }

        .logo-text small {
            font-size: 0.7rem;
            display: block;
        }

        .logo-survey {
            width: 50px;
            /* Atur ukuran sesuai kebutuhan */
            height: auto;
            margin: 10px;
        }

        .nav-link {
            color: var(--text-color) !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            margin: 0 0.2rem;
        }

        .nav-link:hover {
            background-color: rgba(0, 0, 0, 0.05);
            border-radius: 4px;
        }


        /* Card styles */
        .card {
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s, box-shadow 0.2s;
            background-color: #F5F4F4;
            border: none;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 4px;
        }

        .btn-warning {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Hero Section */
        .btn-survey {
            background-color: white;
            color: var(--primary-color);
            padding: 0.5rem 2rem;
            border-radius: 30px;
            font-weight: 600;
            border: 2px solid var(--primary-color);
            transition: all 0.3s;
        }

        .btn-survey:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-survey-footer {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            padding: 0.5rem 2rem;
            border-radius: 30px;
            font-weight: 600;
            border: none;
            transition: all 0.3s;
        }

        .btn-survey-footer:hover {
            background-color: #e6b800;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .circle-image-container {
            position: relative;
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        .circle-bg {
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: var(--primary-color);
            border-radius: 50%;
            z-index: 1;
            top: 10px;
            left: 10px;
        }

        .circle-image {
            position: relative;
            width: 100%;
            padding-bottom: 100%;
            border-radius: 50%;
            overflow: hidden;
            z-index: 2;
        }

        .circle-image img {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* About Section */
        .about-section {
            padding: 4rem 0;
            background-color: var(--light-gray);
        }

        .section-title {
            font-weight: bold;
            font-size: 0.9rem;
            text-transform: uppercase;
            color: #777;
            margin-bottom: 1rem;
        }

        .about-title {
            font-weight: bold;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
        }

        .about-title span {
            color: var(--primary-color);
        }

        .about-text {
            font-size: 0.9rem;
            line-height: 1.6;
            color: #555;
        }

        .about-image {
            max-width: 100%;
            height: auto;
        }

        /* CTA Section */
        .cta-section {
            padding: 3rem 0;
            background-color: var(--primary-color);
            color: white;
        }

        .cta-text {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .cta-text span {
            color: var(--secondary-color);
        }

        /* Footer */
        .footer {
            padding: 3rem 0;
            background-color: var(--primary-color);
            color: white;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .footer-logo img {
            height: 40px;
            margin-right: 10px;
        }

        .footer-logo-text {
            font-weight: bold;
            font-size: 1.2rem;
            margin: 0;
            line-height: 1.2;
            color: white;
        }

        .footer-logo-text small {
            font-size: 0.7rem;
            display: block;
        }

        .footer h4 {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            color: white;
        }

        .footer-links {
            list-style: none;
            padding-left: 0;
        }

        .footer-links li {
            margin-bottom: 0.5rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: white;
        }

        .footer-contact {
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .social-icons {
            display: flex;
            margin-top: 1.5rem;
        }

        .social-icons a {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 0.5rem;
            transition: background-color 0.3s;
        }

        .social-icons a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .copyright {
            padding: 1rem 0;
            background-color: var(--secondary-color);
            text-align: center;
            font-size: 0.9rem;
        }

        /* Responsive Styles */
        @media (max-width: 991px) {
            .hero-section {
                padding: 3rem 0;
            }

            .circle-image-container {
                margin-bottom: 2rem;
            }

            .about-image {
                margin-top: 2rem;
            }
        }

        @media (max-width: 767px) {
            .hero-title {
                font-size: 1.8rem;
            }

            .feature-card {
                flex-direction: column;
            }

            .feature-number {
                margin-bottom: 1rem;
                margin-right: 0;
            }

            .cta-text {
                font-size: 1.2rem;
                margin-bottom: 1.5rem;
            }

        }
    </style>

</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <div class="logo-container1">
                        <img src="{{ asset('img/logos/Logo_Polinema.png') }}" alt="Logo_Polinema">
                        <img src="{{ asset('img/logos/Logo_Jti.png') }}" alt="Logo_Jti">
                        <h1 class="logo-text">
                            TRACER STUDY
                            <small>Politeknik Negeri Malang</small>
                        </h1>
                    </div>
                </div>
                <div class="col-md-8">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse"
                            data-target="#navbarNav">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item active">
                                    <!-- filepath: c:\laragon\www\tracerStudy\resources\views\survey\index.blade.php -->
                                    <a class="nav-link" href="{{ route('landingPage') }}">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#about">Tentang Tracer Study</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#survey">Isi Survey</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="content py-5">
        <div class="container">
            <h1 class="h3 mb-5 text-primary" style="font-weight: 900;">
                Kuesioner Tracer Study Politeknik Negeri Malang.
            </h1>

            <div class="survey-cards-vertical">
                <!-- Kuesioner Lulusan 1 -->
                <div class="card mb-4">
                    <div class="card-body py-4 px-4">
                        <h2 class="card-title h5 fw-bold mb-1">Kuesioner Lulusan</h2>
                        <div class="text-muted small mb-3">
                            <span>2024</span>
                            <span> / </span>
                            <span>Untuk Pengguna Lulusan</span>
                        </div>
                        <p class="card-text mb-3">
                            Ini adalah kuesioner untuk pengguna lulusan Tracer Study yang bertujuan untuk mendapatkan
                            umpan balik.
                        </p>
                        <a href="#" class="btn btn-primary px-4">Isi Kuesioner</a>
                    </div>
                </div>

                <!-- Kuesioner Lulusan 2 -->
                <div class="card mb-4">
                    <div class="card-body py-4 px-4">
                        <h2 class="card-title h5 fw-bold mb-1">Kuesioner Lulusan</h2>
                        <div class="text-muted small mb-3">
                            <span>2024</span>
                            <span> / </span>
                            <span>Untuk Pengguna Lulusan</span>
                        </div>
                        <p class="card-text mb-3">
                            Ini adalah kuesioner untuk pengguna lulusan Tracer Study yang bertujuan untuk mendapatkan
                            umpan balik.
                        </p>
                        <a href="#" class="btn btn-primary px-4">Isi Kuesioner</a>
                    </div>
                </div>

                <!-- Survey Pengguna Lulusan -->
                <div class="card mb-4">
                    <div class="card-body py-4 px-4">
                        <h2 class="card-title h5 fw-bold mb-1">Survey Pengguna Lulusan</h2>
                        <div class="text-muted small mb-3">
                            <span>2024</span>
                            <span> / </span>
                            <span>Untuk Pengguna Lulusan</span>
                        </div>
                        <p class="card-text mb-3">
                            Ini adalah survey untuk pengguna lulusan Tracer Study yang bertujuan untuk mengukur tingkat
                            kepuasan.
                        </p>
                        <a href="#" class="btn btn-primary px-4">Isi Survey</a>
                    </div>
                </div>
            </div>
    </main>


    <!-- CTA Section -->
    <section class="cta-section" id="survey">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="cta-text">Ayo sukseskan pelaksanaan <span>Tracer Study</span> Politeknik Negeri
                        Malang.</h3>
                </div>
                <div class="col-md-4 text-md-right">
                    <a href="#" class="btn btn-survey-footer">Isi Survey</a>
                </div>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="footer-logo">
                        <img src="{{ asset('img/logos/Logo_Polinema.png') }}" alt="Logo_Polinema">
                        <img src="{{ asset('img/logos/Logo_Jti.png') }}" alt="Logo_Jti">
                        <h1 class="footer-logo-text">
                            TRACER STUDY
                            <small>Politeknik Negeri Malang</small>
                        </h1>
                    </div>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>
                <div class="col-lg-3">
                    <h4>Kontak Kami</h4>
                    <div class="footer-contact">
                        Politeknik<br>
                        Negeri Malang<br>
                        Jl. Soekarno Hatta No.9,<br>
                        Jatimulyo, Kec.<br>
                        Lowokwaru, Malang
                    </div>
                    <div class="footer-contact">
                        humas@polinema.ac.id<br>
                        0341 - 404424/404425
                    </div>
                </div>
                <div class="col-lg-2">
                    <h4>Tautan Penting</h4>
                    <ul class="footer-links">
                        <li><a href="#">Isi Survey</a></li>
                        <li><a href="#">Politeknik Negeri Malang</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h4>Berita Terbaru</h4>
                    <ul class="footer-links">
                        <li><a href="#">Akses berita terbaru disini</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <div class="copyright">
        <div class="container">
            &copy; 2023 Tracer Study Politeknik Negeri Malang. All Rights Reserved.
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
</body>

</html>
