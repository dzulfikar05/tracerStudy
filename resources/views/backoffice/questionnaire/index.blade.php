<div class="row">
    @include('backoffice.questionnaire.form')
    <div class="col-12">
        <div class="card">
            {{-- <div class="card-header">
                <div class="card-title">Job Category</div>
            </div> --}}
            <div class="card-body">
                <div class="form-group d-flex justify-content-end mb-3">
                    <button type="button" onclick="showForm()" class="btn btn-primary me-3"><i class="align-middle" data-feather="plus"> </i> Tambah</button>
                    <button type="button" onclick="initTable()" class="btn btn-light "><i class="align-middle" data-feather="rotate-ccw"> </i> Refresh</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-row-bordered border align-middle rounded w-100" id="table_questionnaire">
                        <thead class="text-center">
                            <tr class="fw-bolder">
                                <th style="width: 50px">No</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Tahun Periode</th>
                                <th>Berlaku Untuk</th>
                                <th>Status Display</th>
                                <th>Set Dashboard<br><span style="font-size: 11px; font-weight: normal !important;">(pilih salah satu)</span></th>
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

@include('backoffice.questionnaire.javascript')
