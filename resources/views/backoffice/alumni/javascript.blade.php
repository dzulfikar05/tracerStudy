<script>
    var table = 'table_alumni';
    var form = 'form_alumni';
    var fields = [
        'id',
        'full_name',
        'nim',
        'study_program',
        'study_start_year',
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
        $('#filter_company_id').select2({
            dropdownParent: $('.filterModal')
        });
        $('#filter_study_program').select2({
            dropdownParent: $('.filterModal')
        });
        $('#filter_filled').select2({
            dropdownParent: $('.filterModal')
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
            scrollX: true,
            paging: true,
            "bDestroy": true,
            ajax: {
                url: "{{ route('backoffice.alumni.table') }}",
                data: function(d) {
                    d.nim = $('#filter_nim').val();
                    d.study_program = $('#filter_study_program').val();
                    d.study_start_year = $('#filter_study_start_year').val();
                    d.company_id = $('#filter_company_id').val();
                    d.is_filled = $('#filter_filled').val();
                }
            },
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
                    data: 'study_start_year',
                    name: 'study_start_year',
                    render: function(data, type, full, meta) {
                        return `<span>${full.study_start_year ?? ''}</span>`;
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
                    data: 'waiting_time',
                    name: 'waiting_time',
                    render: function(data, type, full, meta) {
                        return `<span>${full.waiting_time ?? '-'} Bulan</span>`;
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
                        return `<span>${full.superior.full_name ?? ''}</span>`;
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

                let tbody = $('#table_alumni tbody');
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

        // Ambil nilai input
        let fullName = $('#full_name').val().trim();
        let nim = $('#nim').val().trim();
        let phone = $('#phone').val().trim();
        let id_alumni = $('#id').val();
        let urlSave = "";

        // Regex validasi
        const nameRegex = /^[a-zA-Z\s]+$/; // Hanya huruf dan spasi
        const numberOnlyRegex = /^[0-9]+$/; // Hanya angka

        // Validasi Nama Lengkap
        if (!nameRegex.test(fullName)) {
            saMessage({
                success: false,
                title: 'Validasi Gagal',
                message: 'Nama Lengkap hanya boleh berisi huruf dan spasi.',
            });
            return;
        }

        // Validasi NIM
        if (!numberOnlyRegex.test(nim)) {
            saMessage({
                success: false,
                title: 'Validasi Gagal',
                message: 'NIM hanya boleh berisi angka.',
            });
            return;
        }

        // Validasi Nomor Telepon (jika diisi)
        if (phone !== '' && !numberOnlyRegex.test(phone)) {
            saMessage({
                success: false,
                title: 'Validasi Gagal',
                message: 'Nomor Telepon hanya boleh berisi angka.',
            });
            return;
        }

        // Tentukan URL
        if (id_alumni == '' || id_alumni == null) {
            urlSave = `{{ route('backoffice.alumni.store') }}`;
        } else {
            urlSave = `{{ route('backoffice.alumni.update', ['id' => '__ID__']) }}`.replace('__ID__', id_alumni);
        }

        // Konfirmasi dan AJAX
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
        $('#filter_study_program').empty();
        $('#study_program').empty();
        var html = `<option value="">-- Pilih Prodi --</option>`;
        $.each(prodi_data, function(i, v) {
            html += `<option value="${v}">${v}</option>`;
        });
        $('#filter_study_program').append(html);
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
        $('#filter_company_id').empty();
        var html = `<option value="">-- Pilih Perusahaan --</option>`;
        $.each(company_data, function(i, v) {
            html += `<option value="${v.id}">${v.name}</option>`;
        });
        $('#company_id').append(html);
        $('#filter_company_id').append(html);
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
                    $('#profession_category_id').val(data.profession.profession_category_id)
                        .change();
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
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    function applyFilter() {
        $('#filterModal').modal('hide');
        initTable();
        checkFilterStatus();
    }

    function resetFilter() {
        $('#filter_nim').val('');
        $('#filter_study_program').val('').change();
        $('#filter_study_start_year').val('');
        $('#filter_company_id').val('').change();
        $('#filter_filled').val('').change();
        initTable();
        checkFilterStatus();
    }
    $('#btnExportExcel').on('click', function(e) {
        e.preventDefault();

        let params = {
            nim: $('#filter_nim').val(),
            study_program: $('#filter_study_program').val(),
            study_start_year: $('#filter_study_start_year').val(),
            company_id: $('#filter_company_id').val(),
            is_filled: $('#filter_filled').val()
        };

        // Buat query string dari filter
        let query = $.param(params);

        // Redirect ke URL export dengan filter
        window.location.href = "{{ route('backoffice.alumni.export') }}?" + query;
    });

    $('#btnDownloadTemplate').on('click', function(e) {
        e.preventDefault();

        let params = {
            nim: $('#filter_nim').val(),
            study_program: $('#filter_study_program').val(),
            study_start_year: $('#filter_study_start_year').val(),
            company_id: $('#filter_company_id').val()
        };

        // Buat query string dari filter
        let query = $.param(params);

        // Redirect ke URL export dengan filter
        window.location.href = "{{ route('backoffice.alumni.export') }}?" + query;
    });


    checkFilterStatus = () => {
        const nim = $('#filter_nim').val().trim();
        const prodi = $('#filter_study_program').val();
        const year = $('#filter_study_start_year').val().trim();
        const company = $('#filter_company_id').val();
        const filled = $('#filter_filled').val();

        const isFiltered = nim || prodi || year || company || filled;

        if (isFiltered) {
            $('#filter-indicator').removeClass('d-none');
        } else {
            $('#filter-indicator').addClass('d-none');
        }
    }
</script>
