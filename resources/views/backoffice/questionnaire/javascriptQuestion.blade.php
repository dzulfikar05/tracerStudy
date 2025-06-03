<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function updateCardNumbers() {
        $('#question_container .question-card').each(function(i) {
            $(this).find('.question-title').text('Pertanyaan #' + (i + 1));
        });
    }

    function renderExisting() {
        let questions = @json($data->questions);
        questions.forEach(q => appendCard(q.id, q.question, q.type, q.options, q.is_assessment));
        updateCardNumbers();
    }

    function appendCard(id, question = '', type = 'essay', options = [], is_assessment = false) {
        let uniqueId = id ?? 'new_' + Date.now();
        let isChoice = type === 'choice';

        let card = $(`
            <div class="card mb-3 question-card" id="question_${uniqueId}" data-id="${uniqueId}">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h6 class="question-title">Pertanyaan</h6>
                        <div class="btn-group">
                            <button type="button" class="btn btn-success btn-sm me-1" onclick="onSaveQuestion('${uniqueId}')">
                                <i data-feather="save"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="onDeleteQuestion('${uniqueId}')">
                                <i data-feather="trash-2"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label>Pertanyaan</label>
                        <textarea class="form-control" rows="2" data-field="question">${question}</textarea>
                    </div>

                    <div class="form-group mt-2">
                        <label>Tipe</label>
                        <select class="form-control" data-field="type" onchange="toggleOptionSection(this)">
                            <option value="essay" ${type === 'essay' ? 'selected' : ''}>Essay</option>
                            <option value="choice" ${type === 'choice' ? 'selected' : ''}>Pilihan Ganda</option>
                        </select>
                    </div>

                    <div class="form-group mt-2 option-section ${isChoice ? '' : 'd-none'}">
                        <label>Opsi Jawaban</label>
                        <div class="row option-list" data-field="options"></div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addOption(this)">
                            + Tambah Opsi
                        </button>
                    </div>

                    <div class="form-check mt-3 assessment-section ${isChoice ? '' : 'd-none'}">
                        <input class="form-check-input" type="checkbox" data-field="is_assessment" ${is_assessment ? 'checked' : ''}>
                        <label class="form-check-label">Digunakan untuk penilaian (assessment)</label>
                    </div>
                </div>
            </div>
        `);

        $('#question_container').append(card);
        feather.replace();

        if (isChoice) {
            let defaultOptions = ['Sangat Baik', 'Baik', 'Cukup', 'Kurang'];
            renderOptions(card, options && options.length ? options : defaultOptions);
        }
    }

    function toggleOptionSection(select) {
        let cardBody = $(select).closest('.card-body');
        let optionSection = cardBody.find('.option-section');
        let assessmentSection = cardBody.find('.assessment-section');

        if (select.value === 'choice') {
            optionSection.removeClass('d-none');
            assessmentSection.removeClass('d-none');

            let list = cardBody.find('.option-list');
            if (list.children().length === 0) {
                let defaultOptions = ['Sangat Baik', 'Baik', 'Cukup', 'Kurang'];
                renderOptions(cardBody.closest('.question-card'), defaultOptions);
            }
        } else {
            optionSection.addClass('d-none');
            assessmentSection.addClass('d-none');
        }
    }

    function renderOptions(card, options) {
        let list = card.find('.option-list').empty();

        if (typeof options === 'string') {
            try {
                options = JSON.parse(options);
            } catch (e) {
                options = [];
            }
        }

        options.forEach(val => {
            list.append(`
                <div class="col-2 mb-2 option-item">
                    <div class="input-group">
                        <input type="text" class="form-control" value="${val}" />
                        <button type="button" class="btn btn-outline-danger" onclick="removeOption(this)">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                </div>
            `);
        });

        feather.replace();
    }

    function addOption(btn) {
        let list = $(btn).closest('.card-body').find('.option-list');
        list.append(`
            <div class="col-2 mb-2 option-item">
                <div class="input-group">
                    <input type="text" class="form-control" />
                    <button type="button" class="btn btn-outline-danger" onclick="removeOption(this)">
                        <i data-feather="x"></i>
                    </button>
                </div>
            </div>
        `);
        feather.replace();
    }

    function removeOption(btn) {
        $(btn).closest('.option-item').remove();
    }

    function onAddQuestion() {
        appendCard(null);
        updateCardNumbers();
    }

    function onSaveQuestion(uniqueId) {
        let card = $(`#question_${uniqueId}`);
        let isNew = uniqueId.startsWith('new_');
        let payload = {
            question: card.find('[data-field="question"]').val()?.trim() || '',
            type: card.find('[data-field="type"]').val(),
            options: [],
        };

        if (payload.type === 'choice') {
            card.find('.option-list input').each(function() {
                let v = $(this).val().trim();
                if (v) payload.options.push(v);
            });

            if (payload.options.length === 0) {
                return saMessage({
                    success: false,
                    title: 'Opsi Kosong',
                    message: 'Minimal satu opsi jawaban diperlukan.'
                });
            }

            payload.is_assessment = card.find('[data-field="is_assessment"]').is(':checked') ? 1 : 0;
        }

        const storeUrl = `{{ route('backoffice.questionnaire.question.store', $data->id) }}`;
        const updateTemplate =
            `{{ route('backoffice.questionnaire.question.update', ['id' => $data->id, 'question' => 'QUESTION_ID']) }}`;
        const url = isNew ? storeUrl : updateTemplate.replace('QUESTION_ID', uniqueId);

        saConfirm({
            message: 'Yakin akan menyimpan pertanyaan ini?',
            callback: function(ok) {
                if (!ok) return;
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: payload,
                    success: function(res) {
                        if (isNew) {
                            // Hapus card lama
                            card.remove();

                            // Tambahkan ulang dengan ID baru dari backend
                            appendCard(res.id, payload.question, payload.type, payload.options,
                                payload.is_assessment || false);
                        }

                        saMessage({
                            success: true,
                            title: 'Berhasil',
                            message: 'Pertanyaan disimpan.'
                        });

                        updateCardNumbers();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let msgs = Object.values(xhr.responseJSON.errors).flat().join(
                                '<br>');
                            Swal.fire({
                                toast: true,
                                position: 'bottom-end',
                                icon: 'error',
                                title: 'Validasi Gagal',
                                html: msgs,
                                showConfirmButton: false,
                                timer: 6000,
                                timerProgressBar: true
                            });
                        } else {
                            saMessage({
                                success: false,
                                title: 'Gagal',
                                message: 'Terjadi kesalahan saat menyimpan.'
                            });
                        }
                    }
                });
            }
        });
    }


    function onDeleteQuestion(uniqueId) {
        let card = $(`#question_${uniqueId}`);
        let isNew = uniqueId.startsWith('new_');

        saConfirm({
            message: 'Yakin akan menghapus pertanyaan ini?',
            callback: function(ok) {
                if (!ok) return;
                if (isNew) {
                    card.remove();
                    updateCardNumbers();
                } else {
                    const destroyTemplate =
                        `{{ route('backoffice.questionnaire.question.destroy', ['id' => $data->id, 'question' => 'QUESTION_ID']) }}`;
                    let url = destroyTemplate.replace('QUESTION_ID', uniqueId);
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        success: function() {
                            card.remove();
                            updateCardNumbers();
                            saMessage({
                                success: true,
                                title: 'Berhasil',
                                message: 'Pertanyaan dihapus.'
                            });
                        },
                        error: function() {
                            saMessage({
                                success: false,
                                title: 'Gagal',
                                message: 'Tidak dapat menghapus pertanyaan.'
                            });
                        }
                    });
                }
            }
        });
    }

    $(function() {
        renderExisting();
    });
</script>
