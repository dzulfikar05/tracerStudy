<div class="row">
    @include('backoffice.superiors.form')
    <div class="col-12">
        <div class="card">
            {{-- <div class="card-header">
                <div class="card-title">Job Category</div>
            </div> --}}
            <div class="card-body">
                <div class="form-group d-flex justify-content-end mb-3">
                     <button type="button" class="btn btn-info me-2" data-bs-toggle="modal" data-bs-target="#filterModal" style="float: left">
                        <i class="fa fa-filter"></i> Filter
                    </button>

                    <a id="btnExportExcel" href="#" class="btn btn-success me-3">
                        <i class="align-middle" data-feather="file-text"></i> Export Excel
                    </a>

                    <button type="button" onclick="showForm()" class="btn btn-primary me-2"><i class="align-middle" data-feather="plus"> </i> Tambah</button>
                    <button type="button" onclick="initTable()" class="btn btn-light "><i class="align-middle" data-feather="rotate-ccw"> </i> Refresh</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-row-bordered border align-middle rounded w-100 overflow-y-auto" id="table_superiors">
                        <thead class="text-center">
                            <tr class="fw-bolder">
                                <th style="width: 50px">No</th>
                                <th>Nama Lengkap</th>
                                <th>Jabatan</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Perusahaan</th>
                                <th>List Alumni</th>
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

<div id="myModal" class="modal fade" tabindex="-1" aria-hidden="true">
</div>
<div class="modal fade filterModal" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="filterModalLabel">Filter Atasan Alumni</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        {{-- <div class="mb-3">
            <label for="filter_position col-12" class="form-label">Jabatan</label>
            <select id="filter_position" class="form-control" style="width: 100%"></select>
        </div> --}}
        <div class="mb-3">
            <label for="filter_company_id col-12" class="form-label">Perusahaan</label>
            <select id="filter_company_id" class="form-control" style="width: 100%"></select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="applyFilter()" class="btn btn-primary">Terapkan</button>
        <button type="button" onclick="resetFilter()" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
      </div>
    </div>
  </div>
</div>
<div id="myModal" class="modal fade" tabindex="-1" aria-hidden="true"></div>

@include('backoffice.superiors.javascript')
