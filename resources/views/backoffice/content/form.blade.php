<div class="modal viewForm" id="modal_content" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Kontent Website</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript:onSave(this)" method="post" id="form_content" name="form_content" autocomplete="off" >
                    <div class="form-label">
                        <label class="mb-2 required col-12" for="type">Tipe</label>
                        <select id="type" required name="type" class="form-control mb-3 col-12"
                            style="width: 100%">
                            <option value="">Pilih Tipe Konten</option>
                            <option value="carousel">Gambar Carousel</option>
                            <option value="home">Konten Halaman Home</option>
                            <option value="about">Konten Halaman About</option>
                        </select>
                    </div>
                    <div class="form-label">
                        <input id="id" name="id" type="hidden">
                        <label class="mb-2 required" for="title">title</label>
                        <input id="title" required name="title" class="form-control mb-3" type="text"
                            placeholder="title">
                    </div>
                    <div class="form-label">
                        <label class="mb-2 col-12">Gambar</label>
                        <div id="drop-area" class="border p-3 rounded text-center" style="cursor: pointer;">
                            <p class="mb-1">Drag & drop gambar di sini, atau klik untuk memilih file</p>
                            <input type="file" name="image" id="image" class="d-none" accept="image/*">
                            <img id="image-preview" src="" alt="Preview" class="img-fluid mt-2"
                                style="max-height: 200px; display: none;">
                        </div>
                    </div>

                    <textarea name="text" id="text" class="form-control"></textarea>



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
<style>
#drop-area {
    background-color: #f9f9f9;
    border: 2px dashed #ccc;
    transition: 0.2s;
}
#drop-area.dragover {
    background-color: #eef;
    border-color: #007bff;
}
</style>
