<div class="modal viewForm" id="modal_profession" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Profesi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript:onSave(this)" method="post" id="form_profession" name="form_profession"
                    autocomplete="off">
                    <div class="form-label">
                        <label class="mb-2 required col-12" for="name">Kategori Profesi</label>
                        <select id="profession_category_id" required name="profession_category_id" class="form-control mb-3 col-12" style="width: 100%">
                            <option value="">Pilih Kategori Profesi</option>
                        </select>
                    </div>
                    <div class="form-label">
                        <input id="id" name="id" type="hidden">
                        <label class="mb-2 required" for="name">Nama</label>
                        <input id="name" required name="name" class="form-control mb-3" type="text"
                            placeholder="Nama">
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
