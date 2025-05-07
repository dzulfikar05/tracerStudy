<div class="row">
    @include('backoffice.alumni.form')
    <div class="col-12">
        <div class="card">
            {{-- <div class="card-header">
                <div class="card-title">Job Category</div>
            </div> --}}
            <div class="card-body">
                <div class="form-group d-flex justify-content-end mb-3">
                <button onclick="modalAction('{{ route('backoffice.alumni.alumni.import') }}')" class="btn btn-success me-2">
                <i class="fa fa-upload"></i> Import Excel</button>

                    <button type="button" onclick="window.location.href='{{ route('backoffice.alumni.export') }}'" class="btn btn-primary me-2"><i class="align-middle" data-feather="download"></i> Export Excel</button>
                    <button type="button" onclick="showForm()" class="btn btn-primary me-3"><i class="align-middle" data-feather="plus"> </i> Tambah</button>
                    <button type="button" onclick="initTable()" class="btn btn-light "><i class="align-middle" data-feather="rotate-ccw"> </i> Refresh</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-row-bordered border align-middle rounded w-100 overflow-y-auto" id="table_alumni">
                        <thead class="text-center">
                            <tr class="fw-bolder">
                                <th style="width: 50px">No</th>
                                <th>Nama Lengkap</th>
                                <th>NIM</th>
                                <th>Program Studi</th>
                                <th>Tanggal Lulus</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Tanggal Mulai Kerja</th>
                                <th>Tanggal Mulai Sekarang</th>
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
@include('backoffice.alumni.javascript')
