<script>
    var type = '{{ $questionnaire?->type }}';
    var prodi = [];
    $(()=> {
        getOption();
        $('#study_program').select2({
            dropdownParent: $('.survey-cards-vertical')
        });
    })

    getOption = () => {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `{{ route('fetch-option') }}`,
            method: 'get',
            success: (response) => {
                prodi = response.prodi;
                setOptionProdi()
            }
        })
    }

    setOptionProdi = () => {
        $('#study_program').empty();
        var html = `<option value="">-- Pilih Prodi --</option>`;
        $.each(prodi, function(i, v) {
            html += `<option value="${v}">${v}</option>`;
        });
        $('#study_program').append(html);
    }


    validateAlumni = () => {
        var formData = new FormData($(`[name="form_alumni"]`)[0]);
        loadBlock();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `{{ route('validate-alumni') }}`,
            method: 'post',
            data: formData,
            processData: false,
            contentType: false,
            success: (res) => {
                unblock();
                saMessage({
                    success: res['success'],
                    title: res['title'],
                    message: res['message'],
                    callback: function() {
                        window.location.href = "{{ route('questionnaire.content', $questionnaire->id) }}";
                    }
                })
            }
        })
    }

    validateSuperior = () => {
        var formData = new FormData($(`[name="form_superior"]`)[0]);
        loadBlock();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `{{ route('validate-superior') }}`,
            method: 'post',
            data: formData,
            processData: false,
            contentType: false,
            success: (res) => {
                unblock();
                saMessage({
                    success: res['success'],
                    title: res['title'],
                    message: res['message'],
                    callback: function() {
                        window.location.href = "{{ route('questionnaire.content', $questionnaire->id) }}";
                    }
                })
            }
        })
    }
</script>
