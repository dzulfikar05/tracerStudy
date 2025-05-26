<div class="modal viewForm" id="modal_alumni" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Alumni</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript:onSave(this)" method="post" id="form_alumni" name="form_alumni"
                    autocomplete="off">
                    <input id="id" name="id" type="hidden">
                    <div class="row">
                        <div class="form-label col-md-6">
                            <label class="mb-2 required" for="full_name">Nama Lengkap</label>
                            <input id="full_name" name="full_name" class="form-control mb-3" type="text" required
                                placeholder="Nama Lengkap">
                        </div>

                        <div class="form-label col-md-6">
                            <label class="mb-2 required" for="nim">NIM</label>
                            <input id="nim" name="nim" class="form-control mb-3" type="text" max="10"
                                required placeholder="NIM">
                        </div>

                        <div class="form-label col-md-6">
                            <label class="mb-2 required col-12" for="study_program">Program Studi</label>
                            <select name="study_program" id="study_program" class="form-control mb-3"
                                style="width: 100%" required>
                                <option value="">- Pilih Program Studi -</option>
                            </select>
                        </div>

                        <div class="form-label col-md-6">
                            <label class="mb-2 required" for="study_start_year">Tahun Mulai Studi</label>
                            <input id="study_start_year" name="study_start_year" class="form-control mb-3"
                                type="number" min="1900" max="{{ date('Y') }}" required
                                placeholder="Tahun Mulai Studi">
                        </div>

                        <div class="form-label col-md-6">
                            <label class="mb-2 required" for="graduation_date">Tanggal Lulus</label>
                            <input id="graduation_date" name="graduation_date" class="form-control mb-3" type="date"
                                required>
                        </div>

                        <div class="form-label col-md-6">
                            <label class="mb-2" for="phone">Telepon</label>
                            <input id="phone" name="phone" class="form-control mb-3" type="text"
                                placeholder="Nomor Telepon">
                        </div>

                        <div class="form-label col-md-6">
                            <label class="mb-2" for="email">Email</label>
                            <input id="email" name="email" class="form-control mb-3" type="email"
                                placeholder="Email">
                        </div>

                        <div class="form-label col-md-6">
                            <label class="mb-2" for="start_work_date">Tanggal Mulai Kerja</label>
                            <input id="start_work_date" name="start_work_date" class="form-control mb-3" type="date">
                        </div>

                        <div class="form-label col-md-6">
                            <label class="mb-2" for="start_work_now_date">Tanggal Mulai Sekarang</label>
                            <input id="start_work_now_date" name="start_work_now_date" class="form-control mb-3"
                                type="date">
                        </div>
                        <div class="form-label col-md-6">
                            <label class="mb-2 col-12" for="profession_category_id">Kategori Profesi</label>
                            <select id="profession_category_id" name="profession_category_id" class="form-control mb-3"
                                style="width: 100%">
                                <option value="">- Pilih Kategori Profesi -</option>
                            </select>
                        </div>
                        <div class="form-label col-md-6">
                            <label class="mb-2 col-12" for="profession_id">Profesi</label>
                            <select id="profession_id" name="profession_id" class="form-control mb-3"
                                style="width: 100%">
                                <option value="">- Pilih Profesi -</option>
                            </select>
                        </div>

                        <div class="form-label col-md-6">
                            <label class="mb-2 col-12" for="company_id">Perusahaan</label>
                            <select id="company_id" name="company_id" class="form-control mb-3" style="width: 100%">
                                <option value="">- Pilih Perusahaan -</option>
                            </select>
                        </div>
                        <div class="form-label col-md-6">
                            <label class="mb-2 col-12" for="superior_id">Atasan</label>
                            <select id="superior_id" name="superior_id" class="form-control mb-3"
                                style="width: 100%">
                                <option value="">- Pilih Atasan -</option>
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
