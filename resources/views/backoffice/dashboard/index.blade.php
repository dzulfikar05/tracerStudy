<style>
    .nav-tabs .nav-link {
        background-color: #cfe2ff;
        margin-right: 2px;
        color: #000;
        transition: all 0.3s ease;
    }

    .nav-tabs .nav-link:hover {
        background-color: #a8d0ff;
    }

    .nav-tabs .nav-link.active {
        background-color: #fff;
        border-bottom: none;
        font-weight: bold;
    }

    .tab-content {
        border-top: none;
        margin-top: 20px;
    }

    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        border-radius: 10px;
    }

    .card-title {
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }
</style>

<div class="row">
    <div class="col-12 filter_card">
        <div class="card p-3">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="filter_year_start" class="form-label">Filter Range Tahun:</label>
                    <select name="filter_year_start" id="filter_year_start" class="form-control form-select">
                        <option value="">- Mulai Tahun -</option>
                        @for ($i = date('Y'); $i >= date('Y') - 15; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filter_year_end" class="form-label">&nbsp;</label>
                    <select name="filter_year_end" id="filter_year_end" class="form-control form-select">
                        <option value="">- Sampai Tahun -</option>
                        @for ($i = date('Y'); $i >= date('Y') - 15; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="filter_study_program" class="form-label">Filter Prodi:</label>
                    <select name="filter_study_program" id="filter_study_program" class="form-control form-select">
                        <option value="">- Pilih Prodi -</option>
                        <option value="D4 Teknik Informatika">D4 Teknik Informatika</option>
                        <option value="D4 Sistem Informasi Bisnis">D4 Sistem Informasi Bisnis</option>
                        <option value="D2 PPLS">D2 PPLS</option>
                        <option value="S2 MRTI">S2 MRTI</option>
                    </select>
                </div>
                <div class="col-md-12 mt-3 d-flex gap-2">
                    <button type="button" class="btn btn-primary" id="btn_filter" onclick="onFetchFilter()">
                        <i class="fa fa-filter"></i> Terapkan Filter
                    </button>
                    <button type="button" class="btn btn-outline-secondary" id="btn_reset" onclick="onResetFilter()">
                        <i class="fa fa-undo"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 mt-4">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="general-tab" data-toggle="tab" href="#dashboard-general"
                    role="tab">Dashboard Umum</a>
            </li>
            <li class="nav-item" id="assessment-tab">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#dashboard-assessment"
                    role="tab">Dashboard Penilaian</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="dashboard-general" role="tabpanel">
                <div class="row g-4 mt-2">
                    <div class="col-md-4">
                        <div class="card p-3">
                            <canvas id="professionChart" height="300"></canvas>
                        </div>
                        <div class="card p-3 mt-3">
                            <canvas id="categoryProfessionChart" height="300"></canvas>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card p-3 mb-3">
                            <div class="card-title fs-4">Tabel Sebaran Lingkup Tempat Kerja dan Kesesuaian Profesi
                                dengan Infokom</div>
                            <div class="table-responsive">
                                <table id="table_profession"
                                    class="table table-striped table-hover border rounded w-100 text-center">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th rowspan="2">Tahun Lulus</th>
                                            <th rowspan="2">Jumlah Lulusan</th>
                                            <th rowspan="2">Jumlah Lulusan yang Terlacak</th>
                                            <th colspan="2">Profesi Kerja</th>
                                            <th colspan="3">Lingkup Tempat Kerja</th>
                                        </tr>
                                        <tr>
                                            <th>Bidang Infokom</th>
                                            <th>Bidang Non Infokom</th>
                                            <th>Multinasional/Internasional</th>
                                            <th>Nasional</th>
                                            <th>Wirausaha</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot class="fw-bold text-white bg-secondary">
                                        <tr>
                                            <td>Jumlah</td>
                                            <td id="sum_count_alumni"></td>
                                            <td id="sum_count_alumni_filled"></td>
                                            <td id="sum_infokom"></td>
                                            <td id="sum_non_infokom"></td>
                                            <td id="sum_multi"></td>
                                            <td id="sum_national"></td>
                                            <td id="sum_wirausaha"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="card p-3">
                            <div class="card-title fs-4">Tabel Rata-rata Masa Tunggu</div>
                            <div class="table-responsive">
                                <table id="table_waiting_time"
                                    class="table table-striped table-hover border rounded w-100 text-center">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>Tahun Lulus</th>
                                            <th>Jumlah Lulusan</th>
                                            <th>Jumlah Lulusan yang Terlacak</th>
                                            <th>Rata-rata Waktu Tunggu (Bulan)</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="dashboard-assessment" role="tabpanel">
                <div class="card p-3 mt-3">
                    <div class="card-title fs-4">Tabel Penilaian</div>
                    <div class="table-responsive">
                        <table id="table_assessment"
                            class="table table-bordered table-hover table-striped border rounded w-100"></table>
                    </div>
                    <div id="chart-assessment" class="row mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('backoffice.dashboard.javascript')
