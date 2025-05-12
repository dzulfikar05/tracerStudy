<div class="modal viewForm" id="modal_superiors" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Superiors</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript:onSave(this)" method="post" id="form_superiors" name="form_superiors" autocomplete="off">
                    <input id="id" name="id" type="hidden">
                    <div class="row">
                        <div class="form-label col-md-6">
                            <label class="mb-2 required" for="full_name">Nama Lengkap</label>
                            <input id="full_name" name="full_name" class="form-control mb-3" type="text" required placeholder="Nama Lengkap">
                        </div>

                        <div class="form-label col-md-6">
                            <label class="mb-2 required" for="position">Jabatan</label>
                            <input id="position" name="position" class="form-control mb-3" type="text" required placeholder="Jabatan">
                        </div>

                        <div class="form-label col-md-6">
                            <label class="mb-2 required" for="phone">Telepon</label>
                            <input id="phone" name="phone" class="form-control mb-3" type="text" required placeholder="Nomor Telepon">
                        </div>

                        <div class="form-label col-md-6">
                            <label class="mb-2 required" for="email">Email</label>
                            <input id="email" name="email" class="form-control mb-3" type="email" required placeholder="Email">
                        </div>

                        <div class="form-label col-md-12">
                            <label class="mb-2 required col-12" for="company_id">Perusahaan</label>
                            <select id="company_id" name="company_id" class="form-control mb-3" style="width: 100%" required>
                                <option value="">- Pilih Perusahaan -</option>
                            </select>
                        </div> 
                    </div>

                    <div class="form-group mt-5 d-flex justify-content-end">
                        <button type="button" onclick="onReset()" class="btn btn-light me-3">
                            <i class="align-middle" data-feather="rotate-ccw"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="align-middle" data-feather="save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
