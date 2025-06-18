<script>
    var table = 'table_profession_category';
    var form = 'form_profession_category';
    var fields = [
        'id',
        'name',
    ];

    $(() => {
        $('#role').select2({
            dropdownParent: $('.viewForm')
        });

        loadBlock();
        initTable();
    });

    showForm = () => {
        $('#id').val('');
        onReset();
        $('.viewForm').modal('show');
    };

    initTable = () => {
        var table = $('#table_profession_category').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            searchAble: true,
            searching: true,
            paging: true,
            "bDestroy": true,
            ajax: "{{ route('backoffice.master.profession-category.table') }}",
            columns: [{
                    "data": null,
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'name',
                    name: 'name',
                    render: function(data, type, full, meta) {
                        return `<span>${full.name ?? ''}</span>`;
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            drawCallback: function(settings) {
                let rowCount = this.api().rows({
                    page: 'current'
                }).count();

                let tbody = $('#table_profession_category tbody');
                if (rowCount < 2) {
                    tbody.find('tr').css('height', '100px');
                } else {
                    tbody.find('tr').css('height', '');
                }
            }
        });
        unblock();
    };
    onSave = () => {
        var formData = new FormData($(`[name="${form}"]`)[0]);
        var id = $('#id').val();
        var urlSave = "";

        // Ambil nilai name
        let name = $('#name').val().trim();

        // Regex hanya huruf dan spasi
        const nameRegex = /^[a-zA-Z\s]+$/;

        // Validasi nama
        if (!nameRegex.test(name)) {
            saMessage({
                success: false,
                title: 'Validasi Gagal',
                message: 'Nama hanya boleh berisi huruf dan spasi.',
            });
            return;
        }

        if (id === '' || id === null) {
            urlSave = "{{ route('backoffice.master.profession-category.store') }}";
        } else {
            urlSave = `{{ route('backoffice.master.profession-category.update', ['id' => '__ID__']) }}`.replace(
                '__ID__', id);
        }

        saConfirm({
            message: 'Apakah anda yakin menyimpan data?',
            callback: function(res) {
                if (res) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: urlSave,
                        method: 'post',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            $('.viewForm').modal('hide');
                            onReset();
                            saMessage({
                                success: res['success'],
                                title: res['title'],
                                message: res['message'],
                                callback: function() {
                                    initTable();
                                }
                            });
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                let messages = Object.values(errors).flat().join('<br>');

                                Swal.fire({
                                    toast: true,
                                    position: 'bottom-end',
                                    icon: 'error',
                                    title: 'Validasi Gagal',
                                    html: messages,
                                    showConfirmButton: false,
                                    timer: 6000,
                                    timerProgressBar: true
                                });
                            }
                        }
                    });
                }
            }
        });
    };


    onEdit = (el) => {
        var id = $(el).data('id');
        var urlEdit = `{{ route('backoffice.master.profession-category.edit', ['id' => '__ID__']) }}`.replace(
            '__ID__', id);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: urlEdit,
            method: 'post',
            data: {
                id: id
            },
            success: function(data) {
                showForm();
                $.each(fields, function(i, v) {
                    $('#' + v).val(data[v]).change();
                });
            }
        });
    };

    onDelete = (el) => {
        var id = $(el).data('id');
        var urlDelete = `{{ route('backoffice.master.profession-category.destroy', ['id' => '__ID__']) }}`.replace(
            '__ID__', id);

        saConfirm({
            message: 'Apakah anda yakin ingin menghapus data?',
            callback: function(res) {
                if (res) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: urlDelete,
                        method: 'post',
                        data: {
                            id: id
                        },
                        success: function(res) {
                            saMessage({
                                success: res['success'],
                                title: res['title'],
                                message: res['message']
                            });
                            initTable();
                        }
                    });
                }
            }
        });
    };

    onReset = () => {
        $.each(fields, function(i, v) {

            $('#' + v).val('').change();
        });
    };
</script>
