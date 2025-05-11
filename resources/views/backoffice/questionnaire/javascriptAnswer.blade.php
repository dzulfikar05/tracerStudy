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
            },
            {
                data: 'pengisi',
                title: 'Nama Pengisi',
                orderable: true,
                searchable: true
            }
        ];

        if (type === 'alumni') {
            columns.push({
                data: 'nim',
                title: 'NIM'
            }, {
                data: 'email',
                title: 'Email'
            }, {
                data: 'study_program',
                title: 'Program Studi'
            });
        } else if (type === 'superior') {
            columns.push({
                data: 'position',
                title: 'Jabatan'
            }, {
                data: 'alumni_name',
                title: 'Nama Alumni'
            }, {
                data: 'alumni_nim',
                title: 'NIM Alumni'
            }, {
                data: 'alumni_study_program',
                title: 'Prodi Alumni'
            });
        }

        // Kolom perusahaan (selalu ditampilkan)
        columns.push({
            data: 'company_name',
            title: 'Nama Perusahaan'
        }, {
            data: 'company_address',
            title: 'Alamat Perusahaan'
        }, {
            data: 'company_type',
            title: 'Tipe Perusahaan'
        });

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
