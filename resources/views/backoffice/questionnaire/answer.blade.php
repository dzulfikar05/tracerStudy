<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-row-bordered border align-middle rounded w-100 nowrap"
                        id="table_answer">
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <a href="{{ route('backoffice.questionnaire.index') }}" class="btn btn-primary">
                                        <i class="fa fa-arrow-left"></i> Back
                                    </a>
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-outline-info me-2" data-bs-toggle="modal"
                                            data-bs-target="#filterModal">
                                            <i class="fa fa-filter"></i> Filter
                                        </button>
                                        <button type="button" class="btn btn-primary me-2 btn-export-excel">
                                            <i class="align-middle" data-feather="download"></i> Export Excel
                                        </button>
                                    </div>
                                </div>


                                <thead class="text-center">
                                    <tr class="fw-bolder">
                                        <th style="width: 50px">No</th>

                                        @if ($data['type'] === 'alumni')
                                            <th>Program Studi</th>
                                            <th>NIM</th>
                                            <th>Nama</th>
                                            <th>No. HP</th>
                                            <th>Email</th>
                                            <th>Angkatan</th>
                                            <th>Tanggal Lulus</th>
                                            <th>Tahun Lulus</th>
                                            <th>Tanggal Pertama Kerja</th>
                                            <th>Masa Tunggu</th>
                                            <th>Tanggal Kerja Instansi</th>

                                            <th>Jenis Instansi</th>
                                            <th>Nama Instansi</th>
                                            <th>Skala</th>
                                            <th>Lokasi</th>

                                            <th>Kategori Profesi</th>
                                            <th>Profesi</th>

                                            <th>Nama Atasan Langsung</th>
                                            <th>Jabatan Atasan Langsung</th>
                                            <th>No. HP Atasan Langsung</th>
                                            <th>Email Atasan</th>
                                        @elseif ($data['type'] === 'superior')
                                            <th>Nama</th>
                                            <th>Instansi</th>
                                            <th>Jabatan</th>
                                            <th>Email</th>

                                            <th>Nama Alumni</th>
                                            <th>Program Studi</th>
                                            <th>Angkatan</th>
                                            <th>Tahun Lulus</th>
                                        @endif



                                        @foreach ($data['questions'] as $question)
                                            <th>{{ $question->question }}</th>
                                        @endforeach

                                        <th style="width: 100px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </div>
                        </div>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade filterModal" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Jawaban</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="filter_study_program" class="form-label col-12">Program Studi</label>
                        <select id="filter_study_program" name="filter_study_program" class="form-control"
                            style="width: 100%">
                            <option value="">-- Pilih Program Studi --</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="filter_nim" class="form-label col-12">NIM</label>
                        <input type="text" id="filter_nim" class="form-control" style="width: 100%">
                    </div>
                    <div class="col-md-6">
                        <label for="filter_study_start_year" class="form-label col-12">Tahun Angkatan</label>
                        <input type="text" id="filter_study_start_year" class="form-control" style="width: 100%">
                    </div>
                    <div class="col-md-6">
                        <label for="filter_graduation_year" class="form-label col-12">Tahun Lulus</label>
                        <input type="text" id="filter_graduation_year" class="form-control" style="width: 100%">
                    </div>
                    <div class="col-md-6">
                        <label for="filter_company" class="form-label col-12">Perusahaan</label>
                        <select id="filter_company" name="filter_company" class="form-control" style="width: 100%">
                            <option value="">-- Pilih Perusahaan --</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="filter_profession_category" class="form-label col-12">Kategori Profesi</label>
                        <select id="filter_profession_category" name="filter_profession_category" class="form-control"
                            style="width: 100%">
                            <option value="">-- Pilih Kategori Profesi --</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="filter_profession" class="form-label col-12">Profesi</label>
                        <select id="filter_profession" name="filter_profession" class="form-control"
                            style="width: 100%">
                            <option value="">-- Pilih Profesi --</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="applyFilter()" class="btn btn-primary">Terapkan</button>
                <button type="button" onclick="resetFilter()" class="btn btn-secondary"
                    data-bs-dismiss="modal">Reset</button>
            </div>
        </div>
    </div>
</div>


@include('backoffice.questionnaire.javascriptAnswer')
