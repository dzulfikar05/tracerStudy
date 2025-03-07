<script>
    var table = 'table_job_category';
    var form = 'form_job_category';
    var fields = [
        'id',
        'name',
    ];

    $(() => {
        $("#photo").change(function() {
            readURL(this);
        });

        $('#role').select2({
            dropdownParent: $('.viewForm')
        });

        loadBlock();
        initTable();
    })

    showForm = () => {
        onReset();
        $('.viewForm').modal('show')
    }

    initTable = () => {
        var table = $('#table_job_category').DataTable({
            processing: true,
            serverSide: true,
            searchAble: true,
            searching: true,
            paging: true,
            "bDestroy": true,
            ajax: "{{ route('backoffice.master.job-category.table') }}",
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

        var id_job_category = $('#id').val();
        var urlSave = "";

        if (id_job_category == '' || id_job_category == null) {
            urlSave += "{{ route('backoffice.master.job-category.store') }}";
        } else {
            urlSave += "{{ route('backoffice.master.job-category.update') }}";
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
                                callback:function(){
                                    initTable();
                                }
                            })
                        }
                    })
                }

            }
        })
    }

    onEdit = (el) => {
        var id = $(el).data('id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('backoffice.master.job-category.edit') }}",
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
            message: 'Are you sure you want to delete the data?',
            callback: function(res) {
                if (res) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('backoffice.master.job-category.destroy') }}",
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

</script>
