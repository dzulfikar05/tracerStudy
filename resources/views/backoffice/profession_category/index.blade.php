<div class="row">
    @include('backoffice.profession_category.form')
    <div class="col-12">
        <div class="card">
            {{-- <div class="card-header">
                <div class="card-title">Job Category</div>
            </div> --}}
            <div class="card-body">
                <div class="form-group d-flex justify-content-end mb-3">
                    <button type="button"
                        onclick="window.location.href='{{ route('backoffice.master.profession-category.export') }}'"
                        class="btn btn-primary me-2"><i class="align-middle" data-feather="file-text"></i> Export Excel</button>
                    <button type="button" onclick="showForm()" class="btn btn-primary me-2"><i class="align-middle"
                            data-feather="plus"> </i> Tambah</button>
                    <button type="button" onclick="initTable()" class="btn btn-light d-flex  align-items-center"
                        style="border: 1px solid grey">
                        <i data-feather="rotate-ccw" class="me-2"></i> Muat Ulang
                    </button>
                </div>
                <div class="table-responsive">
                    <table
                        class="table table-striped table-hover table-row-bordered border nowrap align-middle rounded w-100"
                        id="table_profession_category">
                        <thead class="text-center">
                            <tr class="fw-bolder">
                                <th style="width: 50px">No</th>
                                <th>Nama</th>
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

@include('backoffice.profession_category.javascript')
