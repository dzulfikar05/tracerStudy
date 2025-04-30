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
        onReset();
        $('.viewForm').modal('show');
    };

    initTable = () => {
        var table = $('#table_profession_category').DataTable({
            processing: true,
            serverSide: true,
            searchAble: true,
            searching: true,
            paging: true,
            "bDestroy": true,
            ajax: "{{ route('backoffice.master.profession-category.table') }}",
            columns: [
                {
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
            ]
        });
        unblock();
    };

    onSave = () => {
        var formData = new FormData($(`[name="${form}"]`)[0]);
        var id = $('#id').val();
        var urlSave = "";

        if (id === '' || id === null) {
            urlSave = "{{ route('backoffice.master.profession-category.store') }}";
        } else {
            urlSave = `{{ route('backoffice.master.profession-category.update', ['id' => '__ID__']) }}`.replace('__ID__', id);
        }

        saConfirm({
            message: 'Are you sure you want to modify the data?',
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
                        }
                    });
                }
            }
        });
    };

    onEdit = (el) => {
        var id = $(el).data('id');
        var urlEdit = `{{ route('backoffice.master.profession-category.edit', ['id' => '__ID__']) }}`.replace('__ID__', id);

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
        var urlDelete = `{{ route('backoffice.master.profession-category.destroy', ['id' => '__ID__']) }}`.replace('__ID__', id);

        saConfirm({
            message: 'Are you sure you want to delete the data?',
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
