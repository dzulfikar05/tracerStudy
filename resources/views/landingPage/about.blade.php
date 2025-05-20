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
</style>
</head>

<body>

    <!-- About Section with Dummy Text -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    
                    <h2 class="text-center">Tentang Tracer Studi</h2>

                    <p>Tracer Study
                        adalah studi suvei yang berujuan untuk melacak jejak alumni dan mengumpulkan data mengenai
                        status kerja, relevansi pekerjaan, dan tingkat pendapatan mereka. </p>

                    <p>Data ini kemudian digunakan
                        untuk meningkatkan kualitas pendidikan dan kurikulum di Polinema, serta menjalin hubungan antara
                        alumni dengan program studi.</p>
                    <div class="col-lg-6">
                        <img src="{{ asset('img/photos/Illustrasi_Tracer.jpg') }}" alt="Illustrasi_Tracer"
                            class="illustration-img">
                    </div>

                    <h3 class="mt-5 mb-4">Tujuan Tracer Studi</h3>
                    <p>Tracer Studi memiliki beberapa tujuan penting, di antaranya:</p>
                    <ul>
                        <li>Mengevaluasi output/outcome pendidikan tinggi</li>
                        <li>Memperoleh informasi penting untuk pengembangan institusi</li>
                        <li>Mengetahui relevansi kurikulum dengan kebutuhan dunia kerja</li>
                        <li>Sebagai kontribusi untuk akreditasi program studi</li>
                        <li>Memberikan informasi kepada mahasiswa, orang tua, dosen, administrasi pendidikan dan para
                            pelaku pendidikan mengenai transisi dari dunia pendidikan tinggi ke dunia kerja</li>
                    </ul>
                    

                    <h3 class="mt-5 mb-4">Manfaat Tracer Studi</h3>
                    <p>Hasil dari Tracer Studi dapat digunakan sebagai bahan pertimbangan dalam pengembangan kurikulum,
                        peningkatan kualitas pembelajaran, dan penguatan jaringan alumni. Dengan adanya data yang akurat
                        tentang kondisi alumni di dunia kerja, institusi pendidikan dapat melakukan perbaikan dan
                        inovasi yang relevan dengan kebutuhan pasar.</p>

                    <p>Selain itu, Tracer Studi juga bermanfaat bagi para alumni untuk tetap terhubung dengan almamater
                        dan membuka peluang kolaborasi di masa depan.</p>
                        
                    <div class="col-lg-6">
                        <img src="{{ asset('img/photos/Illustrasi_Tracer.jpg') }}" alt="Illustrasi_Tracer"
                            class="illustration-img">
                    </div>
                    <h3 class="mt-5 mb-4">Metodologi Tracer Studi</h3>
                    <p>Tracer Studi dilakukan dengan metode survei terhadap alumni yang telah lulus dalam kurun waktu
                        tertentu. Survei ini mencakup berbagai aspek, seperti:</p>
                    <ul>
                        <li>Proses pencarian kerja</li>
                        <li>Situasi kerja saat ini</li>
                        <li>Penerapan kompetensi di dunia kerja</li>
                        <li>Evaluasi terhadap proses pembelajaran</li>
                        <li>Saran untuk pengembangan institusi</li>
                    </ul>

                    <p>Data yang diperoleh kemudian dianalisis untuk mendapatkan gambaran mengenai kondisi alumni dan
                        relevansi pendidikan dengan kebutuhan dunia kerja.</p>

                    <h3 class="mt-5 mb-4">Implementasi Hasil Tracer Studi</h3>
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
    </section>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
