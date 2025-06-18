<script>
    var table = 'table_user';
    var form = 'form_user';
    var fields = [
        'id',
        'name',
        'email',
        'password',
    ];

    $(() => {
        loadBlock();
        initTable();
    });

    showForm = () => {
        $('#id').val('');

        onReset();
        $('#password').attr('placeholder', "Password");

        $('.viewForm').modal('show');
    }

    initTable = () => {
        var table = $('#table_user').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            scrollX: true,
            paging: true,
            bDestroy: true,
            ajax: "{{ route('backoffice.master.user.table') }}",
            columns: [{
                    data: null,
                    sortable: false,
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
                    data: 'email',
                    name: 'email',
                    render: function(data, type, full, meta) {
                        return `<span>${full.email ?? ''}</span>`;
                    }
                },
                {
                    data: 'is_super',
                    name: 'is_super',
                    render: function(data, type, full, meta) {
                        return `<span>${full.is_super == true ? 'Superadmin' : 'Admin'}</span>`;
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

                let tbody = $('#table_user tbody');
                if (rowCount < 2) {
                    tbody.find('tr').css('height', '100px');
                } else {
                    tbody.find('tr').css('height', '');
                }
            }
        });
        unblock();
    }


    onSave = () => {
        var formData = new FormData($(`[name="${form}"]`)[0]);
        let id_user = $('#id').val();
        let name = $('#name').val().trim();
        let urlSave = "";

        // Regex validasi: hanya huruf dan spasi
        const nameRegex = /^[a-zA-Z\s]+$/;

        // Validasi Nama
        if (!nameRegex.test(name)) {
            saMessage({
                success: false,
                title: 'Validasi Gagal',
                message: 'Nama hanya boleh berisi huruf dan spasi.',
            });
            return;
        }

        if (id_user == '' || id_user == null) {
            urlSave = `{{ route('backoffice.master.user.store') }}`;
        } else {
            urlSave = `{{ route('backoffice.master.user.update', ['id' => '__ID__']) }}`.replace('__ID__', id_user);
        }

        saConfirm({
            message: 'apakah anda yakin ingin menyimpan data?',
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
                            })
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
                    })
                }
            }
        });
    }

    onEdit = (el) => {
        var id = $(el).data('id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `{{ route('backoffice.master.user.edit', ['id' => '__ID__']) }}`.replace('__ID__', id),
            data: {
                id: id
            },
            method: 'post',
            success: function(data) {
                showForm();
                $.each(fields, function(i, v) {
                    if (v == 'password') {
                        $('#' + v).val('').change();
                        $('#' + v).attr('placeholder',
                            "Kosongkan password jika tidak ingin diubah");
                    }
                    $('#' + v).val(data[v]).change();
                });
            }
        });
    }

    onDelete = (el) => {
        var id = $(el).data('id');
        saConfirm({
            message: 'Apakah anda yakin ingin menghapus data?',
            callback: function(res) {
                if (res) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: `{{ route('backoffice.master.user.destroy', ['id' => '__ID__']) }}`
                            .replace('__ID__', id),
                        data: {
                            id: id
                        },
                        method: 'post',
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
    }

    onReset = () => {
        $.each(fields, function(i, v) {

            $('#' + v).val('').change();
        });
    };
</script>
