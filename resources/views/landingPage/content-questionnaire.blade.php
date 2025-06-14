<!-- Main Content -->
<div class="container my-5">
    <h1 class="h3 mb-5 " style="font-weight: 900;">
        Kuesioner Tracer Study Politeknik Negeri Malang.
        <button style="float: right" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#infoModal" onclick="onWalkthrough()">?</button>
    </h1>

    <div class="survey-cards">
        @if ($isTrue)
            @if ($data['type'] == 'alumni')
                <form action="javascript:onSaveAlumni(this)" method="post" id="form_alumni" name="form_alumni" novalidate
                    autocomplete="off">
                    <ul class="nav nav-tabs" id="myTab" role="tablist" data-intro="Pengisian data dibagi menjadi tiga bagian.">
                        <li class="nav-item" data-intro="Pertama, data diri lulusan">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#data-diri"
                                role="tab">Data Diri</a>
                        </li>
                        <li class="nav-item" id="tab-atasan" data-intro="Kedua, data atasan lulusan">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#data-atasan"
                                role="tab">Data Atasan Alumni</a>
                        </li>
                        <li class="nav-item" data-intro="Ketiga, data kuisioner">
                            <a class="nav-link" id="messages-tab" data-toggle="tab" href="#data-kuisioner"
                                role="tab">Kuisioner</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="data-diri" role="tabpanel" data-intro="Langkah pertama, isi data diri anda dengan benar & lengkap">
                            <h5 class="mb-4">Data Diri Lulusan</h5>
                            <input name="alumni_id" type="hidden" value="{{ $data['alumni']['id'] }}">
                            <input name="questionnaire_id" type="hidden" value="{{ $data['questionnaire']['id'] }}">
                            <div class="row">
                                <div class="form-label col-md-6">
                                    <label class="mb-2 required" for="full_name">Nama Lengkap</label>
                                    <input name="alumni[full_name]" class="form-control mb-3" type="text"
                                        value="{{ $data['alumni']['full_name'] }}" disabled placeholder="Nama Lengkap">
                                </div>

                                <div class="form-label col-md-6">
                                    <label class="mb-2 required" for="nim">NIM</label>
                                    <input name="alumni[nim]" class="form-control mb-3" type="text" max="10"
                                        disabled placeholder="NIM" value="{{ $data['alumni']['nim'] }}">
                                </div>

                                <div class="form-label col-md-6">
                                    <label class="mb-2 required col-12" for="study_program">Program Studi</label>
                                    <input name="alumni[study_program]" class="form-control mb-3" type="text"
                                        value="{{ $data['alumni']['study_program'] }}" disabled placeholder="prodi">
                                </div>

                                <div class="form-label col-md-6">
                                    <label class="mb-2 required" for="graduation_date">Tanggal Lulus</label>
                                    <input name="alumni[graduation_date]" class="form-control mb-3"
                                        value="{{ $data['alumni']['graduation_date'] }}" type="date" disabled>
                                </div>

                                <div class="form-label col-md-6">
                                    <label class="mb-2 required" for="phone">Telepon</label>
                                    <input name="alumni[phone]" class="form-control mb-3" type="text"
                                        value="{{ $data['alumni']['phone'] }}" placeholder="Nomor Telepon" required>
                                </div>

                                <div class="form-label col-md-6">
                                    <label class="mb-2 required" for="email">Email</label>
                                    <input name="alumni[email]" class="form-control mb-3" type="email"
                                        value="{{ $data['alumni']['email'] }}" placeholder="Email" required>
                                </div>

                                <div class="form-label col-md-6">
                                    <label class="mb-2 required" for="study_start_year">Tahun Angkatan</label>
                                    <input name="alumni[study_start_year]" class="form-control mb-3"
                                        value="{{ $data['alumni']['study_start_year'] }}" type="text" required maxlength="4">
                                </div>
                                <div class="form-label col-md-6">
                                    <label class="mb-2 required" for="start_work_date">Tanggal Mulai Kerja</label>
                                    <input name="alumni[start_work_date]" class="form-control mb-3"
                                        value="{{ $data['alumni']['start_work_date'] }}" type="date" required>
                                </div>

                                <div class="form-label col-md-6">
                                    <label class="mb-2 required" for="start_work_now_date">Tanggal Mulai Kerja (Pada
                                        Perusahaan
                                        Sekarang)</label>
                                    <input name="alumni[start_work_now_date]" class="form-control mb-3"
                                        value="{{ $data['alumni']['start_work_now_date'] }}" type="date" required>
                                </div>
                                <div class="form-label col-md-6">
                                    <label class="mb-2 col-12 required" for="profession_category_id">Kategori
                                        Profesi</label>
                                    <select class="form-control mb-3 profession_category_id "required
                                        style="width: 100%">
                                        <option value="">- Pilih Kategori Profesi -</option>
                                    </select>
                                </div>
                                {{-- <div class="form-label col-md-6">
                                    <label class="mb-2 col-12 required" for="profession_id">Profesi</label>
                                    <select name="alumni[profession_id]" class="form-control mb-3 profession_id"
                                        style="width: 100%" required>
                                        <option value="">- Pilih Profesi -</option>
                                    </select>
                                </div> --}}

                                <div class="form-group col-md-6">
                                    <label for="profession_id" class="required">Profesi</label>
                                    <div class="input-group">
                                        <select name="alumni[profession_id]" class="form-control profession_id"
                                            required>
                                            <option value="">- Pilih Profesi -</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-primary btn-sm"
                                                data-toggle="modal" data-target="#modalAddProfession">
                                                + Tambah
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="company_id" class="required">Perusahaan / Tempat Bekerja</label>
                                    <div class="input-group">
                                        <select name="alumni[company_id]" class="form-control company_id" required>
                                            <option value="">- Pilih Perusahaan -</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-primary btn-sm"
                                                data-toggle="modal" data-target="#modalAddCompany">
                                                + Tambah
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-primary btn-next">Selanjutnya</button>
                            </div>
                        </div>


                        <div class="tab-pane fade" id="data-atasan" role="tabpanel" data-intro="Langkah kedua, isi data atasan langsung anda dengan benar">
                            <h5 class="mb-4">Data Atasan Alumni Tempat Bekerja </h5>
                            <div class="row">
                                <div class="form-label col-md-6">
                                    <label class="mb-2 required" for="full_name">Nama Lengkap</label>
                                    <input name="superior[full_name]" class="form-control mb-3 input-atasan-alumni" type="text"
                                        required placeholder="Nama Lengkap"
                                        value="{{ $data['superior']['full_name'] ?? '' }}">
                                </div>
                                <div class="form-label col-md-6">
                                    <label class="mb-2 required" for="full_name">Position</label>
                                    <input name="superior[position]" class="form-control mb-3 input-atasan-alumni" type="text"
                                        required placeholder="Position"
                                        value="{{ $data['superior']['position'] ?? '' }}">
                                </div>
                                <div class="form-label col-md-6">
                                    <label class="mb-2 required" for="phone">Nomor Telepon</label>
                                    <input name="superior[phone]" class="form-control mb-3 input-atasan-alumni" type="text" required
                                        placeholder="Nomor Telepon, ex: 628...."
                                        value="{{ $data['superior']['phone'] ?? '' }}">
                                </div>
                                <div class="form-label col-md-6">
                                    <label class="mb-2 required" for="email">Email</label>
                                    <input name="superior[email]" class="form-control mb-3 input-atasan-alumni" type="text" required
                                        placeholder="Email" value="{{ $data['superior']['email'] ?? '' }}">
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-primary btn-next">Selanjutnya</button>
                            </div>
                            {{-- <div style="height: 100px"></div> --}}
                        </div>
                        <div class="tab-pane fade" id="data-kuisioner" role="tabpanel" data-intro="Langkah ketiga, Isi data kuisioner dengan benar">
                            <h5 class="mb-4">Kuisioner</h5>
                            @if ($data['questions']->count() > 0)
                                @foreach ($data['questions'] as $question)
                                    <div class="card mb-3 question-card" id="question_{{ $question->id }}"
                                        data-id="{{ $question->id }}">
                                        <div class="card-body">
                                            <div class="form-label">
                                                <label class="mb-2 required d-block">
                                                    {{ $question->question }}
                                                </label>

                                                @if ($question->type == 'choice' && $question->options)
                                                    <div class="row">
                                                        @foreach (json_decode($question->options, true) as $index => $option)
                                                            <div class="col-2 text-center mt-2">
                                                                <div
                                                                    style="display: flex; flex-direction: column; align-items: center;">
                                                                    <label
                                                                        for="question_{{ $question->id }}_option_{{ $index }}"
                                                                        style="font-size: small; text-align: center;">
                                                                        {{ $option }}
                                                                    </label>
                                                                    <input type="radio"
                                                                        name="answers[{{ $question->id }}]"
                                                                        id="question_{{ $question->id }}_option_{{ $index }}"
                                                                        value="{{ $option }}"
                                                                        style="margin-bottom: 5px;">

                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @elseif ($question->type == 'essay')
                                                    <textarea name="answers[{{ $question->id }}]" class="form-control" rows="3"
                                                        placeholder="Tuliskan jawaban Anda di sini..."></textarea>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary" data-intro="Langkah terakhir, Pastikan semua data sudah terisi dengan benar. Kemudian klik untuk menyimpan data kuisioner">Simpan Data</button>
                            </div>
                            {{-- <div style="height: 100px"></div> --}}
                        </div>

                    </div>
                </form>


                <div class="modal fade" id="modalAddCompany" tabindex="-1">
                    <div class="modal-dialog">
                        <form id="formAddCompany">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Perusahaan</h5>
                                </div>
                                <div class="modal-body">
                                    <input type="text" name="name" class="form-control mb-2"
                                        placeholder="Nama Perusahaan / Tempat Bekerja" required />
                                    <select name="company_type" class="form-control mb-2 company_type_new" required style="width: 100%; margin-bottom: 10px !important">
                                        <option value="">Pilih Tipe</option>
                                        <option value="higher_education">Perguruan Tinggi</option>
                                        <option value="government_agency">Instansi Pemerintah</option>
                                        <option value="state-owned_enterprise">BUMN</option>
                                        <option value="private_company">Swasta</option>
                                    </select>
                                    <div class="my-2"></div>
                                    <select name="scope" class="form-control mb-2 scope_new" required style="width: 100%; margin-bottom: 10px !important">
                                        <option value="">Pilih Skala</option>
                                        <option value="businessman">Wirausaha</option>
                                        <option value="national">Nasional</option>
                                        <option value="international">Internasional</option>
                                    </select>
                                    <div class="my-2"></div>

                                    <input type="text" name="phone" class="form-control mb-2"
                                        placeholder="Nomor Telepon, ex: 0341..." required maxlength="14" />
                                    <textarea name="address" class="form-control mb-2" placeholder="Alamat" required></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal fade" id="modalAddProfession" tabindex="-1">
                    <div class="modal-dialog">
                        <form id="formAddProfession">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Profesi</h5>
                                </div>
                                <div class="modal-body">
                                    <select name="profession_category_id"
                                        class="form-control mb-2 profession_category_id_new" required
                                        style="width: 100%">
                                        <option value="">Pilih Kategori Profesi</option>
                                    </select>

                                    <input type="text" name="name" class="form-control mt-2"
                                        placeholder="Nama Tempat Kerja" required />
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <form action="javascript:onSaveSuperior(this)" method="post" id="form_superior"
                    name="form_superior" autocomplete="off" novalidate>
                    <input name="questionnaire_id" type="hidden" value="{{ $data['questionnaire']['id'] }}">
                    <div class="form-label col-md-12 mb-3" data-intro="Pilih alumni di tempat kerja anda yang ingin anda nilai.">
                        <label class="mb-2 required col-12" for="alumni">Alumni</label>
                        <select name="alumni_id" class="form-control mb-3 alumni_id" required>
                            <option value="">- Pilih Alumni -</option>
                        </select>
                    </div>
                    @if ($data['questions']->count() > 0)
                        <div data-intro="Isi data kuisioner dengan benar">
                        @foreach ($data['questions'] as $question)
                            <div class="card mb-3 question-card" id="question_{{ $question->id }}"
                                data-id="{{ $question->id }}">
                                <div class="card-body">
                                    <div class="form-label">
                                        <label class="mb-2 required d-block">
                                            {{ $question->question }}
                                        </label>

                                        @if ($question->type == 'choice' && $question->options)
                                            <div class="row">
                                                @foreach (json_decode($question->options, true) as $index => $option)
                                                    <div class="col-2 text-center mt-2">
                                                        <div
                                                            style="display: flex; flex-direction: column; align-items: center;">
                                                            <label
                                                                for="question_{{ $question->id }}_option_{{ $index }}"
                                                                style="font-size: small; text-align: center;">
                                                                {{ $option }}
                                                            </label>
                                                            <input type="radio" name="answers[{{ $question->id }}]"
                                                                id="question_{{ $question->id }}_option_{{ $index }}"
                                                                value="{{ $option }}"
                                                                style="margin-bottom: 5px;">

                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @elseif ($question->type == 'essay')
                                            <textarea name="answers[{{ $question->id }}]" class="form-control" rows="3"
                                                placeholder="Tuliskan jawaban Anda di sini..."></textarea>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary" data-intro="pastikan semua data sudah terisi dengan benar. Kemudian klik untuk menyimpan data kuisioner">Simpan Data</button>
                        </div>
                        <div style="height: 100px"></div>
                    @endif
                </form>
            @endif
        @else
            <div class="card mb-4">
                <div class="card-body py-4 px-4">
                    <h2 class="card-title h5 fw-bold mb-1">Tidak ada kuesioner</h2>
                </div>
            </div>
        @endif

    </div>
