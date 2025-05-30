<script>
    var table = 'table_questionnaire';
    var form = 'form_questionnaire';
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

        loadBlock();
        initTable();
    });

    showForm = () => {
        onReset();
        $('.viewForm').modal('show');
    }

    initTable = () => {
        var table = $('#table_questionnaire').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            scrollX: true,
            paging: true,
            bDestroy: true,
            ajax: "{{ route('backoffice.questionnaire.table') }}",
            columns: [{
                    data: null,
                    sortable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'title',
                    name: 'title',
                    render: function(data, type, full, meta) {
                        return `<span>${full.title ?? ''}</span>`;
                    }
                },
                {
                    data: 'description',
                    name: 'description',
                    render: function(data, type, full, meta) {
                        return `<span>${full.description ?? ''}</span>`;
                    }
                },
                {
                    data: 'period_year',
                    name: 'period_year',
                    render: function(data, type, full, meta) {
                        return `<span>${full.period_year ?? ''}</span>`;
                    }
                },
                {
                    data: 'type',
                    name: 'type',
                    render: function(data, type, full, meta) {
                        let html = ``;
                        if (full.type == 'alumni') {
                            html += `<span>Alumni</span>`;
                        } else {
                            html += `<span>Atasan Alumni</span>`;
                        }
                        return html;
                    }
                },
                {
                    data: 'is_active',
                    name: 'is_active',
                    render: function(data, type, full, meta) {
                        let checked = full.is_active == 1 ? 'checked' : '';
                        return `
                            <div class="form-check form-switch">
                                <input
                                    class="form-check-input toggle-status"
                                    type="checkbox"
                                    data-id="${full.id}"
                                    ${checked}>
                            </div>
                        `;
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
        unblock();
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
            message: 'Are you sure you want to delete the data?',
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
            $('#' + v).val('').change();
        });
    }
</script>
