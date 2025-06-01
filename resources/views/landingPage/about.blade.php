<!-- Main Content -->


<style>
    /* Reset default margin and padding */
    body,
    html {
        margin: 0;
        padding: 0;
        height: 100%;
        scroll-behavior: smooth;
    }

    /* Hero section with full-screen background */
    .hero-section {
        position: relative;
        height: 100vh;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    /* Background image styling */
    .hero-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Overlay to make text more readable */
    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    /* Hero content styling */
    .hero-content {
        position: relative;
        z-index: 10;
        text-align: center;
        color: white;
        padding: 0 20px;
    }

    /* Scroll indicator */
    .scroll-down {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        color: white;
        text-align: center;
        z-index: 10;
    }

    .scroll-down a {
        color: white;
        text-decoration: none;
    }

    .scroll-down i {
        animation: bounce 2s infinite;
    }

    @keyframes bounce {

        0%,
        20%,
        50%,
        80%,
        100% {
            transform: translateY(0);
        }

        40% {
            transform: translateY(-20px);
        }

        60% {
            transform: translateY(-10px);
        }
    }

    /* About section styling */
    .about-section {
        padding: 80px 0;
        background-color: #f8f9fa;
    }

    .about-section h2 {
        margin-bottom: 40px;
        position: relative;
        padding-bottom: 15px;
    }

    .about-section h2:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100px;
        height: 3px;
        background-color: #ffc107;
    }

    .LogoHeader {
        display: flex;
        justify-content: center;
        /* Horizontal center */
        align-items: center;
        /* Vertical center (jika diperlukan) */
        margin-bottom: 7px;
        /* Spasi bawah opsional */
        text-align: center;
    }

    .illustration-img {
        max-width: 100%;
        height: auto;
        display: block;
    }


    .text-center {
        font-weight: 800;
        margin-bottom: 30px;
    }

    .cardTujuan {
        border: 1px solid #e0dee8;
        margin-top: 40px;
        padding: 2.5%;
        border-radius: 5px;
    }
</style>
</head>

<body>

    <!-- About Section with Dummy Text -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="LogoHeader">
                        <img src="{{ asset('img/photos/LogoTracerIlustrasi.png') }}" alt="Illustrasi_Tracer"
                            class="illustration-img" data-aos="zoom-in-up" data-aos-delay="50" data-aos-duration="1000">
                    </div>
                    <h1 class="text-center" data-aos="zoom-in-up" data-aos-delay="50" data-aos-duration="1000">Tentang
                        Tracer Studi</h1>

                    <br>
                    <div data-aos="zoom-in-up" data-aos-delay="50" data-aos-duration="1000">
                        <p>Tracer Study
                            adalah studi suvei yang berujuan untuk melacak jejak alumni dan mengumpulkan data mengenai
                            status kerja, relevansi pekerjaan, dan tingkat pendapatan mereka. </p>

                        <p>Data ini kemudian digunakan
                            untuk meningkatkan kualitas pendidikan dan kurikulum di Polinema, serta menjalin hubungan
                            antara
                            alumni dengan program studi.</p>
                    </div>
                    <div class="col-lg-6">
                    </div>

                    <div class="cardTujuan" data-aos="zoom-in-right" data-aos-delay="50" data-aos-duration="1000">
                        <div class="CardBody"></div>
                        <h3 class="cardHeader">Tujuan Tracer Studi</h3>
                        <p>Tracer Studi memiliki beberapa tujuan penting, di antaranya:</p>
                        <ul>
                            <li>Mengevaluasi output/outcome pendidikan tinggi</li>
                            <li>Memperoleh informasi penting untuk pengembangan institusi</li>
                            <li>Mengetahui relevansi kurikulum dengan kebutuhan dunia kerja</li>
                            <li>Sebagai kontribusi untuk akreditasi program studi</li>
                            <li>Memberikan informasi kepada mahasiswa, orang tua, dosen, administrasi pendidikan dan
                                para
                                pelaku pendidikan mengenai transisi dari dunia pendidikan tinggi ke dunia kerja</li>
                        </ul>

                    </div>


                    <div class="cardTujuan" data-aos="zoom-in-right" data-aos-delay="50" data-aos-duration="1000">
                        <div class="CardBody"></div>
                        <h3 class="cardHeader">Manfaat Tracer Studi</h3>
                        <p>Hasil dari Tracer Studi dapat digunakan sebagai bahan pertimbangan dalam pengembangan
                            kurikulum,
                            peningkatan kualitas pembelajaran, dan penguatan jaringan alumni. Dengan adanya data yang
                            akurat
                            tentang kondisi alumni di dunia kerja, institusi pendidikan dapat melakukan perbaikan dan
                            inovasi yang relevan dengan kebutuhan pasar.</p>

                        <p>Selain itu, Tracer Studi juga bermanfaat bagi para alumni untuk tetap terhubung dengan
                            almamater
                            dan membuka peluang kolaborasi di masa depan.</p>
                    </div>


                    <div class="cardTujuan" data-aos="zoom-in-right" data-aos-delay="50" data-aos-duration="1000">
                        <div class="CardBody"></div>
                        <h3 class="cardHeader">Metodologi Tracer Studi</h3>
                        <p>Tracer Studi dilakukan dengan metode survei terhadap alumni yang telah lulus dalam kurun
                            waktu
                            tertentu. Survei ini mencakup berbagai aspek, seperti:</p>
                        <ul>
                            <li>Proses pencarian kerja</li>
                            <li>Situasi kerja saat ini</li>
                            <li>Penerapan kompetensi di dunia kerja</li>
                            <li>Evaluasi terhadap proses pembelajaran</li>
                            <li>Saran untuk pengembangan institusi</li>
                        </ul>
                        <p>Data yang diperoleh kemudian dianalisis untuk mendapatkan gambaran mengenai kondisi alumni
                            dan
                            relevansi pendidikan dengan kebutuhan dunia kerja.</p>
                    </div>

                    <div class="cardTujuan" data-aos="zoom-in-right" data-aos-delay="50" data-aos-duration="1000">
                        <div class="cardHeader"></div>
                        <h3 class="cardHeader">Implementasi Hasil Tracer Studi</h3>
                        <p>Hasil dari Tracer Studi tidak hanya berhenti pada tahap analisis data, tetapi juga
                            diimplementasikan dalam berbagai kebijakan dan program, seperti:</p>
                        <ul>
                            <li>Revisi kurikulum</li>
                            <li>Pengembangan program studi baru</li>
                            <li>Peningkatan kualitas pembelajaran</li>
                            <li>Penguatan jaringan alumni</li>
                            <li>Pengembangan kerjasama dengan industri</li>
                        </ul>

                        <p>Dengan demikian, Tracer Studi menjadi instrumen penting dalam upaya peningkatan kualitas
                            pendidikan dan relevansinya dengan kebutuhan dunia kerja.</p>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>