</div>
<style>
    .nav-tabs .nav-link {
        background-color: #a8d0ff;
        margin-right: 2px;
        color: #000;
    }

    .nav-tabs .nav-link.active {
        background-color: #fff;
        border-bottom: none;
        font-weight: bold;
    }

    .tab-content {
        border-top: none;
        padding: 20px;
    }
</style>
<script>
    onWalkthrough = () => {
        // Buat instance Intro.js dulu
        const intro = introJs();

        intro.setOptions({
            // Tambahkan opsi Intro.js di sini
        });

        // Tangani event sebelum perubahan langkah Intro.js
        intro.onbeforechange(function(element) {
            const elementId = $(element).attr('id'); // ID elemen data-intro yang akan disorot

            // Peta antara ID tab-pane dan ID tab-link yang mengaktifkannya
            const tabMap = {
                'data-diri': '#home-tab',
                'data-atasan': '#profile-tab',
                'data-kuisioner': '#messages-tab'
            };

            const targetTabLinkSelector = tabMap[elementId];

            if (targetTabLinkSelector) { // Jika elemen yang akan disorot ada di dalam salah satu tab
                // Periksa apakah tab target sudah aktif
                if (!$(targetTabLinkSelector).hasClass('active')) {
                    // Jika belum aktif, aktifkan tab dan tunggu sampai selesai ditampilkan
                    return new Promise((resolve) => {
                        $(targetTabLinkSelector).on('shown.bs.tab', function handler() {
                            // Hapus event listener setelah tab ditampilkan sekali untuk menghindari duplikasi
                            $(targetTabLinkSelector).off('shown.bs.tab', handler);
                            // Resolusi promise agar Intro.js melanjutkan ke langkah berikutnya
                            resolve();
                        });
                        $(targetTabLinkSelector).tab('show'); // Aktifkan tab
                    });
                }
            }
            // Jika elemen tidak terkait dengan tab, atau tab sudah aktif, lanjutkan normal
            return true; // Kembali true agar Intro.js melanjutkan
        }).start(); // Memulai tur Intro.js
    }

    // Pastikan jQuery sudah dimuat sebelum menjalankan script ini
    $(document).ready(function() {
        // ... (Kode JavaScript untuk navigasi tombol Selanjutnya/Sebelumnya yang sudah Anda tambahkan) ...

        $('#btn-next-data-diri').on('click', function() {
            $('#profile-tab').tab('show');
        });

        $('#btn-next-data-atasan').on('click', function() {
            $('#messages-tab').tab('show');
        });

        $('#btn-prev-data-atasan').on('click', function() {
            $('#home-tab').tab('show');
        });

        $('#btn-prev-data-kuisioner').on('click', function() {
            $('#profile-tab').tab('show');
        });
    });
</script>
@include('landingPage.script.script-content')
