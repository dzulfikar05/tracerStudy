<script>
    var company_data = [];
    var profession_data = [];
    var profession_category_data = [];
    var alumni = [];

    $(() => {
        $('.company_id').select2({
            // placeholder: 'Pilih atau tambahkan perusahaan',
            // tags: true,
            dropdownParent: $('.survey-cards')
        });
        $('.profession_id').select2({
            dropdownParent: $('.survey-cards')
        });
        $('.alumni_id').select2({
            dropdownParent: $('.survey-cards')
        });
        $('.profession_category_id').select2({
            dropdownParent: $('.survey-cards')
        });

        onFetchOptionForm();

        getOptionAlumni();

    })



    onFetchOptionForm = () => {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `{{ route('fetch-option') }}`,
            method: 'get',
            success: function(data) {
                company_data = data.company;
                profession_data = data.profession;
                profession_category_data = data.profession_category;

                setOptionProfessionCategory();
                setOptionCompany();
            }
        })
    }


    getOptionAlumni = () => {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `{{ route('fetch-alumni') }}`,
            method: 'get',
            success: (response) => {
                alumni = response.alumni;
                setOptionAlumni()
            }
        })
    }

    setOptionAlumni = () => {
        $('.alumni_id').empty();
        var html = `<option value="">-- Pilih Alumni --</option>`;
        $.each(alumni, function(i, v) {
            html += `<option value="${v.id}">${v.nim} - ${v.full_name}</option>`;
        });
        $('.alumni_id').append(html);
    }

    setOptionProfessionCategory = () => {
        $('.profession_category_id').empty();
        $('.profession_category_id_new').empty();

        var html = `<option  selected disabled>-- Pilih Kategori Pekerjaan --</option>`;
        $.each(profession_category_data, function(i, v) {
            html += `<option value="${v.id}">${v.name}</option>`;
        });
        $('.profession_category_id').append(html);
        $('.profession_category_id_new').append(html);

        $('.profession_category_id').val('{{ $data['alumni']['profession']['profession_category_id'] ?? '' }}')
            .change();

    }

    $('.profession_category_id').on('change', function() {
        var id = $(this).val();
        $('.profession_id').empty();
        var html = `<option value="">-- Pilih Pekerjaan --</option>`;
        $.each(profession_data, function(i, v) {
            if (v.profession_category_id == id) {
                html += `<option value="${v.id}">${v.name}</option>`;
            }
        });
        $('.profession_id').append(html);
        setTimeout(() => {
            $('.profession_id').val('{{ $data['alumni']['profession_id'] ?? '' }}').change();
        }, 1000);
    });

    setOptionCompany = () => {
        $('.company_id').empty();
        var html = `<option value="">-- Pilih Perusahaan --</option>`;
        $.each(company_data, function(i, v) {
            if (v.scope == 'businessman') {
                html += `<option value="${v.id}" data-scope="${v.scope}">${v.name} (Wirausaha)</option>`;
            } else {
                html += `<option value="${v.id}" data-scope="${v.scope}">${v.name}</option>`;
            }
        });
        $('.company_id').append(html);
        setTimeout(() => {
            $('.company_id').val('{{ $data['alumni']['company_id'] ?? '' }}').change();
        }, 1000);
    }

    $('.company_id').on('change', function() {
        var scope = $(this).find('option:selected').attr('data-scope');

        if (scope == "businessman") {
            $('#data-atasan').addClass('d-none');
            $('a[href="#data-atasan"]').closest('li').addClass('d-none');
            $('.input-atasan-alumni').removeAttr('required');
        } else {
            $('#data-atasan').removeClass('d-none');
            $('a[href="#data-atasan"]').closest('li').removeClass('d-none');
            $('.input-atasan-alumni').attr('required', true);
        }
    });

    onValidateSuperior = (formData) => {
        const errors = [];
        const addError = (message) => errors.push(message);

        const nameRegex = /^[a-zA-Z\s.,'-]+$/;
        const phoneRegex = /^[0-9+]+$/;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        const alumniId = formData.get('alumni_id') || '';
        if (alumniId === '') {
            addError('Alumni tidak boleh kosong.');
        }


        let allQuestionsAnswered = true;
        $('.question-card').each(function() {
            const questionId = $(this).data('id');
            const answerValue = formData.get(`answers[${questionId}]`);

            if (String(answerValue || '').trim() === '') {
                allQuestionsAnswered = false;
            }
        });

        if (!allQuestionsAnswered) {
            addError('Semua pertanyaan kuesioner harus dijawab.');
        }

        if (errors.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                html: errors.join('<br>'),
                showConfirmButton: true,
                confirmButtonColor: '#3051d3'
            });
            return false;
        }
        return true;
    };

    onSaveSuperior = () => {
        var formData = new FormData($(`[name="form_superior"]`)[0]);

        if (!onValidateSuperior(formData)) {
            return;
        }

        saConfirm({
            message: 'Apakah anda yakin menyimpan data?',
            callback: function(res) {
                if (res) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('questionnaire.store-superior') }}",
                        method: 'post',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            saMessage({
                                success: res['success'],
                                title: res['title'],
                                message: res['message'],
                                callback: function() {
                                    window.location.href =
                                        "{{ route('index') }}";
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

    onValidateAlumni = (formData) => {
        const errors = [];
        const addError = (message) => errors.push(message);

        const nameRegex = /^[a-zA-Z\s.,'-]+$/;
        const phoneRegex = /^[0-9+]+$/;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const yearRegex = /^\d{4}$/;

        const alumniPhone = formData.get('alumni[phone]') || '';
        if (alumniPhone === '') addError('Nomor Telepon alumni tidak boleh kosong.');
        else if (!phoneRegex.test(alumniPhone)) addError(
            'Nomor Telepon alumni hanya boleh berisi angka dan tanda plus (+).');

        const alumniEmail = formData.get('alumni[email]') || '';
        if (alumniEmail === '') addError('Email alumni tidak boleh kosong.');
        else if (!emailRegex.test(alumniEmail)) addError('Format Email alumni tidak valid.');

        const alumniStudyStartYear = formData.get('alumni[study_start_year]') || '';
        if (alumniStudyStartYear === '') addError('Tahun Angkatan alumni tidak boleh kosong.');
        else if (!yearRegex.test(alumniStudyStartYear)) addError(
            'Tahun Angkatan alumni harus berupa 4 digit angka.');

        const alumniStartWorkDate = formData.get('alumni[start_work_date]') || '';
        if (alumniStartWorkDate === '') addError('Tanggal Mulai Kerja alumni tidak boleh kosong.');

        const alumniStartWorkNowDate = formData.get('alumni[start_work_now_date]') || '';
        if (alumniStartWorkNowDate === '') addError(
            'Tanggal Mulai Kerja (Pada Perusahaan Sekarang) alumni tidak boleh kosong.');

        const alumniProfessionId = formData.get('alumni[profession_id]') || '';
        if (alumniProfessionId === '') addError('Profesi alumni tidak boleh kosong.');

        const alumniCompanyId = formData.get('alumni[company_id]') || '';
        if (alumniCompanyId === '') addError('Perusahaan / Tempat Bekerja alumni tidak boleh kosong.');


        if (!($('#data-atasan').hasClass('d-none'))) {

            const superiorFullName = formData.get('superior[full_name]') || '';
            if (superiorFullName === '') addError('Nama Lengkap atasan tidak boleh kosong.');
            else if (!nameRegex.test(superiorFullName)) addError(
                'Nama Lengkap atasan hanya boleh berisi huruf, spasi, koma, titik, tanda hubung, dan apostrof.');

            const superiorPosition = formData.get('superior[position]') || '';
            if (superiorPosition === '') addError('Posisi atasan tidak boleh kosong.');

            const superiorPhone = formData.get('superior[phone]') || '';
            if (superiorPhone === '') addError('Nomor Telepon atasan tidak boleh kosong.');
            else if (!phoneRegex.test(superiorPhone)) addError(
                'Nomor Telepon atasan hanya boleh berisi angka dan tanda plus (+).');

            const superiorEmail = formData.get('superior[email]') || '';
            if (superiorEmail === '') addError('Email atasan tidak boleh kosong.');
            else if (!emailRegex.test(superiorEmail)) addError('Format Email atasan tidak valid.');
        }


        if ($('#data-kuisioner').hasClass('show') && $('#data-kuisioner').hasClass('active')) {
            let allQuestionsAnswered = true;
            $('.question-card').each(function() {
                const questionId = $(this).data('id');
                const answerValue = formData.get(`answers[${questionId}]`);

                if (String(answerValue || '').trim() === '') {
                    allQuestionsAnswered = false;
                }
            });

            if (!allQuestionsAnswered) addError('Semua pertanyaan kuesioner harus dijawab.');
        }

        if (errors.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                html: errors.join('<br>'),
                showConfirmButton: true,
                confirmButtonColor: '#3051d3'
            });
            return false;
        }
        return true;
    };

    onSaveAlumni = () => {
        var formData = new FormData($(`[name="form_alumni"]`)[0]);

        if (!onValidateAlumni(formData)) {
            return;
        }

        saConfirm({
            message: 'Apakah anda yakin menyimpan data?',
            callback: function(res) {
                if (res) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('questionnaire.store-alumni') }}",
                        method: 'post',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            saMessage({
                                success: res['success'],
                                title: res['title'],
                                message: res['message'],
                                callback: function() {
                                    if (res['success']) {
                                        if (res['data'] != null) {
                                            sendEmail({
                                                name: res['data'][
                                                    'name'
                                                ],
                                                email: res['data'][
                                                    'email'
                                                ],
                                                passcode: res['data'][
                                                    'passcode'
                                                ],
                                                redirect_link: res[
                                                    'data'][
                                                    'link'
                                                ],
                                                company_name: "Jurusan Teknologi Informasi Politeknik Negeri Malang",
                                            });
                                        } else {
                                            window.location.href = "/";
                                        }
                                    }
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

    (function() {
        emailjs.init({
            publicKey: "bSz0C_s_3J3SWGx5N",
        });
    })();

    function sendEmail(params) {
        const templateParams = params;

        emailjs
            .send("service_dqt1thn", "template_yhckvkj", templateParams)
            .then(function(response) {
                console.log("SUCCESS!", response.status, response.text);
                window.location.href = "/";
            })
            .catch(function(error) {
                console.error("FAILED...", error);
            });
    }

    $('#formAddCompany').on('submit', function(e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/company',
            method: 'post',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                const newOption = new Option(res.name, res.id, true, true);
                $('.company_id').append(newOption).trigger('change');

                $('#modalAddCompany').modal('hide');
                form.reset();
                onFetchOptionForm();

                saMessage({
                    success: res['success'],
                    title: res['title'],
                    message: res['message'],
                });
            },

        });
    });

    $('#formAddProfession').on('submit', function(e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/profession',
            method: 'post',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                const newOption = new Option(res.name, res.id, true, true);
                $('.profession_id').append(newOption).trigger('change');

                $('#modalAddProfession').modal('hide');
                form.reset();
                onFetchOptionForm();

                saMessage({
                    success: res['success'],
                    title: res['title'],
                    message: res['message'],
                });
            },

        });
    });
</script>

<script>
    $(document).ready(function() {


        $('.btn-next').on('click', function(e) {
            e.preventDefault();

            var $activeTab = $('.nav-tabs .nav-link.active');
            var $nextLi = $activeTab.closest('li').next('li');

            while ($nextLi.length && !$nextLi.is(':visible')) {
                $nextLi = $nextLi.next('li');
            }

            var $nextTab = $nextLi.find('.nav-link');
            if ($nextTab.length) {
                $nextTab.tab('show');
            }
        });

        $('.btn-prev').on('click', function(e) {
            e.preventDefault();

            var $activeTab = $('.nav-tabs .nav-link.active');
            var $prevLi = $activeTab.closest('li').prev('li');

            while ($prevLi.length && !$prevLi.is(':visible')) {
                $prevLi = $prevLi.prev('li');
            }

            var $prevTab = $prevLi.find('.nav-link');
            if ($prevTab.length) {
                $prevTab.tab('show');
            }
        });

    });
</script>
