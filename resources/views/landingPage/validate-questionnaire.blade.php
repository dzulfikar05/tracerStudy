<!-- Main Content -->
<div class="container my-5">
    <h1 class="h3 mb-5 " style="font-weight: 900;">
        Kuesioner Tracer Study Politeknik Negeri Malang.
        <button style="float: right" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#infoModal" onclick="onWalkthrough()">?</button>

    </h1>

    <div class="survey-cards-vertical ">
        @if (isset($questionnaire))
            @if ($questionnaire->type == 'alumni')
                <form action="javascript:validateAlumni(this)" method="post" id="form_alumni" name="form_alumni" data-intro='Isi data kemahasiswaan untuk melanjutkan pengisian data kuisioner'
                    autocomplete="off">
                    <div class="row">
                        <input name="questionnaire_id" type="hidden" value="{{ $questionnaire->id }}">
                        <div class="form-label col-md-6" data-intro="Isikan NIM dengan benar">
                            <label class="mb-2 required" for="nim">NIM</label>
                            <input id="nim" name="nim" class="form-control mb-3" type="text" maxlength="10"
                                required placeholder="NIM">
                        </div>
                        <div class="form-label col-md-6" data-intro="Isikan Tanggal Lulus dengan benar">
                            <label class="mb-2 required" for="graduation_date">Tanggal Lulus</label>
                            <input id="graduation_date" name="graduation_date" class="form-control mb-3" type="date"
                                required>
                        </div>
                        <div class="form-label col-md-12" data-intro="Pilih Program Studi dengan benar">
                            <label class="mb-2 required" for="study_program">Prodi</label>
                            <select id="study_program" name="study_program" class="form-control mb-3"
                                style="width: 100%;" required>
                                <option value="">- Pilih Program Studi -</option>
                            </select>
                        </div>

                        <div class="col-12 d-flex justify-content-center mt-5">
                            <button type="submit" class="btn btn-primary p-3 px-4 fw-bold rounded-pill"  data-intro="Klik untuk melanjutkan pengisian data kuisioner" >Cek Validasi
                                Data</button>
                        </div>

                    </div>
                </form>
            @else
                <form action="javascript:validateSuperior(this)" method="post" id="form_superior" name="form_superior" data-intro='Isi data validasi untuk melanjutkan pengisian data kuisioner'
                    autocomplete="off">
                    <div class="row">
                        <input name="questionnaire_id" type="hidden" value="{{ $questionnaire->id }}">
                        <div class="form-label col-md-6" data-intro="Isikan alamat email dengan benar">
                            <label class="mb-2 required" for="email">Email</label>
                            <input id="email" name="email" class="form-control mb-3" type="text"
                                required placeholder="Email">
                        </div>
                        <div class="form-label col-md-6" data-intro="Isikan Token yang telah dikirimkan melalui email dengan benar">
                            <label class="mb-2 required" for="passcode">Token</label>
                            <input id="passcode" name="passcode" class="form-control mb-3" type="text" maxlength="6"
                                required>
                        </div>

                        <div class="col-12 d-flex justify-content-center mt-5"">
                            <button type="submit" class="btn btn-primary p-3 px-4 fw-bold rounded-pill"  data-intro="Klik untuk melanjutkan pengisian data kuisioner" >Cek Validasi
                                Data</button>
                        </div>

                    </div>
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
<div style="height: 250px"></div>
<script>
     onWalkthrough = () => {
        introJs().start();
    }
</script>
@include('landingPage.script.script-validate')
