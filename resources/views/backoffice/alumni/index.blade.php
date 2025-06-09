<div class="row">
    @include('backoffice.alumni.form')
    <div class="col-12">
        <div class="card">
            {{-- <div class="card-header">
                <div class="card-title">Job Category</div>
            </div> --}}
            <div class="card-body">

                <div class="row">
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-3 mb-4">
                                <div class="stat-card">
                                    <div class="stat-row">
                                        <i class="bi bi-people-fill text-primary stat-icon"></i>
                                        <div id="count_alumni" class="stat-number">0</div>
                                    </div>
                                    <div class="stat-label">Total Alumni</div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="stat-card">
                                    <div class="stat-row">
                                        <i class="bi bi-check-circle-fill text-success stat-icon"></i>
                                        <div id="count_alumni_fill" class="stat-number">0</div>
                                    </div>
                                    <div class="stat-label">Sudah Mengisi</div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="stat-card">
                                    <div class="stat-row">
                                        <i class="bi bi-x-circle-fill text-danger stat-icon"></i>
                                        <div id="count_alumni_unfill" class="stat-number">0</div>
                                    </div>
                                    <div class="stat-label">Belum Mengisi</div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="stat-card">
                                    <div class="stat-row">
                                        <i class="bi bi-clock-history text-warning stat-icon"></i>
                                        <div id="count_alumni_avg_waiting_time" class="stat-number" style="font-size: 24px !important">0 Bulan</div>
                                    </div>
                                    <div class="stat-label">Rata-rata Waktu Tunggu</div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="form-group d-flex justify-content-end mb-3">

                            <button onclick="modalAction('{{ route('backoffice.alumni.alumni.import') }}')"
                                class="btn btn-success me-2">
                                <i data-feather="upload"></i> Import Excel</button>
                            <button type="button" id="btnExportExcel" class="btn btn-primary me-2"><i
                                    class="align-middle" data-feather="download"></i> Export Excel</button>
                            <button type="button" onclick="showForm()" class="btn btn-primary"><i class="align-middle"
                                    data-feather="plus"> </i> Tambah</button>

                        </div>
                        <div class="form-group d-flex justify-content-end mb-3">
                            <button type="button" class="btn btn-outline-info me-2 position-relative"
                                data-bs-toggle="modal" data-bs-target="#filterModal" id="btnFilter">
                                <i class="fa fa-filter"></i> Filter
                                <span id="filter-indicator"
                                    class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle d-none">
                                    <span class="visually-hidden">Filter aktif</span>
                                </span>
                            </button>
                            <button type="button" onclick="initTable()"
                                class="btn btn-light d-flex  align-items-center" style="border: 1px solid grey">
                                <i data-feather="rotate-ccw" class="me-2"></i> Muat Ulang
                            </button>
                        </div>
                    </div>
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
                <div class="mb-3">
                    <label for="filter_filled col-12" class="form-label">Status Kuisioner</label>
                    <select id="filter_filled" class="form-control" style="width: 100%">
                        <option value="">- Pilih Status Kuisioner -</option>
                        <option value="unfilled">Belum diisi</option>
                        <option value="filled">Sudah diisi</option>
                    </select>
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
<style>
    .stat-card {
        border-radius: 8px;
        background: #fff;
        padding: 1.2rem 1.5rem;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s ease-in-out;
        border: 1px solid #e0e0e0;
        cursor: default;
    }

    .stat-card:hover {
        transform: translateY(-4px);
    }

    .stat-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.8rem;
    }

    .stat-icon {
        font-size: 2.5rem;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #212529;
    }

    .stat-label {
        margin-top: 0.4rem;
        text-align: center;
        font-size: 1rem;
        color: #6c757d;
    }

    /* optional colors */
    .text-primary {
        color: #007bff !important;
    }

    .text-success {
        color: #28a745 !important;
    }

    .text-danger {
        color: #dc3545 !important;
    }

    .text-warning {
        color: #ffc107 !important;
    }
</style>
@include('backoffice.alumni.javascript')
