<!-- Main Content -->
<div class="container my-5">
    <h1 class="h3 mb-5 " style="font-weight: 900;">
        Kuesioner Tracer Study Politeknik Negeri Malang.
    </h1>

    <div class="survey-cards">
        @if ($isTrue)
            @if ($data['type'] == 'alumni')
                <form action="javascript:onSaveAlumni(this)" method="post" id="form_alumni" name="form_alumni"
                    autocomplete="off">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#data-diri"
                                role="tab">Data Diri</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#data-atasan"
                                role="tab">Data Atasan Alumni</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="messages-tab" data-toggle="tab" href="#data-kuisioner"
                                role="tab">Kuisioner</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="data-diri" role="tabpanel">
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
                                    <label for="company_id" class="required">Perusahaan</label>
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


                        <div class="tab-pane fade" id="data-atasan" role="tabpanel">
                            <h5 class="mb-4">Data Atasan Alumni Tempat Bekerja </h5>
                            <div class="row">
                                <div class="form-label col-md-6">
                                    <label class="mb-2 required" for="full_name">Nama Lengkap</label>
                                    <input name="superior[full_name]" class="form-control mb-3" type="text"
                                        required placeholder="Nama Lengkap"
                                        value="{{ $data['superior']['full_name'] ?? '' }}">
                                </div>
                                <div class="form-label col-md-6">
                                    <label class="mb-2 required" for="full_name">Position</label>
                                    <input name="superior[position]" class="form-control mb-3" type="text"
                                        required placeholder="Position"
                                        value="{{ $data['superior']['position'] ?? '' }}">
                                </div>
                                <div class="form-label col-md-6">
                                    <label class="mb-2 required" for="phone">Nomor Telepon</label>
                                    <input name="superior[phone]" class="form-control mb-3" type="text" required
                                        placeholder="Nomor Telepon, ex: 628...."
                                        value="{{ $data['superior']['phone'] ?? '' }}">
                                </div>
                                <div class="form-label col-md-6">
                                    <label class="mb-2 required" for="email">Email</label>
                                    <input name="superior[email]" class="form-control mb-3" type="text" required
                                        placeholder="Email" value="{{ $data['superior']['email'] ?? '' }}">
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-primary btn-next">Selanjutnya</button>
                            </div>
                            <div style="height: 100px"></div>
                        </div>
                        <div class="tab-pane fade" id="data-kuisioner" role="tabpanel">
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
                                <button type="submit" class="btn btn-primary">Simpan Data</button>
                            </div>
                            <div style="height: 100px"></div>
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
                                        placeholder="Nama Perusahaan" required />
                                    <select name="company_type" class="form-control mb-2" required>
                                        <option value="">Pilih Tipe</option>
                                        <option value="higher_education">Perguruan Tinggi</option>
                                        <option value="government_agency">Instansi Pemerintah</option>
                                        <option value="state-owned_enterprise">BUMN</option>
                                        <option value="private_company">Swasta</option>
                                    </select>

                                    <select name="scope" class="form-control mb-2" required>
                                        <option value="">Pilih Skala</option>
                                        <option value="local">Lokal</option>
                                        <option value="national">Nasional</option>
                                        <option value="international">Internasional</option>
                                    </select>
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
                                        placeholder="Nama Perusahaan" required />
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
                    name="form_superior" autocomplete="off">
                    <input name="questionnaire_id" type="hidden" value="{{ $data['questionnaire']['id'] }}">
                    <div class="form-label col-md-12 mb-3">
                        <label class="mb-2 required col-12" for="alumni">Alumni</label>
                        <select name="alumni_id" class="form-control mb-3 alumni_id" required>
                            <option value="">- Pilih Alumni -</option>
                        </select>
                    </div>
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
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
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
@include('landingPage.script.script-content')
