<div class="row">
    @include('backoffice.alumni.form')
    <div class="col-12">
        <div class="card">
            {{-- <div class="card-header">
                <div class="card-title">Job Category</div>
            </div> --}}
            <div class="card-body">
                <div class="form-group d-flex justify-content-end mb-3">
                    <button type="button" class="btn btn-info me-2" data-bs-toggle="modal" data-bs-target="#filterModal"
                        style="float: left">
                        <i class="fa fa-filter"></i> Filter
                    </button>

                    <button onclick="modalAction('{{ route('backoffice.alumni.alumni.import') }}')"
                        class="btn btn-success me-2">
                        <i class="fa fa-upload"></i> Import Excel</button>
                    <button type="button" id="btnExportExcel" class="btn btn-primary me-2"><i class="align-middle"
                            data-feather="download"></i> Export Excel</button>
                    <button type="button" onclick="showForm()" class="btn btn-primary me-3"><i class="align-middle"
                            data-feather="plus"> </i> Tambah</button>
                    <button type="button" onclick="initTable()" class="btn btn-light "><i class="align-middle"
                            data-feather="rotate-ccw"> </i> Refresh</button>
                </div>
                <div class="table-responsive">
                    <table
                        class="table table-striped table-hover table-row-bordered border align-middle nowrap rounded w-100 overflow-y-auto"
                        id="table_alumni">
                        <thead class="text-center">
                            <tr class="fw-bolder">
                                <th style="width: 50px">No</th>
                                <th>Nama Lengkap</th>
                                <th>NIM</th>
                                <th>Program Studi</th>
                                <th>Tahun Angkatan </th>
                                <th>Tanggal Lulus</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Tanggal Pertama Kerja</th>
                                <th>Lama Tunggu Kerja</th>
                                <th>Tanggal Kerja Instansi</th>
                                <th>Perusahaan</th>
                                <th>Kategori Profesi</th>
                                <th>Profesi</th>
                                <th>Atasan</th>
                                <th style="width: 100px">Aksi</th>
                            </tr>

                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal untuk Import -->
<div id="myModal" class="modal fade" tabindex="-1" aria-hidden="true">
</div>
<div class="modal fade filterModal" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Alumni</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="filter_nim" class="form-label">NIM</label>
                    <input type="text" id="filter_nim" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="filter_study_program col-12" class="form-label">Program Studi</label>
                    <select id="filter_study_program" class="form-control" style="width: 100%"></select>
                </div>
                <div class="mb-3">
                    <label for="filter_study_start_year" class="form-label">Tahun Angkatan</label>
                    <input type="text" id="filter_study_start_year" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="filter_company_id col-12" class="form-label">Perusahaan</label>
                    <select id="filter_company_id" class="form-control" style="width: 100%"></select>
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

@include('backoffice.alumni.javascript')
