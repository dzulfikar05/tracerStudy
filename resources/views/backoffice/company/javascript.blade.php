<script>
    var table = 'table_company';
    var form = 'form_company';
    var fields = [
        'id',
        'name',
        'company_type',
        'scope',
        'address',
        'phone',
    ];


    $(() => {

        $('#company_type').select2({
            dropdownParent: $('.viewForm')
        });
        $('#scope').select2({
            dropdownParent: $('.viewForm')
        });


        loadBlock();
        initTable();
    })

    showForm = () => {
        $('#id').val('');

        onReset();
        // $('#modal_company').modal('show')
        $('.viewForm').modal('show')
    }


    initTable = () => {
        var table = $('#table_company').DataTable({
            processing: true,
            serverSide: true,
            searchAble: true,
            scrollX: true,
            searching: true,
            paging: true,
            "bDestroy": true,
            ajax: "{{ route('backoffice.master.company.table') }}",
            columns: [{
                    "data": null,
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1
                    }
                },
                {
                    data: 'name',
                    name: 'name',
                    render: function(data, type, full, meta) {
                        return `<span>${full.name??''}</span>`;
                    }
                },
                {
                    data: 'company_type',
                    name: 'company_type',
                    render: function(data, type, full, meta) {
                        let html = '';
                        if (full.company_type === 'higher_education') {
                            html = 'Perguruan Tinggi';
                        } else if (full.company_type === 'government_agency') {
                            html = 'Instansi Pemerintah';
                        } else if (full.company_type === 'state-owned_enterprise') {
                            html = 'BUMN';
                        } else if (full.company_type === 'private_company') {
                            html = 'Swasta';
                        }

                        return `<span>${html??''}</span>`;
                    }
                },
                {
                    data: 'scope',
                    name: 'scope',
                    render: function(data, type, full, meta) {
                        html = ``;
                        if (full.scope == 'businessman') {
                            html = `Wirausaha`;
                        } else if (full.scope == 'national') {
                            html = `Nasional`;
                        } else if (full.scope == 'international') {
                            html = `Internasional`;
                        }
                        return `<span>${html??''}</span>`;
                    }
                },
                {
                    data: 'address',
                    name: 'address',
                    render: function(data, type, full, meta) {
                        return `<span>${full.address??''}</span>`;
                    }
                },
                {
                    data: 'phone',
                    name: 'phone',
                    render: function(data, type, full, meta) {
                        return `<span>${full.phone??''}</span>`;
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

                let tbody = $('#table_company tbody');
                if (rowCount < 2) {
                    tbody.find('tr').css('height', '100px');
                } else {
                    tbody.find('tr').css('height', '');
                }
            }
        });
        unblock()
    }

    onSave = () => {
        var formData = new FormData($(`[name="${form}"]`)[0]);

        let id_company = $('#id').val();
        let name = $('#name').val().trim();
        let phone = $('#phone').val().trim();

        // Validasi phone tidak boleh mengandung huruf
        const phoneRegex = /^[0-9+\-()\s]+$/;

        if (!phoneRegex.test(phone)) {
            saMessage({
                success: false,
                title: 'Validasi Gagal',
                message: 'Nomor telepon hanya boleh berisi angka dan simbol (+ - ( )). Tidak boleh ada huruf.',
            });
            return;
        }

        let urlSave = "";
        if (id_company == '' || id_company == null) {
            urlSave = `{{ route('backoffice.master.company.store') }}`;
        } else {
            urlSave = `{{ route('backoffice.master.company.update', ['id' => '__ID__']) }}`.replace('__ID__',
                id_company);
        }

        saConfirm({
            message: 'Apakah anda yakin ingin menyimpan data?',
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
    }


    onEdit = (el) => {
        var id = $(el).data('id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `{{ route('backoffice.master.company.edit', ['id' => '__ID__']) }}`.replace('__ID__', id),
            data: {
                id: id
            },
            method: 'post',
            success: function(data) {
                showForm()
                $.each(fields, function(i, v) {
                    $('#' + v).val(data[v]).change()
                })
            }
        })
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
                        url: `{{ route('backoffice.master.company.destroy', ['id' => '__ID__']) }}`
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
                            })
                            initTable();

                        }
                    })
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
