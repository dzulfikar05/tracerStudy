<div class="row index-page">
    @include('backoffice.content.form')
    <div class="col-12">
        <div class="card">
            {{-- <div class="card-header">
                <div class="card-title">Job Category</div>
            </div> --}}
            <div class="card-body">
                <div class="row align-items-center mb-3">
                    <div class="col-md-2">
                        <select id="filter_type" class="form-select" aria-label="Default select example">
                            <option value="">Pilih Tipe Konten</option>
                            <option value="carousel">Gambar Carousel</option>
                            <option value="home">Konten Halaman Home</option>
                            <option value="about">Konten Halaman About</option>
                        </select>
                    </div>
                    <div class="col-md-10">
                        <div class="d-flex justify-content-end">
                            <button type="button" onclick="showForm()" class="btn btn-primary me-2">
                                <i class="align-middle" data-feather="plus"></i> Tambah
                            </button>
                            <button type="button" onclick="initTable()" class="btn btn-light">
                                <i class="align-middle" data-feather="rotate-ccw"></i> Refresh
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table
                        class="table table-striped table-hover table-row-bordered border nowrap  align-middle rounded w-100"
                        id="table_content">
                        <thead class="text-center">
                            <tr class="fw-bolder">
                                <th style="width: 50px">No</th>
                                <th>Tipe</th>
                                <th>Judul</th>
                                <th>Order</th>
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

@include('backoffice.content.javascript')
