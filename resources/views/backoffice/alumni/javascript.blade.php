<script>
    var table = 'table_alumni';
    var form = 'form_alumni';
    var fields = [
        'id',
        'full_name',
        'nim',
        'study_program',
        'graduation_date',
        'phone',
        'email',
        'start_work_date',
        'start_work_now_date',
        'company_id',
        'profession_id',
        'superior_id'
    ];

    var company_data = [];
    var profession_data = [];
    var profession_category_data = [];
    var superior_data = [];
    var prodi_data = [];

    $(() => {

        $('#company_id').select2({
            dropdownParent: $('.viewForm')
        });
        $('#profession_id').select2({
            dropdownParent: $('.viewForm')
        });
        $('#superior_id').select2({
            dropdownParent: $('.viewForm')
        });
        $('#profession_category_id').select2({
            dropdownParent: $('.viewForm')
        });
        $('#study_program').select2({
            dropdownParent: $('.viewForm')
        });


        loadBlock();
        initTable();
        onFetchOptionForm();
    })

    showForm = () => {
        onReset();
        // $('#modal_alumni').modal('show')
        $('.viewForm').modal('show')
    }


    initTable = () => {
        var table = $('#table_alumni').DataTable({
            processing: true,
            serverSide: true,
            searchAble: true,
            searching: true,
            paging: true,
            "bDestroy": true,
            ajax: "{{ route('backoffice.alumni.table') }}",
            columns: [{
                    data: null,
                    sortable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'full_name',
                    name: 'full_name',
                    render: function(data, type, full, meta) {
                        return `<span>${full.full_name ?? ''}</span>`;
                    }
                },
                {
                    data: 'nim',
                    name: 'nim',
                    render: function(data, type, full, meta) {
                        return `<span>${full.nim ?? ''}</span>`;
                    }
                },
                {
                    data: 'study_program',
                    name: 'study_program',
                    render: function(data, type, full, meta) {
                        return `<span>${full.study_program ?? ''}</span>`;
                    }
                },
                {
                    data: 'graduation_date',
                    name: 'graduation_date',
                    render: function(data, type, full, meta) {
                        return `<span>${full.graduation_date ?? ''}</span>`;
                    }
                },
                {
                    data: 'phone',
                    name: 'phone',
                    render: function(data, type, full, meta) {
                        return `<span>${full.phone ?? ''}</span>`;
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
                    data: 'start_work_date',
                    name: 'start_work_date',
                    render: function(data, type, full, meta) {
                        return `<span>${full.start_work_date ?? ''}</span>`;
                    }
                },
                {
                    data: 'start_work_now_date',
                    name: 'start_work_now_date',
                    render: function(data, type, full, meta) {
                        return `<span>${full.start_work_now_date ?? ''}</span>`;
                    }
                },
                {
                    data: 'company_name',
                    name: 'company_name',
                    render: function(data, type, full, meta) {
                        return `<span>${full.company_name ?? ''}</span>`;
                    }
                },
                {
                    data: 'profession_category_name',
                    name: 'profession_category_name',
                    render: function(data, type, full, meta) {
                        return `<span>${full.profession_category_name ?? ''}</span>`;
                    }
                },
                {
                    data: 'profession_name',
                    name: 'profession_name',
                    render: function(data, type, full, meta) {
                        return `<span>${full.profession_name ?? ''}</span>`;
                    }
                },
                {
                    data: 'superior_name',
                    name: 'superior_name',
                    render: function(data, type, full, meta) {
                        return `<span>${full.superior_name ?? ''}</span>`;
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        unblock()
    }

    onSave = () => {
        var formData = new FormData($(`[name="${form}"]`)[0]);
        let id_alumni = $('#id').val();
        let urlSave = "";

        if (id_alumni == '' || id_alumni == null) {
            urlSave = `{{ route('backoffice.alumni.store') }}`;
        } else {
            urlSave = `{{ route('backoffice.alumni.update', ['id' => '__ID__']) }}`.replace('__ID__',
                id_alumni);
        }


        saConfirm({
            message: 'Are you sure you want to save the data?',
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
        })
    }

    onFetchOptionForm = () => {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `{{ route('backoffice.alumni.fetch-option') }}`,
            method: 'get',
            success: function(data) {
                company_data = data.company;
                profession_data = data.profession;
                profession_category_data = data.profession_category;
                superior_data = data.superior;
                prodi_data = data.prodi;

                setOptionProfessionCategory();
                setOptionCompany();
                setOptionProdi();
            }
        })
    }

    setOptionProdi = () => {
        $('#study_program').empty();
        var html = `<option value="">-- Pilih Prodi --</option>`;
        $.each(prodi_data, function(i, v) {
            html += `<option value="${v}">${v}</option>`;
        });
        $('#study_program').append(html);
    }

    setOptionProfessionCategory = () => {
        $('#profession_category_id').empty();
        var html = `<option value="">-- Pilih Kategori Pekerjaan --</option>`;
        $.each(profession_category_data, function(i, v) {
            html += `<option value="${v.id}">${v.name}</option>`;
        });
        $('#profession_category_id').append(html);
    }

    $('#profession_category_id').on('change', function() {
        var id = $(this).val();
        $('#profession_id').empty();
        var html = `<option value="">-- Pilih Pekerjaan --</option>`;
        $.each(profession_data, function(i, v) {
            if (v.profession_category_id == id) {
                html += `<option value="${v.id}">${v.name}</option>`;
            }
        });
        $('#profession_id').append(html);
    });

    setOptionCompany = () => {
        $('#company_id').empty();
        var html = `<option value="">-- Pilih Perusahaan --</option>`;
        $.each(company_data, function(i, v) {
            html += `<option value="${v.id}">${v.name}</option>`;
        });
        $('#company_id').append(html);
    }

    $('#company_id').on('change', function() {
        var id = $(this).val();
        $('#superior_id').empty();
        var html = `<option value="">-- Pilih Atasan --</option>`;
        $.each(superior_data, function(i, v) {
            if (v.company_id == id) {
                html += `<option value="${v.id}">${v.full_name}</option>`;
            }
        });
        $('#superior_id').append(html);
    });

    onEdit = (el) => {
        var id = $(el).data('id');

        Promise.all([
            setOptionProfessionCategory(),
            setOptionCompany(),
            setOptionProdi()
        ]).then(() => {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `{{ route('backoffice.alumni.edit', ['id' => '__ID__']) }}`.replace('__ID__',
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
                    $('#profession_category_id').val(data.profession.profession_category_id).change();
                    setTimeout(() => {
                        $('#profession_id').val(data.profession_id).change();
                    }, 500);

                    setTimeout(() => {
                        $('#superior_id').val(data.superior_id).change();
                    }, 500);


                }
            })
        });
    }

    onDelete = (el) => {
        var id = $(el).data('id');
        saConfirm({
            message: 'Are you sure you want to delete the data?',
            callback: function(res) {
                if (res) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: `{{ route('backoffice.alumni.destroy', ['id' => '__ID__']) }}`
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
            $('#' + v).val('').change()
        })
    }
    function modalAction(url) {
    $('#myModal').load(url, function () {
        $('#myModal').modal('show');
    });
}
</script>
