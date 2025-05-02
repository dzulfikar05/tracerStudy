<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracer Study - Politeknik Negeri Malang</title>
    <meta name="description"
        content="Tracer Study untuk alumni Politeknik Negeri Malang - Membangun Karir dan Memperkuat Jaringan Alumni">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        ul {
            list-style: none;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Header */
        header {
            background-color: #FFCC00;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
        }

        .logo-title {
            font-weight: 700;
            font-size: 1.125rem;
            line-height: 1.2;
        }

        .logo-subtitle {
            font-size: 0.75rem;
            line-height: 1.2;
        }

        nav {
            display: none;
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
        }

        .nav-link {
            font-weight: 500;
            position: relative;
            padding: 0.25rem 0;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #2563EB;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .mobile-menu-btn {
            padding: 0.5rem 1rem;
            background-color: transparent;
            border: 1px solid #000;
            border-radius: 0.25rem;
            font-weight: 500;
            cursor: pointer;
        }

        /* Hero Section */
        .hero {
            padding: 4rem 1rem;
            background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), url('https://via.placeholder.com/1920x1080') center/cover no-repeat;
        }

        .hero-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2rem;
        }

        .hero-image-container {
            position: relative;
            width: 100%;
            max-width: 400px;
            aspect-ratio: 1/1;
        }

        .hero-image-bg {
            position: absolute;
            inset: 0;
            background-color: #2563EB;
            border-radius: 50%;
            transform: rotate(-6deg);
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.3);
        }

        .hero-image {
            position: absolute;
            inset: 0;
            overflow: hidden;
            border-radius: 50%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .hero-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .hero-image:hover img {
            transform: scale(1.05);
        }

        .hero-content {
            width: 100%;
            text-align: center;
        }

        .hero-title {
            font-size: 1.875rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .hero-title span {
            color: #2563EB;
            position: relative;
            display: inline-block;
        }

        .hero-title span::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 4px;
            bottom: -4px;
            left: 0;
            background-color: #FFCC00;
            border-radius: 2px;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .hero-text {
            margin-bottom: 1.5rem;
            font-size: 1.125rem;
        }

        .hero-text span {
            color: #2563EB;
            font-weight: 600;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 2rem;
            border-radius: 9999px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            z-index: -1;
        }

        .btn:hover::before {
            left: 0;
        }

        .btn-primary {
            background-color: #2563EB;
            color: white;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.4);
        }

        .btn-primary:hover {
            background-color: #1D4ED8;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.5);
        }

        .btn-yellow {
            background-color: #FFCC00;
            color: black;
            box-shadow: 0 4px 14px rgba(255, 204, 0, 0.4);
        }

        .btn-yellow:hover {
            background-color: #E6B800;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 204, 0, 0.5);
        }

        /* About Section */
        .about {
            padding: 6rem 1rem;
            background-color: #f8fafc;
        }

        .about-container {
            display: flex;
            flex-direction: column;
            gap: 3rem;
        }

        .section-label {
            text-transform: uppercase;
            font-size: 0.875rem;
            font-weight: 600;
            color: #6B7280;
            margin-bottom: 0.5rem;
            letter-spacing: 1.5px;
            position: relative;
            display: inline-block;
            padding-left: 1rem;
        }

        .section-label::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 100%;
            background-color: #2563EB;
            border-radius: 2px;
        }

        .section-title {
            font-size: 1.875rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .section-title span {
            color: #2563EB;
            position: relative;
            display: inline-block;
        }

        .section-title span::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 4px;
            bottom: -4px;
            left: 0;
            background-color: #FFCC00;
            border-radius: 2px;
        }

        .about-text {
            color: #4B5563;
            margin-bottom: 1.5rem;
            line-height: 1.7;
            font-size: 1.05rem;
        }

        .about-image {
            position: relative;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .about-image img {
            width: 100%;
            height: auto;
            transition: transform 0.5s ease;
        }

        .about-image:hover img {
            transform: scale(1.05);
        }

        /* Features Section */
        .features {
            padding: 6rem 1rem;
        }

        .features-container {
            display: grid;
            gap: 3rem;
        }

        .feature-item {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 2.5rem;
            transition: transform 0.3s ease;
        }

        .feature-item:hover {
            transform: translateY(-5px);
        }

        .feature-number {
            flex-shrink: 0;
            width: 4rem;
            height: 4rem;
            border-radius: 50%;
            background-color: #2563EB;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.25rem;
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3);
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        .feature-number::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0) 70%);
            z-index: -1;
        }

        .feature-content h3 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: #1a202c;
        }

        .feature-content p {
            color: #4B5563;
            line-height: 1.7;
        }

        .benefits-text {
            color: #4B5563;
            margin-bottom: 1.5rem;
            line-height: 1.7;
            font-size: 1.05rem;
        }

        /* Purpose Section */
        .purpose {
            padding: 6rem 1rem;
            background-color: #f8fafc;
        }

        .purpose-container {
            display: flex;
            flex-direction: column;
            gap: 3rem;
        }

        .purpose-list {
            margin-top: 2rem;
        }

        .purpose-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease;
        }

        .purpose-item:hover {
            transform: translateX(10px);
        }

        .purpose-marker {
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 50%;
            background-color: #2563EB;
            margin-top: 0.25rem;
            flex-shrink: 0;
            box-shadow: 0 3px 8px rgba(37, 99, 235, 0.3);
        }

        .purpose-content h4 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #1a202c;
        }

        .purpose-content p {
            color: #4B5563;
            line-height: 1.7;
        }

        .purpose-image {
            position: relative;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .purpose-image img {
            width: 100%;
            height: auto;
            transition: transform 0.5s ease;
        }

        .purpose-image:hover img {
            transform: scale(1.05);
        }

        /* CTA Section */
        .cta {
            background-color: #1E40AF;
            color: white;
            padding: 4rem 1rem;
            position: relative;
            overflow: hidden;
        }

        .cta::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://via.placeholder.com/1920x1080') center/cover no-repeat;
            opacity: 0.1;
            z-index: 0;
        }

        .cta-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .cta-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            line-height: 1.2;
        }

        .cta-title span {
            color: #FFCC00;
            position: relative;
            display: inline-block;
        }

        .cta-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
        }

        /* Footer */
        footer {
            background-color: #1E40AF;
            color: white;
            padding: 4rem 1rem 2rem;
            margin-top: auto;
            position: relative;
        }

        footer::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: #FFCC00;
        }

        .footer-container {
            display: grid;
            gap: 2rem;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .footer-logo img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .social-link {
            color: white;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .social-link:hover {
            color: #FFCC00;
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
        }

        .footer-heading {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.75rem;
        }

        .footer-heading::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: #FFCC00;
            border-radius: 2px;
        }

        .contact-info p {
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .contact-info p.contact-email {
            margin-top: 1.5rem;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-link {
            font-size: 0.875rem;
            color: white;
            transition: all 0.3s ease;
            display: inline-block;
            position: relative;
            padding-left: 1rem;
        }

        .footer-link::before {
            content: '→';
            position: absolute;
            left: 0;
            transition: transform 0.3s ease;
        }

        .footer-link:hover {
            color: #FFCC00;
        }

        .footer-link:hover::before {
            transform: translateX(3px);
        }

        .copyright {
            text-align: center;
            padding-top: 2rem;
            margin-top: 3rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.7);
        }

        /* Responsive Styles */
        @media (min-width: 768px) {
            nav {
                display: block;
            }

            .mobile-menu-btn {
                display: none;
            }

            .hero-container {
                flex-direction: row;
            }

            .hero-content {
                text-align: left;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .about-container {
                flex-direction: row;
                align-items: center;
            }

            .about-content {
                width: 50%;
            }

            .about-image {
                width: 50%;
            }

            .features-container {
                grid-template-columns: 1fr 1fr;
            }

            .purpose-container {
                flex-direction: row;
                align-items: center;
            }

            .purpose-content {
                width: 50%;
            }

            .purpose-image {
                width: 50%;
            }

            .cta-container {
                flex-direction: row;
                justify-content: space-between;
                text-align: left;
            }

            .footer-container {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        /* Animation Classes */
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .fade-up.active {
            opacity: 1;
            transform: translateY(0);
        }

        .fade-right {
            opacity: 0;
            transform: translateX(-30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .fade-right.active {
            opacity: 1;
            transform: translateX(0);
        }

        .fade-left {
            opacity: 0;
            transform: translateX(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .fade-left.active {
            opacity: 1;
            transform: translateX(0);
        }

        .zoom-in {
            opacity: 0;
            transform: scale(0.9);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .zoom-in.active {
            opacity: 1;
            transform: scale(1);
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="container header-container">
            <div class="logo" data-aos="fade-right">
                <img src="https://www.google.com/imgres?q=LOGO%20POLINEMA%20dan%20jti&imgurl=https%3A%2F%2Favatars.githubusercontent.com%2Fu%2F63681676%3Fs%3D280%26v%3D4&imgrefurl=https%3A%2F%2Fgithub.com%2Fjti-polinema&docid=QAjOhnOYQn6-aM&tbnid=Lyxv_KGHGf75qM&vet=12ahUKEwj93r3jmIONAxUszzgGHbznOicQM3oECGcQAA..i&w=256&h=256&hcb=2&ved=2ahUKEwj93r3jmIONAxUszzgGHbznOicQM3oECGcQAA/40" alt="Logo Politeknik Negeri Malang">
                <div class="logo-text">
                    <span class="logo-title">TRACER STUDY</span>
                    <span class="logo-subtitle">Politeknik Negeri Malang</span>
                </div>
            </div>
            <nav data-aos="fade-left">
                <ul class="nav-links">
                    <li><a href="/" class="nav-link">Beranda</a></li>
                    <li><a href="/tentang" class="nav-link">Tentang Tracer Study</a></li>
                    <li><a href="/survey" class="nav-link">Isi Survey</a></li>
                    <li><a href="/login" class="nav-link">Login Alumni</a></li>
                </ul>
            </nav>
            <button class="mobile-menu-btn" data-aos="fade-left">Menu</button>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="hero">
            <div class="container hero-container">
                <div class="hero-image-container" data-aos="zoom-in" data-aos-duration="1000">
                    <div class="hero-image-bg"></div>
                    <div class="hero-image">
                        <img src="https://via.placeholder.com/500" alt="Politeknik Negeri Malang Building">
                    </div>
                </div>
                <div class="hero-content">
                    <h1 class="hero-title" data-aos="fade-up" data-aos-delay="200">
                        Selamat Datang Di Website <span>Tracer Study</span>
                    </h1>
                    <h2 class="hero-subtitle" data-aos="fade-up" data-aos-delay="300">Politeknik Negeri Malang.</h2>
                    <p class="hero-text" data-aos="fade-up" data-aos-delay="400">
                        Ayo berpartisipasi dalam <span>tracer study</span> untuk membantu meningkatkan kualitas
                        pendidikan dan membangun jaringan alumni yang kuat.
                    </p>
                    <div data-aos="fade-up" data-aos-delay="500">
                        <a href="/survey" class="btn btn-primary">Mulai Survey Sekarang</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section class="about">
            <div class="container about-container">
                <div class="about-content">
                    <div class="section-label" data-aos="fade-right">TENTANG TRACER STUDY</div>
                    <h2 class="section-title" data-aos="fade-right" data-aos-delay="100">
                        Apa itu <span>Tracer Study</span>?
                    </h2>
                    <p class="about-text" data-aos="fade-right" data-aos-delay="200">
                        Tracer Study adalah studi pelacakan jejak lulusan yang memberikan informasi berharga tentang
                        transisi dari pendidikan tinggi ke dunia kerja. Melalui umpan balik dari alumni, kami dapat
                        mengidentifikasi kekuatan dan kelemahan program pendidikan, serta mengembangkan kurikulum yang
                        lebih relevan dengan kebutuhan industri saat ini.
                    </p>
                    <p class="about-text" data-aos="fade-right" data-aos-delay="300">
                        Dengan partisipasi Anda dalam Tracer Study, Politeknik Negeri Malang dapat terus meningkatkan
                        kualitas pendidikan dan mempersiapkan mahasiswa untuk menghadapi tantangan dunia kerja di era
                        digital.
                    </p>
                </div>
                <div class="about-image" data-aos="fade-left" data-aos-delay="400">
                    <img src="https://via.placeholder.com/500x400" alt="Illustration of people collaborating">
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features">
            <div class="container features-container">
                <div class="features-list">
                    <div class="feature-item" data-aos="fade-up">
                        <div class="feature-number">01</div>
                        <div class="feature-content">
                            <h3>Database Alumni Terintegrasi</h3>
                            <p>
                                Membangun database alumni yang komprehensif dan terintegrasi untuk memudahkan
                                komunikasi, networking, dan berbagi informasi penting antar alumni dan institusi.
                            </p>
                        </div>
                    </div>

                    <div class="feature-item" data-aos="fade-up" data-aos-delay="100">
                        <div class="feature-number">02</div>
                        <div class="feature-content">
                            <h3>Kolaborasi Industri</h3>
                            <p>
                                Membuka peluang kerjasama strategis antara institusi pendidikan dengan perusahaan tempat
                                alumni bekerja, menciptakan sinergi yang menguntungkan semua pihak.
                            </p>
                        </div>
                    </div>

                    <div class="feature-item" data-aos="fade-up" data-aos-delay="200">
                        <div class="feature-number">03</div>
                        <div class="feature-content">
                            <h3>Pengembangan Kurikulum</h3>
                            <p>
                                Menyediakan data empiris untuk evaluasi dan pengembangan kurikulum yang selaras dengan
                                kebutuhan industri terkini, meningkatkan relevansi pendidikan.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="benefits">
                    <div class="section-label" data-aos="fade-up">MANFAAT TRACER STUDY</div>
                    <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">
                        Manfaat <span>Tracer Study</span>
                    </h2>
                    <p class="benefits-text" data-aos="fade-up" data-aos-delay="200">
                        Tracer Study memberikan wawasan mendalam tentang perjalanan karir alumni setelah lulus, termasuk
                        masa transisi ke dunia kerja, bidang pekerjaan yang digeluti, dan kompetensi yang dibutuhkan di
                        industri. Data ini menjadi pondasi bagi institusi untuk melakukan penilaian kebutuhan (need
                        assessment) dari perspektif pengguna lulusan.
                    </p>
                    <p class="benefits-text" data-aos="fade-up" data-aos-delay="300">
                        Hasil Tracer Study juga membantu institusi memahami persepsi pemberi kerja terhadap alumni,
                        mengidentifikasi kesenjangan kompetensi, dan merumuskan strategi pengembangan soft skills dan
                        hard skills yang dibutuhkan di era digital. Dengan demikian, lulusan Politeknik Negeri Malang
                        dapat lebih siap menghadapi dinamika pasar kerja yang terus berubah.
                    </p>
                </div>
            </div>
        </section>

        <!-- Purpose Section -->
        <section class="purpose">
            <div class="container purpose-container">
                <div class="purpose-content">
                    <div class="section-label" data-aos="fade-right">TUJUAN TRACER STUDY</div>
                    <h2 class="section-title" data-aos="fade-right" data-aos-delay="100">
                        <span>Tracer Study</span> ditujukan untuk :
                    </h2>
                    <ul class="purpose-list">
                        <li class="purpose-item" data-aos="fade-right" data-aos-delay="200">
                            <div class="purpose-marker"></div>
                            <div class="purpose-content">
                                <h4>Jaminan Kualitas Pendidikan</h4>
                                <p>
                                    Memastikan kualitas pendidikan yang berkelanjutan melalui evaluasi dan perbaikan
                                    berdasarkan umpan balik dari alumni dan pengguna lulusan.
                                </p>
                            </div>
                        </li>
                        <li class="purpose-item" data-aos="fade-right" data-aos-delay="300">
                            <div class="purpose-marker"></div>
                            <div class="purpose-content">
                                <h4>Akreditasi Institusi</h4>
                                <p>
                                    Menyediakan data empiris yang diperlukan untuk proses akreditasi nasional dan
                                    internasional, meningkatkan kredibilitas dan reputasi institusi.
                                </p>
                            </div>
                        </li>
                        <li class="purpose-item" data-aos="fade-right" data-aos-delay="400">
                            <div class="purpose-marker"></div>
                            <div class="purpose-content">
                                <h4>Pengembangan Karir Alumni</h4>
                                <p>
                                    Memfasilitasi pengembangan karir alumni melalui jaringan profesional, informasi
                                    lowongan kerja, dan program peningkatan kompetensi berkelanjutan.
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="purpose-image" data-aos="fade-left" data-aos-delay="500">
                    <img src="https://via.placeholder.com/500x400" alt="Illustration of people working with data">
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta">
            <div class="container cta-container">
                <div data-aos="fade-right">
                    <h2 class="cta-title">
                        Ayo berpartisipasi dalam <span>Tracer Study</span>
                    </h2>
                    <p class="cta-subtitle">Bersama membangun masa depan Politeknik Negeri Malang.</p>
                </div>
                <div data-aos="fade-left">
                    <a href="/survey" class="btn btn-yellow">Isi Survey Sekarang</a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container footer-container">
            <div data-aos="fade-up">
                <div class="footer-logo">
                    <img src="https://via.placeholder.com/40" alt="Logo Politeknik Negeri Malang">
                    <div class="logo-text">
                        <span class="logo-title">TRACER STUDY</span>
                        <span class="logo-subtitle">Politeknik Negeri Malang</span>
                    </div>
                </div>
                <p>Platform resmi untuk menghubungkan alumni dan memperkuat jaringan profesional Politeknik Negeri
                    Malang.</p>
                <div class="social-links">
                    <a href="#" class="social-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                            <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                        </svg>
                    </a>
                    <a href="#" class="social-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z" />
                            <rect width="4" height="12" x="2" y="9" />
                            <circle cx="4" cy="4" r="2" />
                        </svg>
                    </a>
                    <a href="#" class="social-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path
                                d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17" />
                            <path d="m10 15 5-3-5-3z" />
                        </svg>
                    </a>
                    <a href="#" class="social-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="contact-info" data-aos="fade-up" data-aos-delay="100">
                <h3 class="footer-heading">Kontak Kami</h3>
                <p>Politeknik Negeri Malang</p>
                <p>Jl. Soekarno Hatta No.9,</p>
                <p>Jatimulyo, Kec. Lowokwaru</p>
                <p>Kota Malang, Jawa Timur 65141</p>
                <p class="contact-email">tracer@polinema.ac.id</p>
                <p>0341 - 404424/404425</p>
            </div>

            <div data-aos="fade-up" data-aos-delay="200">
                <h3 class="footer-heading">Tautan Penting</h3>
                <ul class="footer-links">
                    <li>
                        <a href="/survey" class="footer-link">Isi Survey</a>
                    </li>
                    <li>
                        <a href="/faq" class="footer-link">FAQ</a>
                    </li>
                    <li>
                        <a href="/alumni" class="footer-link">Direktori Alumni</a>
                    </li>
                    <li>
                        <a href="https://www.polinema.ac.id" class="footer-link">Website Polinema</a>
                    </li>
                </ul>
            </div>

            <div data-aos="fade-up" data-aos-delay="300">
                <h3 class="footer-heading">Berita & Kegiatan</h3>
                <ul class="footer-links">
                    <li>
                        <a href="#" class="footer-link">Webinar Karir 2023</a>
                    </li>
                    <li>
                        <a href="#" class="footer-link">Reuni Akbar Alumni</a>
                    </li>
                    <li>
                        <a href="#" class="footer-link">Lowongan Kerja Terbaru</a>
                    </li>
                    <li>
                        <a href="#" class="footer-link">Semua Berita</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            &copy; <?php echo date('Y'); ?> Tracer Study Politeknik Negeri Malang. All Rights Reserved.
        </div>
    </footer>

    <?php
    // You can add PHP logic here if needed
    // For example, to handle form submissions or dynamic content
    ?>

    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Initialize AOS animation
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true,
                mirror: false
            });

            // Simple mobile menu toggle
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            const nav = document.querySelector('nav');

            mobileMenuBtn.addEventListener('click', function() {
                nav.style.display = nav.style.display === 'block' ? 'none' : 'block';
            });

            // Reset nav display on window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    nav.style.display = 'block';
                } else {
                    nav.style.display = 'none';
                }
            });

            // Scroll animation for elements without AOS
            const animateOnScroll = function() {
                const elements = document.querySelectorAll('.fade-up, .fade-right, .fade-left, .zoom-in');

                elements.forEach(element => {
                    const elementPosition = element.getBoundingClientRect().top;
                    const windowHeight = window.innerHeight;

                    if (elementPosition < windowHeight - 50) {
                        element.classList.add('active');
                    }
                });
            };

            window.addEventListener('scroll', animateOnScroll);
            animateOnScroll(); // Run once on load
        });
    </script>
</body>

</html>
