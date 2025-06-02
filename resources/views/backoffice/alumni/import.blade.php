<form action="{{ route('backoffice.alumni.alumni.import_ajax') }}" method="POST" id="form-import"
    enctype="multipart/form-data">
    @csrf
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data Alumni</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Pilih File Excel</label>
                    <input type="file" name="file_alumni" class="form-control" required>
                    <small id="error-file_alumni" class="form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <a href="/file/template_import_alumni.xlsx" class="btn btn-primary" target="_blank">
                    <i class="fa fa-download"></i> Download Template
                </a>

                <button type="submit" class="btn btn-primary">Import</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</form>

<script>
    $('#form-import').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.status) {
                    $('#myModal').modal('hide');
                    saMessage({
                        success: true,
                        title: 'Sukses!',
                        message: res.message,
                        callback: function() {
                            $('#table_alumni').DataTable().ajax.reload();
                        }
                    })
                } else {
                    Swal.fire('Gagal!', res.message, 'error');
                }
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#form-import").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.status) {
                        $('#myModal').modal('hide');
                        Swal.fire('Sukses!', res.message, 'success');
                        location.reload();
                    } else {
                        Swal.fire('Gagal!', res.message, 'error');
                        $.each(res.msgField, function(key, val) {
                            $('#error-' + key).text(val[0]);
                        });
                    }
                }
            });
        });
    });
</script>
