<style>
    .questionnaire-card {
        transition: all 0.3s ease-in-out;
        cursor: pointer;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        background-color: #ffffff;
    }

    .questionnaire-card:hover {
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.25);
        transform: translateY(-6px);
        background-color: #f9fafb;
    }
</style>

<div class="row">
    @include('backoffice.questionnaire.form')
    <div class="col-12">
        <div class="d-flex justify-content-end align-items-center gap-2 mb-2 flex-wrap">


            @if ($is_super)
                <button type="button" onclick="showForm()" class="btn btn-primary d-flex align-items-center">
                    <i data-feather="plus" class="me-2"></i> Tambah
                </button>
            @endif


        </div>
        <div class="d-flex justify-content-end align-items-center gap-2 mb-4 flex-wrap">
            <button type="button" class="btn btn-outline-info me-2 position-relative" data-bs-toggle="modal"
                data-bs-target="#filterModal" id="btnFilter">
                <i class="fa fa-filter"></i> Filter
                <span id="filter-indicator"
                    class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle d-none">
                    <span class="visually-hidden">Filter aktif</span>
                </span>
            </button>
            <button type="button" onclick="initTable()" class="btn btn-light d-flex  align-items-center"
                style="border: 1px solid grey">
                <i data-feather="rotate-ccw" class="me-2"></i> Muat Ulang
            </button>
        </div>

        <div class="row" id="questionnaire-cards">
        </div>
        {{-- <div class="card">

            <div class="card-body">
                <div class="form-group d-flex justify-content-end mb-3">
                    <button type="button" class="btn btn-outline-info me-2" data-bs-toggle="modal" data-bs-target="#filterModal"
                        style="float: left">
                        <i class="fa fa-filter"></i> Filter
                    </button>
                    <button type="button" onclick="showForm()" class="btn btn-primary me-3"><i class="align-middle"
                            data-feather="plus"> </i> Tambah</button>
                    <button type="button" onclick="initTable()" class="btn btn-light d-flex  align-items-center"
                style="border: 1px solid grey">
                <i data-feather="rotate-ccw" class="me-2"></i> Muat Ulang
            </button>
                </div>
                <div class="table-responsive">
                    <table
                        class="table table-striped table-hover table-row-bordered border nowrap align-middle rounded w-100"
                        id="table_questionnaire">
                        <thead class="text-center">
                            <tr class="fw-bolder">
                                <th style="width: 50px">No</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Tahun Periode</th>
                                <th>Berlaku Untuk</th>
                                <th>Status Display</th>
                                <th>Set Dashboard<br><span
                                        style="font-size: 11px; font-weight: normal !important;">(pilih salah
                                        satu)</span></th>
                                <th style="width: 100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> --}}
    </div>
</div>
<div class="modal fade filterModal" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Kuisioner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="filter_title col-12" class="form-label">Judul</label>
                    <input type="text" id="filter_title" class="form-control" style="width: 100" />
                </div>
                <div class="mb-3">
                    <label for="filter_type col-12" class="form-label">berlaku Untuk</label>
                    <select id="filter_type" class="form-control" style="width: 100%">
                        <option value="">-- Pilih Berlaku Untuk --</option>
                        <option value="alumni">Alumni</option>
                        <option value="superior">Atasan Alumni</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="filter_period_year col-12" class="form-label">Tahun Periode</label>
                    <input type="text" id="filter_period_year" class="form-control" style="width: 100"
                        maxlength="4" />
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
@include('backoffice.questionnaire.javascript')
