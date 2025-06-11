<script>
    var table = 'table_profession';
    var form = 'form_profession';
    var fields = [
        'id',
        'name',
        'profession_category_id',
    ];

    var listCategory = [];

    $(() => {

        $('#profession_category_id').select2({
            dropdownParent: $('.viewForm')
        });


        loadBlock();
        initTable();
        getCategory();
    })

    showForm = () => {
        onReset();
        // $('#modal_profession').modal('show')
        $('.viewForm').modal('show')
    }

    getCategory = () => {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('backoffice.master.profession-category.fetch-all') }}",
            method: 'GET',
            success: function(res) {
                listCategory = ``;
                listCategory += `<option value="">- Pilih Kategori Profesi -</option>`;
                $.each(res, function(i, v) {
                    listCategory += `<option value="${v.id}">${v.name}</option>`;
                })
                $('#profession_category_id').html(listCategory);
            }
        })
    }

    initTable = () => {
        var table = $('#table_profession').DataTable({
            processing: true,
            scrollX: true,
            serverSide: true,
            searchAble: true,
            searching: true,
            paging: true,
            "bDestroy": true,
            ajax: "{{ route('backoffice.master.profession.table') }}",
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
                    data: 'profession_category_name',
                    name: 'profession_category_name',
                    render: function(data, type, full, meta) {
                        return `<span>${full.profession_category_name??''}</span>`;
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

                let tbody = $('#table_profession tbody');
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

        let id_profession = $('#id').val();
        let name = $('#name').val().trim();

        const nameRegex = /^[a-zA-Z\s]+$/;

        // Validasi nama tidak mengandung angka atau simbol
        if (!nameRegex.test(name)) {
            saMessage({
                success: false,
                title: 'Validasi Gagal',
                message: 'Nama hanya boleh berisi huruf dan spasi.',
            });
            return;
        }

        let urlSave = "";
        if (id_profession == '' || id_profession == null) {
            urlSave = `{{ route('backoffice.master.profession.store') }}`;
        } else {
            urlSave = `{{ route('backoffice.master.profession.update', ['id' => '__ID__']) }}`.replace('__ID__',
                id_profession);
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
            url: `{{ route('backoffice.master.profession.edit', ['id' => '__ID__']) }}`.replace('__ID__',
                id),
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
                        url: `{{ route('backoffice.master.profession.destroy', ['id' => '__ID__']) }}`
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
            if(v == 'id') return;
            $('#' + v).val('').change();
        });
    };

    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }
</script>
