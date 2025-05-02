<div class="modal viewForm" id="modal_user" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript:onSave(this)" method="post" id="form_user" name="form_user"
                    autocomplete="off">
                    
                    <input id="id" name="id" type="hidden">

                    <div class="form-label">
                        <label class="mb-2 required" for="fullname">Nama Lengkap</label>
                        <input id="fullname" required name="fullname" class="form-control mb-3" type="text"
                            placeholder="Nama Lengkap">
                    </div>

                    <div class="form-label">
                        <label class="mb-2 required" for="email">Email</label>
                        <input id="email" required name="email" class="form-control mb-3" type="email"
                            placeholder="Email">
                    </div>

                    <div class="form-label">
                        <label class="mb-2 required" for="password">Password</label>
                        <input id="password" required name="password" class="form-control mb-3" type="password"
                            placeholder="Password">
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
