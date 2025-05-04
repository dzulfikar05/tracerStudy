<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracer Study - Politeknik Negeri Malang</title>
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
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
        
        .logo-container {
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
        
        /* Hero Section */
        .hero-section {
            padding: 4rem 0;
            background-color: white;
        }
        
        .hero-title {
            font-weight: bold;
            color: #333;
            margin-bottom: 1.5rem;
            font-size: 2rem;
        }
        
        .hero-title span {
            color: var(--primary-color);
            font-weight: bold;
        }
        
        .hero-subtitle {
            color: #666;
            margin-bottom: 2rem;
            font-size: 1rem;
        }
        
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
        
        /* Features Section */
        .features-section {
            padding: 4rem 0;
            background-color: white;
        }
        
        .feature-card {
            display: flex;
            margin-bottom: 2rem;
        }
        
        .feature-number {
            width: 60px;
            height: 60px;
            background-color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.5rem;
            margin-right: 1.5rem;
            flex-shrink: 0;
        }
        
        .feature-content h3 {
            font-weight: bold;
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }
        
        .feature-content p {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0;
        }
        
        /* Benefits Section */
        .benefits-section {
            padding: 4rem 0;
            background-color: var(--light-gray);
        }
        
        .benefits-title {
            font-weight: bold;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
        }
        
        .benefits-title span {
            color: var(--primary-color);
        }
        
        .benefits-text {
            font-size: 0.9rem;
            line-height: 1.6;
            color: #555;
        }
        
        /* Goals Section */
        .goals-section {
            padding: 4rem 0;
            background-color: white;
        }
        
        .goals-title {
            font-weight: bold;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
        }
        
        .goals-title span {
            color: var(--primary-color);
        }
        
        .goals-list {
            list-style: none;
            padding-left: 0;
        }
        
        .goals-list li {
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
        }
        
        .goals-list li i {
            color: var(--primary-color);
            margin-right: 0.5rem;
            margin-top: 0.3rem;
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
                    <div class="logo-container">
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
                        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarNav">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item active">
                                    <a class="nav-link" href="#">Home</a>
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

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="circle-image-container">
                        <div class="circle-bg"></div>
                        <div class="circle-image">
                            <img src="{{ asset('img/photos/GedungAA_Polinema.jpg') }}" alt="GedungAA_Polinema" class="illustration-img">
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <h1 class="hero-title">Selamat Datang Di Website <span>Tracer Study</span> Politeknik Negeri Malang.</h1>
                    <p class="hero-subtitle">Ayo sukseskan pelaksanaan <a href="#" class="text-primary">tracer study</a> Politeknik Negeri Malang.</p>
                    <a href="#survey" class="btn btn-survey">Isi Survey</a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="section-title">TENTANG TRACER STUDY</h2>
                    <h3 class="about-title">Apa itu <span>Tracer Study</span>?</h3>
                    <p class="about-text">
                        Tracer Study merupakan salah satu metode yang digunakan oleh perguruan tinggi untuk memperoleh umpan balik dari alumni. Umpan balik yang diperoleh dari alumni ini dibutuhkan untuk perbaikan serta pengembangan kualitas dan sistem pendidikan.
                    </p>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('img/photos/Illustrasi_Tracer.jpg') }}" alt="Illustrasi_Tracer" class="illustration-img">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="feature-card">
                        <div class="feature-number">01</div>
                        <div class="feature-content">
                            <h3>Database Alumni</h3>
                            <p>Sebagai database alumni terkini dan memudahkan pengiriman alumni.</p>
                        </div>
                    </div>
                    <div class="feature-card">
                        <div class="feature-number">02</div>
                        <div class="feature-content">
                            <h3>Kerja Sama</h3>
                            <p>Sebagai pintu masuk bagi program kerja sama dengan alumni dan perusahaan terkait alumni.</p>
                        </div>
                    </div>
                    <div class="feature-card">
                        <div class="feature-number">03</div>
                        <div class="feature-content">
                            <h3>Perbaikan</h3>
                            <p>Sebagai bahan masukan bagi program studi untuk melakukan perbaikan kurikulum.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h2 class="section-title">MANFAAT TRACER STUDY</h2>
                    <h3 class="benefits-title">Manfaat <span>Tracer Study</span></h3>
                    <p class="benefits-text">
                        Fokus tracer study (TS) yang dilakukan adalah untuk menelusuri alumni yang sudah bekerja atau berwirausaha. Manfaat yang didapat di bumi kerja sebagai bidang pekerjaan, dan dari pertama, hasil TS diharapkan dapat membantu perguruan tinggi untuk mengetahui keberhasilan proses pendidikan yang telah dilakukan terhadap anak didiknya. Kedua, membantu perguruan tinggi dalam melakukan need assessment survey pada external stakeholder untuk meminta secara spesifik tentang skill, kompetensi, dan pengetahuan apa saja yang diperlukan oleh dunia kerja. Ketiga, membantu perguruan tinggi dalam mengetahui relevansi kurikulum yang sudah diterapkan di perguruan tinggi dengan kebutuhan pasar tenaga kerja dan pengembangan profesional.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Goals Section -->
    <section class="goals-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="section-title">TUJUAN TRACER STUDY</h2>
                    <h3 class="goals-title"><span>Tracer Study</span> ditujukan untuk :</h3>
                    <ul class="goals-list">
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>Jaminan Kualitas</strong>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>Akreditasi</strong>
                                <p>Mendukung pengajuan tinggi dalam proses akreditasi, baik nasional maupun internasional.</p>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>Informasi Lulusan</strong>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('img/photos/Illustrasi_Tracer.jpg') }}" alt="Illustrasi_Tracer" class="illustration-img">
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section" id="survey">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="cta-text">Ayo sukseskan pelaksanaan <span>Tracer Study</span> Politeknik Negeri Malang.</h3>
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