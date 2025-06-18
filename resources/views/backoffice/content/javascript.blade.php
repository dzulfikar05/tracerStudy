<script>
    var table = 'table_content';
    var form = 'form_content';
    var fields = [
        'id',
        'type',
        'title',
        'text',
        'image',
    ];


    $(() => {

        if (typeof CKEDITOR !== 'undefined') {
            CKEDITOR.replace('text');
        } else {
            console.error('CKEditor not loaded');
        }

        $('#type').select2({
            dropdownParent: $('.viewForm')
        });
        $('#filter_type').select2({
            dropdownParent: $('.index-page')
        });

        loadBlock();
        initTable();
    })

    showForm = () => {
        $('#id').val('');

        onReset();
        $('.viewForm').modal('show')
    }

    $('#filter_type').on('change', function() {
        initTable();
    })

    initTable = () => {
        var table = $('#table_content').DataTable({
            processing: true,
            serverSide: true,
            searchAble: true,
            scrollX: true,
            searching: true,
            paging: true,
            "bDestroy": true,
            // ajax: "{{ route('backoffice.content.table') }}",
            ajax: {
                url: "{{ route('backoffice.content.table') }}",
                data: function(d) {
                    d.type = $('#filter_type').val();
                }
            },
            columns: [{
                    "data": null,
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1
                    }
                },
                {
                    data: 'type',
                    name: 'type',
                    render: function(data, type, full, meta) {
                        var html = "";
                        if (full.type == 'carousel') {
                            html += `<span>Gambar Carousel</span>`;
                        } else if (full.type == 'home') {
                            html += `<span>Konten Halaman Home</span>`;
                        } else if (full.type == 'about') {
                            html += `<span>Kontent Halaman About</span>`;
                        }
                        return html;
                    }
                },
                {
                    data: 'title',
                    name: 'title',
                    render: function(data, type, full, meta) {
                        return `<span>${full.title??''}</span>`;
                    }
                },
                {
                    data: 'order',
                    name: 'order',
                    render: function(data, type, full, meta) {
                        const disableUp = full.is_first;
                        const disableDown = full.is_last;


                        var html = `
                            <button type="button" class="btn btn-primary btn-sm" onclick="upOrder(${full.id})" ${disableUp ? 'disabled' : ''}>
                                <i class="fa fa-arrow-up"></i>
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="downOrder(${full.id})" ${disableDown ? 'disabled' : ''}>
                                <i class="fa fa-arrow-down"></i>
                            </button>
                        `;
                        return html;
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

                let tbody = $('#table_content tbody');
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
        let id_content = $('#id').val();
        let urlSave = "";

        if (id_content == '' || id_content == null) {
            urlSave = `{{ route('backoffice.content.store') }}`;
        } else {
            urlSave = `{{ route('backoffice.content.update', ['id' => '__ID__']) }}`.replace('__ID__',
                id_content);
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
        })
    }

    onEdit = (el) => {
        var id = $(el).data('id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `{{ route('backoffice.content.edit', ['id' => '__ID__']) }}`.replace('__ID__', id),
            data: {
                id: id
            },
            method: 'post',
            success: function(data) {

                showForm()
                let img = data.image;

                let path = "{{ asset('storage/content/') }}/" + img;
                $('#image-preview').attr('src', path).show();


                setTimeout(function() {
                    if (CKEDITOR.instances['text']) {
                        CKEDITOR.instances['text'].setData(data.text ?? '');
                    }
                }, 200);

                $.each(fields, function(i, v) {
                    $('#' + v).val(data[v]).change()
                })
            }
        })
    }

    onDelete = (el) => {
        var id = $(el).data('id');
        saConfirm({
            message: 'Apakah anda yakin menghapus data?',
            callback: function(res) {
                if (res) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: `{{ route('backoffice.content.destroy', ['id' => '__ID__']) }}`
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
        $('#image').val('');
        $('#image-preview').attr('src', '').hide();
        setTimeout(function() {
            if (CKEDITOR.instances['text']) {
                CKEDITOR.instances['text'].setData('');
            }
        }, 100);

        $.each(fields, function(i, v) {
            $('#' + v).val('').change()
        })
    }


    function previewImage(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            $('#image-preview')
                .attr('src', e.target.result)
                .show();
        };
        reader.readAsDataURL(file);
    }

    $('#drop-area').on('click', function() {
        $('#image')[0].click();
    });

    $('#image').on('change', function() {
        if (this.files && this.files[0]) {
            previewImage(this.files[0]);
        }
    });

    $('#drop-area').on('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass('dragover');
    });

    $('#drop-area').on('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('dragover');
    });

    $('#drop-area').on('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('dragover');

        const files = e.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            $('#image')[0].files = files;
            previewImage(files[0]);
        }
    });

    function upOrder(id) {
        $.ajax({
            url: `{{ route('backoffice.content.up-order', ['id' => '__ID__']) }}`.replace('__ID__', id),
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                initTable();
            },
            error: function(xhr) {
                alert('Gagal menaikkan urutan.');
            }
        });
    }

    function downOrder(id) {
        $.ajax({
            url: `{{ route('backoffice.content.down-order', ['id' => '__ID__']) }}`.replace('__ID__', id),
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                initTable();
            },
            error: function(xhr) {
                alert('Gagal menurunkan urutan.');
            }
        });
    }
</script>
