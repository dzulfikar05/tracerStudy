<div class="modal viewForm" id="modal_questionnaire" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Kuisioner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript:onSave(this)" method="post" id="form_questionnaire" name="form_questionnaire"
                    autocomplete="off">

                    <input id="id" name="id" type="hidden">
                    <div class="form-label">
                        <label class="mb-2 required col-12" for="type">Berlaku Untuk</label>
                        <select id="type" required name="type" style="width: 100%" class="form-control mb-3">
                            <option value="">- Pilih -</option>
                            <option value="alumni">Alumni</option>
                            <option value="superior">Atasan Alumni</option>
                        </select>
                    </div>
                    <div class="form-label">
                        <label class="mb-2 required" for="period_year">Tahun Periode</label>
                        <input id="period_year" required name="period_year" class="form-control mb-3" type="period_year" maxlength="4" placeholder="Tahun">
                    </div>
                    <div class="form-label">
                        <label class="mb-2 required" for="title">Judul</label>
                        <input id="title" required name="title" class="form-control mb-3" type="text"
                            placeholder="Judul">
                    </div>
                    <div class="form-label">
                        <label class="mb-2 required" for="description">Deskripsi</label>
                        <textarea id="description" required name="description" class="form-control mb-3" placeholder="Deskripsi"></textarea>
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
