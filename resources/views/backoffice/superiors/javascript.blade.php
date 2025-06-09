<script>
    var table = 'table_superiors';
    var form = 'form_superiors';
    var fields = [
        'id',
        'full_name',
        'position',
        'phone',
        'email',
        'company_id'
    ];

    var company_data = [];

    $(() => {
        $('#company_id').select2({
            dropdownParent: $('.viewForm')
        });
        $('#filter_position').select2({
            dropdownParent: $('.filterModal')
        });
        $('#filter_company_id').select2({
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
        $('.viewForm').modal('show');
    }

    getStatsCard = () => {
        $.ajax({
            url: "{{ route('backoffice.superior.card-stats') }}",
            type: "GET",
            data: {
                position: $('#filter_position').val(),
                company_id: $('#filter_company_id').val(),
                is_filled: $('#filter_filled').val(),
            },
            success: function(response) {
                $('#count_superior').html(response.count_superior);
                $('#count_superior_fill').html(response.count_superior_fill);
                $('#count_superior_unfill').html(response.count_superior_unfill);
            },
            error: function(xhr, status, error) {
                console.error('Gagal mengambil data statistik:', error);
            }
        });
    }

    initTable = () => {
        getStatsCard();

        var table = $('#table_superiors').DataTable({
            processing: true,
            serverSide: true,
            searchAble: true,
            searching: true,
            scrollX: true,
            paging: true,
            "bDestroy": true,
            //ajax: "{{ route('backoffice.superior.table') }}",
            ajax: {
                url: "{{ route('backoffice.superior.table') }}",
                data: function(d) {
                    d.position = $('#filter_position').val();
                    d.company = $('#filter_company_id').val();
                    d.is_filled = $('#filter_filled').val();

                    console.log('Filter values:', d.position, d.company);
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
                    data: 'position',
                    name: 'position',
                    render: function(data, type, full, meta) {
                        return `<span>${full.position ?? ''}</span>`;
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
                    data: 'company_name',
                    name: 'company_name',
                    render: function(data, type, full, meta) {
                        return `<span>${full.company_name ?? ''}</span>`;
                    }
                },
                {
                    data: null,
                    name: 'list_alumni',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return `<button class="btn btn-outline-info me-2" style="width: 100px;" onclick="showAlumni(${full.id})">${full.alumni_count || 0} Alumni</button>`;
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

                let tbody = $('#table_superiors tbody');
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

        let fullName = $('#full_name').val().trim();
        let phone = $('#phone').val().trim();

        const nameRegex = /^[a-zA-Z\s]+$/;
        const phoneRegex = /^[0-9]+$/;

        // Validasi Nama Lengkap
        if (!nameRegex.test(fullName)) {
            saMessage({
                success: false,
                title: 'Validasi Gagal',
                message: 'Nama Lengkap hanya boleh berisi huruf dan spasi.',
            });
            return;
        }

        // Validasi Nomor Telepon
        if (!phoneRegex.test(phone)) {
            saMessage({
                success: false,
                title: 'Validasi Gagal',
                message: 'Nomor Telepon hanya boleh berisi angka.',
            });
            return;
        }

        let id_superior = $('#id').val();
        let urlSave = "";

        if (!id_superior) {
            urlSave = `{{ route('backoffice.superior.store') }}`;
        } else {
            urlSave = `{{ route('backoffice.superior.update', ['id' => '__ID__']) }}`.replace('__ID__',
            id_superior);
        }

        saConfirm({
            message: 'Apakah Anda yakin ingin menyimpan data?',
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

                                saMessage({
                                    success: false,
                                    title: 'Validasi Gagal',
                                    message: messages,
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
            url: `{{ route('backoffice.superior.fetch-option') }}`,
            method: 'get',
            success: function(data) {
                company_data = data.companies;
                setOptionCompany();
                setOptionPosition(data.positions);
            }
        });
    }

    setOptionCompany = () => {
        $('#company_id').empty();
        var html = `<option value="">-- Pilih Perusahaan --</option>`;
        $.each(company_data, function(i, v) {
            html += `<option value="${v.id}">${v.name}</option>`;
        });
        $('#company_id').append(html);
        $('#filter_company_id').append(html);
    }

    setOptionPosition = (positions) => {
        $('#filter_position').empty();
        var html = `<option value="">-- Pilih Jabatan --</option>`;
        $.each(positions, function(i, v) {
            html += `<option value="${v}">${v}</option>`;
        });
        $('#filter_position').append(html);
    }


    onEdit = (el) => {
        var id = $(el).data('id');
        // Remove the .then() since setOptionCompany doesn't return a promise
        setOptionCompany(); // This line changed

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ route('backoffice.superior.edit', ['id' => '__ID__']) }}'.replace('__ID__', id),
            data: {
                id: id
            },
            method: 'post',
            success: function(data) {
                showForm();
                $.each(fields, function(i, v) {
                    $('#' + v).val(data[v]).change();
                });
                $('#company_id').val(data.company_id).change();
            }
        });
    }

    onDelete = (el) => {
        var id = $(el).data('id');
        saConfirm({
            message: 'Apakah Anda yakin ingin menghapus data?',
            callback: function(res) {
                if (res) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: `{{ route('backoffice.superior.destroy', ['id' => '__ID__']) }}`
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
        $('#filter_position').val(null).trigger('change');
        $('#filter_company_id').val(null).trigger('change');
        $('#filter_filled').val('').change();
        initTable();
        checkFilterStatus();
    }

    $('#btnExportExcel').on('click', function(e) {
        e.preventDefault();

        let params = {
            position: $('#filter_position').val(),
            //company_id: $('#filter_company_id').val()
            company: $('#filter_company_id').val(),
            is_filled: $('#filter_filled').val()

        };

        // Buat query string dari filter
        let query = $.param(params);

        // Redirect ke URL export dengan filter
        window.location.href = "{{ route('backoffice.superior.export-excel') }}?" + query;
    });

    function showAlumni(id) {
        $.ajax({
            url: `/backoffice/superior/${id}/alumni`, // MODIFIKASI
            type: 'GET',
            success: function(html) {
                $('#myModal').html(html); // MODIFIKASI
                $('#myModal').modal('show'); // MODIFIKASI
            },
            error: function() {
                alert('Gagal mengambil data alumni.'); // MODIFIKASI
            }
        });
    }

    checkFilterStatus = () => {
        const position = $('#filter_position').val();
        const company = $('#filter_company_id').val();
        const filled = $('#filter_filled').val();

        const isFiltered = position || company || filled;

        if (isFiltered) {
            $('#filter-indicator').removeClass('d-none');
        } else {
            $('#filter-indicator').addClass('d-none');
        }
    }
</script>
