<div class="modal viewForm" id="modal_company" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Company</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript:onSave(this)" method="post" id="form_company" name="form_company"
                    autocomplete="off">

                    <div class="form-label">
                        <input id="id" name="id" type="hidden">
                        <label class="mb-2 required" for="name">Nama</label>
                        <input id="name" required name="name" class="form-control mb-3" type="text"
                            placeholder="Nama">
                    </div>
                    <div class="form-label">
                        <label class="mb-2 required col-12" for="name">Tipe Perusahaan</label>
                        <select id="company_type" required name="company_type" class="form-control mb-3 col-12"
                            style="width: 100%">
                            <option value="">Pilih Kategori Perusahaan</option>
                            <option value="higher_education">Pendidikan Tinggi</option>
                            <option value="government_agency">Instansi Pemerintah</option>
                            <option value="state-owned_enterprise">BUMN</option>
                            <option value="private_company">Perusahaan Swasta</option>
                        </select>
                    </div>
                    <div class="form-label">
                        <label class="mb-2 required col-12" for="name">Skala</label>
                        <select id="scope" required name="scope" class="form-control mb-3 col-12"
                            style="width: 100%">
                            <option value="">Pilih Skala</option>
                            <option value="local">Lokal</option>
                            <option value="national">Nasional</option>
                            <option value="international">Internasional</option>
                        </select>
                    </div>
                    <div class="form-label">
                        <label class="mb-2 required col-12" for="address">Alamat</label>
                        <textarea class="form-control  mb-3 col-12" name="address" id="address"></textarea>
                    </div>
                    <div class="form-label">
                        <label class="mb-2 required col-12" for="phone">Telepon</label>
                        <input id="phone" name="phone" class="form-control mb-3" type="text"
                            placeholder="Telepon, ex: 0341...">
                    </div>

                    <div class="form-group mt-5 d-flex justify-content-end">
                        <button type="button" onclick="onReset()" class="btn btn-light me-3"><i class="align-middle"
                                data-feather="rotate-ccw"> </i> Reset</button>
                        <button type="submit" class="btn btn-success"><i class="align-middle" data-feather="save"> </i>
                            Simpan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
