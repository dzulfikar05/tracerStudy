<!-- Main Content -->
<div class="container my-5">
    <h1 class="h3 mb-5 " style="font-weight: 900;">
        Kuesioner Tracer Study Politeknik Negeri Malang.
    </h1>

    <div class="survey-cards-vertical ">
        @if (isset($questionnaire))
            @if ($questionnaire->type == 'alumni')
                <form action="javascript:validateAlumni(this)" method="post" id="form_alumni" name="form_alumni"
                    autocomplete="off">
                    <div class="row">

                        <div class="form-label col-md-6">
                            <label class="mb-2 required" for="nim">NIM</label>
                            <input id="nim" name="nim" class="form-control mb-3" type="text" maxlength="10"
                                required placeholder="NIM">
                        </div>
                        <div class="form-label col-md-6">
                            <label class="mb-2 required" for="graduation_date">Tanggal Lulus</label>
                            <input id="graduation_date" name="graduation_date" class="form-control mb-3" type="date"
                                required>
                        </div>
                        <div class="form-label col-md-12">
                            <label class="mb-2 required" for="study_program">Prodi</label>
                            <select id="study_program" name="study_program" class="form-control mb-3"
                                style="width: 100%;" required>
                                <option value="">- Pilih Program Studi -</option>
                            </select>
                        </div>

                        <div class="col-12 d-flex justify-content-center mt-5">
                            <button type="submit" class="btn btn-primary p-3 px-4 fw-bold rounded-pill">Cek Validasi
                                Data</button>
                        </div>

                    </div>
                </form>
            @else
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
<div style="height: 200px"></div>
@include('landingPage.script.script-validate')
