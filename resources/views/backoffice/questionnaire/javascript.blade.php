<script>
    var table = 'table_questionnaire';
    var form = 'form_questionnaire';
    const is_super = "{{ $is_super }}";
    var fields = [
        'id',
        'title',
        'description',
        'period_year',
        'type',
        'is_active',
    ];

    $(() => {
        $('#type').select2({
            dropdownParent: $('.viewForm')
        });

        $('#filter_type').select2({
            dropdownParent: $('.filterModal')
        });


        loadBlock();
        initTable();
    });

    showForm = () => {
        onReset();
        $('.viewForm').modal('show');
    }

    // initTable = () => {
    //     var table = $('#table_questionnaire').DataTable({
    //         processing: true,
    //         serverSide: true,
    //         searching: true,
    //         paging: true,
    //         scrollX: true,
    //         bDestroy: true,
    //         // ajax: "{{ route('backoffice.questionnaire.table') }}",
    //         ajax: {
    //             url: "{{ route('backoffice.questionnaire.table') }}",
    //             data: function(d) {
    //                 d.title = $('#filter_title').val();
    //                 d.period_year = $('#filter_period_year').val();
    //                 d.type = $('#filter_type').val();
    //             }
    //         },
    //         columns: [{
    //                 data: null,
    //                 sortable: false,
    //                 render: function(data, type, row, meta) {
    //                     return meta.row + meta.settings._iDisplayStart + 1;
    //                 }
    //             },
    //             {
    //                 data: 'title',
    //                 name: 'title',
    //                 render: function(data, type, full, meta) {
    //                     return `<span>${full.title ?? ''}</span>`;
    //                 }
    //             },
    //             {
    //                 data: 'description',
    //                 name: 'description',
    //                 render: function(data, type, full, meta) {
    //                     return `<span>${full.description ?? ''}</span>`;
    //                 }
    //             },
    //             {
    //                 data: 'period_year',
    //                 name: 'period_year',
    //                 render: function(data, type, full, meta) {
    //                     return `<span>${full.period_year ?? ''}</span>`;
    //                 }
    //             },
    //             {
    //                 data: 'type',
    //                 name: 'type',
    //                 render: function(data, type, full, meta) {
    //                     let html = ``;
    //                     if (full.type == 'alumni') {
    //                         html += `<span>Alumni</span>`;
    //                     } else {
    //                         html += `<span>Atasan Alumni</span>`;
    //                     }
    //                     return html;
    //                 }
    //             },
    //             {
    //                 data: 'is_active',
    //                 name: 'is_active',
    //                 render: function(data, type, full, meta) {
    //                     let checked = full.is_active == 1 ? 'checked' : '';
    //                     return `
    //                         <div class="form-check form-switch">
    //                             <input
    //                                 class="form-check-input toggle-status"
    //                                 type="checkbox"
    //                                 data-id="${full.id}"
    //                                 ${checked}>
    //                         </div>
    //                     `;
    //                 }
    //             },
    //             {
    //                 data: 'is_dashboard',
    //                 name: 'is_dashboard',
    //                 render: function(data, type, full, meta) {
    //                     let checked = full.is_dashboard == 1 ? 'checked' : '';
    //                     return `
    //                         <div class="form-check form-switch">
    //                             <input
    //                                 class="form-check-input toggle-dashboard"
    //                                 type="checkbox"
    //                                 data-id="${full.id}"
    //                                 ${checked}>
    //                         </div>
    //                     `;
    //                 }
    //             },

    //             {
    //                 data: 'action',
    //                 name: 'action',
    //                 orderable: false,
    //                 searchable: false
    //             },
    //         ]
    //     });
    //     unblock();
    // }

    initTable = () => {
        unblock();

        $.ajax({
            url: "{{ route('backoffice.questionnaire.table') }}",
            method: "GET",
            data: {
                title: $('#filter_title').val(),
                period_year: $('#filter_period_year').val(),
                type: $('#filter_type').val()
            },
            success: function(res) {
                const container = $('#questionnaire-cards');
                container.empty();

                res.data.forEach((item, index) => {
                    let statusChecked = item.is_active == 1 ? 'checked' : '';
                    let dashboardChecked = item.is_dashboard == 1 ? 'checked' : '';
                    let type = item.type == 'alumni' ? 'Alumni' : 'Atasan Alumni';

                    let card = `
                    <div class="col-md-6 col-xl-4 mb-4">
                        <div class="card questionnaire-card border-0 rounded-3 h-100">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="card-title text-primary fw-semibold">${item.title}</h5>
                                    <p class="card-text text-muted small mb-3">${item.description ?? '-'}</p>
                                    <div class="mb-3 d-flex flex-wrap gap-2">
                                        <span class="badge bg-primary">Tahun: ${item.period_year}</span>
                                        <span class="badge bg-warning text-dark">Berlaku: ${type}</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input toggle-status" type="checkbox" data-id="${item.id}" ${statusChecked}>
                                            <label class="form-check-label small">Tampil</label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input toggle-dashboard" type="checkbox" data-id="${item.id}" ${dashboardChecked}>
                                            <label class="form-check-label small">Set Dashboard <span class="text-muted" style="font-size: 0.9em">(salah satu dari semua kuisioner)</span></label>
                                        </div>
                                    </div>
                                    <div class="dropstart">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <ul class="dropdown-menu">`;
                                            if(is_super == true){
                                                card += `
                                                <li><a class="dropdown-item" href="#" onclick="onEdit(this)" data-id="${item.id}">
                                                    <i class="fa fa-pencil text-warning me-2"></i>Edit</a></li>`;
                                            }   card += `

                                            <li><a class="dropdown-item" href="${item.show_url}">
                                                <i class="fa fa-question-circle text-primary me-2"></i>Lihat Pertanyaan</a></li>
                                            <li><a class="dropdown-item" href="${item.answer_url}">
                                                <i class="fa fa-eye text-primary me-2"></i>Lihat Jawaban</a></li>
                                            ${item.has_assessment ? `
                                                <li><a class="dropdown-item" href="${item.assessment_url}">
                                                    <i class="fa fa-table text-info me-2"></i>Tabel Penilaian</a></li>
                                            ` : ''} `;
                                            if(is_super == true){
                                                card += `
                                            <li><a class="dropdown-item text-danger" href="#" onclick="onDelete(this)" data-id="${item.id}">
                                                <i class="fa fa-trash me-2"></i>Hapus</a></li>`;
                                            }   card += `

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                `;
                    container.append(card);
                });

                feather.replace(); // penting untuk menampilkan ulang ikon feather jika digunakan
            }
        });
    }



    function applyFilter() {
        $('#filterModal').modal('hide');
        initTable();
        checkFilterStatus();
    }

    function resetFilter() {
        $('#filter_title').val(null).trigger('change');
        $('#filter_type').val(null).trigger('change');
        $('#filter_period_year').val(null).trigger('change');
        initTable();
        checkFilterStatus();
    }

    checkFilterStatus = () => {
        const title = $('#filter_title').val();
        const type = $('#filter_type').val();
        const period_year = $('#filter_period_year').val();

        const isFiltered = title || type || period_year;

        if (isFiltered) {
            $('#filter-indicator').removeClass('d-none');
        } else {
            $('#filter-indicator').addClass('d-none');
        }
    }

    $(document).on('change', '.toggle-status', function() {
        let id = $(this).data('id');
        let status = $(this).is(':checked') ? 1 : 0;

        $.ajax({
            url: "{{ route('backoffice.questionnaire.toggle-status', ['id' => '__ID__']) }}".replace(
                '__ID__', id),
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                is_active: status
            },
            success: function(res) {
                saMessage({
                    success: res['success'],
                    title: res['title'],
                    message: res['message'],
                    callback: function() {
                        initTable();
                    }
                })
            }
        });

    });

    $(document).on('change', '.toggle-dashboard', function() {
        let id = $(this).data('id');
        let dashboard = $(this).is(':checked') ? 1 : 0;

        $.ajax({
            url: "{{ route('backoffice.questionnaire.toggle-dashboard', ['id' => '__ID__']) }}".replace(
                '__ID__', id),
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                is_dashboard: dashboard
            },
            success: function(res) {
                saMessage({
                    success: res['success'],
                    title: res['title'],
                    message: res['message'],
                    callback: function() {
                        initTable();
                    }
                })
            }
        });

    });


    onSave = () => {
        var formData = new FormData($(`[name="${form}"]`)[0]);
        let id_questionnaire = $('#id').val();
        let urlSave = "";

        if (id_questionnaire == '' || id_questionnaire == null) {
            urlSave = `{{ route('backoffice.questionnaire.store') }}`;
        } else {
            urlSave = `{{ route('backoffice.questionnaire.update', ['id' => '__ID__']) }}`.replace('__ID__',
                id_questionnaire);
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
            url: `{{ route('backoffice.questionnaire.edit', ['id' => '__ID__']) }}`.replace('__ID__',
                id),
            data: {
                id: id
            },
            method: 'post',
            success: function(data) {
                showForm();
                $.each(fields, function(i, v) {
                    if (v == 'is_active') {
                        $('#' + v).prop('checked', data[v] == 1 ? true : false);
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
                        url: `{{ route('backoffice.questionnaire.destroy', ['id' => '__ID__']) }}`
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
            if(v == 'id') return;
            $('#' + v).val('').change();
        });
    };
</script>
