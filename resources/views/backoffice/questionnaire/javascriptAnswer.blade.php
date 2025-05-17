<script>
    let questions = @json($data->questions ?? []);
    let type = @json($data->type); // 'alumni' atau 'superior'

    $(() => {
        initTable();
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
            }
        ];

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
            },
            {
                data: 'study_start_year',
                title: 'Angkatan'
            },
            {
                data: 'graduation_date',
                title: 'Tanggal Lulus'
            },
            {
                data: 'graduation_year',
                title: 'Tahun Lulus'
            },
            {
                data: 'start_work_date',
                title: 'Tanggal Pertama Kerja'
            },
            {
                data: 'waiting_time',
                title: 'Masa Tunggu',
                render: (data) => {
                    return `<span>${data ?? '-'} Bulan</span>`
                }
            },
            {
                data: 'start_work_now_date',
                title: 'Tanggal Kerja Instansi'
            },
            {
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
            },
            {
                data: 'company_name',
                title: 'Nama Instansi'
            },
            {
                data: 'company_scope',
                title: 'Skala',
                render: (data) => {
                    if (data === 'local') {
                        return `<span>Lokal</span>`;
                    }else if (data === 'national') {
                        return `<span>Nasional</span>`;
                    }else if (data === 'international') {
                        return `<span>Internasional</span>`;
                    }

                }
            },
            {
                data: 'company_address',
                title: 'Lokasi'
            },
            {
                data: 'profession_category',
                title: 'Kategori Profesi'
            },
            {
                data: 'profession',
                title: 'Profesi'
            },
            {
                data: 'superior_name',
                title: 'Nama Atasan Langsung'
            },
            {
                data: 'superior_position',
                title: 'Jabatan Atasan Langsung'
            },
            {
                data: 'superior_phone',
                title: 'No. HP Atasan Langsung'
            },
            {
                data: 'superior_email',
                title: 'Email Atasan'
            }
        );
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
            ajax: "{{ route('backoffice.questionnaire.answer-table', ['id' => $data->id]) }}",
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
</script>
