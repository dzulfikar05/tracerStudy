<script>
    let questions = @json($data->questions ?? []);
    let type = @json($data->type); // 'alumni' atau 'superior'

    $(() => {
        initTable();

        $('#filter_study_program').select2({
            dropdownParent: $('.filterModal')
        });
        $('#filter_company').select2({
            dropdownParent: $('.filterModal')
        });
        $('#filter_profession_category').select2({
            dropdownParent: $('.filterModal')
        });
        $('#filter_profession').select2({
            dropdownParent: $('.filterModal')
        });
    });

    const generateQuestionColumns = () => {
        return questions.map((question) => ({
            data: `q_${question.id}`,
            name: `q_${question.id}`,
            title: question.question,
            render: (data) => `<span>${data ?? '-'}</span>`
        }));
    };

    const getDynamicColumns = () => {
        let columns = [{
            data: null,
            title: 'No',
            orderable: false,
            render: (data, type, row, meta) =>
                meta.row + meta.settings._iDisplayStart + 1
        }];

        if (type === 'alumni') {
            columns.push({
                data: 'study_program',
                title: 'Program Studi'
            }, {
                data: 'nim',
                title: 'NIM'
            }, {
                data: 'full_name',
                title: 'Nama'
            }, {
                data: 'phone',
                title: 'No. HP'
            }, {
                data: 'email',
                title: 'Email '
            }, {
                data: 'study_start_year',
                title: 'Angkatan'
            }, {
                data: 'graduation_date',
                title: 'Tanggal Lulus'
            }, {
                data: 'graduation_year',
                title: 'Tahun Lulus'
            }, {
                data: 'start_work_date',
                title: 'Tanggal Pertama Kerja'
            }, {
                data: 'waiting_time',
                title: 'Masa Tunggu',
                render: (data) => {
                    return `<span>${data ?? '-'} Bulan</span>`
                }
            }, {
                data: 'start_work_now_date',
                title: 'Tanggal Kerja Instansi'
            }, {
                data: 'company_type',
                title: 'Jenis Instansi',
                render: (data) => {
                    if (data === 'higher_education') {
                        return `<span>Perguruan Tinggi</span>`;
                    } else if (data === 'government_agency') {
                        return `<span>Instansi Pemerintah</span>`;
                    } else if (data === 'state-owned_enterprise') {
                        return `<span>BUMN</span>`;
                    } else if (data === 'private_company') {
                        return `<span>Swasta</span>`;
                    }
                }
            }, {
                data: 'company_name',
                title: 'Nama Instansi'
            }, {
                data: 'company_scope',
                title: 'Skala',
                render: (data) => {
                    if (data === 'businessman') {
                        return `<span>Wirausaha</span>`;
                    } else if (data === 'national') {
                        return `<span>Nasional</span>`;
                    } else if (data === 'international') {
                        return `<span>Internasional</span>`;
                    }

                }
            }, {
                data: 'company_address',
                title: 'Lokasi'
            }, {
                data: 'profession_category',
                title: 'Kategori Profesi'
            }, {
                data: 'profession',
                title: 'Profesi'
            }, {
                data: 'superior_name',
                title: 'Nama Atasan Langsung'
            }, {
                data: 'superior_position',
                title: 'Jabatan Atasan Langsung'
            }, {
                data: 'superior_phone',
                title: 'No. HP Atasan Langsung'
            }, {
                data: 'superior_email',
                title: 'Email Atasan'
            });
        } else if (type === 'superior') {
            columns.push({
                data: 'full_name',
                title: 'Nama'
            }, {
                data: 'company_name',
                title: 'Instansi'
            }, {
                data: 'position',
                title: 'Jabatan'
            }, {
                data: 'email',
                title: 'Email'
            }, {
                data: 'alumni_name',
                title: 'Nama Alumni'
            }, {
                data: 'alumni_study_program',
                title: 'Program Studi'
            }, {
                data: 'study_start_year',
                title: 'Angkatan'
            }, {
                data: 'graduation_year',
                title: 'Tahun Lulus'
            });
        }

        return columns;
    };

    const initTable = () => {
        const columns = [
            ...getDynamicColumns(),
            ...generateQuestionColumns(),
            {
                data: 'action',
                title: 'Aksi',
                orderable: false,
                searchable: false
            }
        ];

        $('#table_answer').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            paging: true,
            bDestroy: true,
            ajax: {
                url: "{{ route('backoffice.questionnaire.answer-table', ['id' => $data->id]) }}",
                data: function(d) {
                    d.study_program = $('#filter_study_program').val();
                    d.nim = $('#filter_nim').val();
                    d.study_start_year = $('#filter_study_start_year').val();
                    d.graduation_year = $('#filter_graduation_year').val();
                    d.company_id = $('#filter_company').val();
                    d.profession_category_id = $('#filter_profession_category').val();
                    d.profession_id = $('#filter_profession').val();
                }
            },
            columns: columns
        });


        unblock();
    };

    onDeleteAnswer = (el) => {
        var fillerType = $(el).data('filler-type');
        var fillerId = $(el).data('filler-id');
        var questionnaireId = $(el).data('questionnaire-id');

        saConfirm({
            message: 'Are you sure you want to delete this answer?',
            callback: function(res) {
                if (res) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: `{{ route('backoffice.questionnaire.answer.delete') }}`,
                        data: {
                            filler_type: fillerType,
                            filler_id: fillerId,
                            questionnaire_id: questionnaireId
                        },
                        method: 'post',
                        success: function(res) {
                            saMessage({
                                success: res['success'],
                                title: res['title'],
                                message: res['message']
                            });
                            // You can reload or refresh your table after the deletion
                            $('#example').DataTable().ajax.reload();
                        },
                        error: function() {
                            saMessage({
                                success: false,
                                title: 'Error',
                                message: 'An error occurred while deleting the answer.'
                            });
                        }
                    });
                }
            }
        });
    }

    let company_data = [];
    let profession_data = [];
    let profession_category_data = [];
    let superior_data = [];
    let prodi_data = [];

    $(() => {
        onFetchOptionForm();
        initTable();
    });

    function onFetchOptionForm() {
        $.ajax({
            url: "{{ route('backoffice.alumni.fetch-option') }}",
            method: 'GET',
            success: function(data) {
                company_data = data.company;
                profession_data = data.profession;
                profession_category_data = data.profession_category;
                superior_data = data.superior;
                prodi_data = data.prodi;

                setOptionProdi();
                setOptionSkala();
                setOptionCompany();
                setOptionProfessionCategory();
            }
        });
    }

    function setOptionProdi() {
        $('#filter_study_program').empty();
        let html = `<option value="">-- Pilih Program Studi --</option>`;
        $.each(prodi_data, (i, v) => {
            html += `<option value="${v}">${v}</option>`;
        });
        $('#filter_study_program').append(html);
    }

    function setOptionSkala() {
        let html = `
        <option value="">-- Pilih Skala --</option>
        <option value="local">Lokal</option>
        <option value="national">Nasional</option>
        <option value="international">Internasional</option>
    `;
        $('#filter_scale').html(html);
    }

    function setOptionCompany() {
        $('#filter_company').empty();
        let html = `<option value="">-- Pilih Perusahaan --</option>`;
        $.each(company_data, (i, v) => {
            html += `<option value="${v.id}">${v.name}</option>`;
        });
        $('#filter_company').append(html);
    }

    function setOptionProfessionCategory() {
        $('#filter_profession_category').empty();
        let html = `<option value="">-- Pilih Kategori Profesi --</option>`;
        $.each(profession_category_data, (i, v) => {
            html += `<option value="${v.id}">${v.name}</option>`;
        });
        $('#filter_profession_category').append(html);
    }

    $('#filter_profession_category').on('change', function() {
        const id = $(this).val();
        $('#filter_profession').empty();
        let html = `<option value="">-- Pilih Profesi --</option>`;
        $.each(profession_data, (i, v) => {
            if (v.profession_category_id == id) {
                html += `<option value="${v.id}">${v.name}</option>`;
            }
        });
        $('#filter_profession').append(html);
    });

    function applyFilter() {
        $('#filterModal').modal('hide');

        $('#table_answer').DataTable().ajax.reload();
    }


    $(document).ready(function() {
        $('.btn-export-excel').on('click', function(e) {
            e.preventDefault();

            var study_program = $('#filter_study_program').val();
            var nim = $('#filter_nim').val();
            var study_start_year = $('#filter_study_start_year').val();
            var graduation_year = $('#filter_graduation_year').val();
            var company_id = $('#filter_company').val();
            var profession_category_id = $('#filter_profession_category').val();
            var profession_id = $('#filter_profession').val();

            var url = "{{ route('backoffice.questionnaire.export-answer', $data->id) }}";
            url += '?study_program=' + encodeURIComponent(study_program || '');
            url += '&nim=' + encodeURIComponent(nim || '');
            url += '&study_start_year=' + encodeURIComponent(study_start_year || '');
            url += '&graduation_year=' + encodeURIComponent(graduation_year || '');
            url += '&company_id=' + encodeURIComponent(company_id || '');
            url += '&profession_category_id=' + encodeURIComponent(profession_category_id || '');
            url += '&profession_id=' + encodeURIComponent(profession_id || '');

            window.location.href = url;
        });
    });
</script>
