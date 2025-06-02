<script>
    var form = 'form_login';
    var form_forgot = 'form_forgot';
    var form_reset = 'form_reset';

    onLogin = () => {
        loadBlock();
        var formData = new FormData($(`[name="${form}"]`)[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('auth.login.authentication') }}",
            data: formData,
            method: 'post',
            processData: false,
            contentType: false,
            success: function(res) {
                unblock();
                if (res['success'] == false) {
                    saMessage({
                        message: res['message'],
                        callback: function(res) {
                            $('#password').val('')
                        }
                    });
                } else {

                    location.reload()
                }
            }
        })
    }

    onForgot = () => {
        loadBlock();
        var formData = new FormData($(`[name="${form_forgot}"]`)[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('auth.forgot-password.send') }}",
            data: formData,
            method: 'post',
            processData: false,
            contentType: false,
            success: function(res) {
                unblock();
                if (res['success'] == true) {
                    saMessage({
                        success: res['success'],
                        title: res['title'],
                        message: res['message'],
                        callback: function() {
                            sendEmail({
                                email: res['data']['email'],
                                link: res['data']['url'],
                                company_name: "JTI Politeknik Negeri Malang",
                            })
                        }
                    });
                }else{
                    saMessage({
                        success: false,
                        title: "Gagal",
                        message: "Email tidak ditemukan",
                    });
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
            .send("service_dqt1thn", "template_5gytikx", templateParams)
            .then(function(response) {
                console.log("SUCCESS!", response.status, response.text);
                window.location.href = "/backoffice";
            })
            .catch(function(error) {
                console.error("FAILED...", error);
            });
    }


    onReset = () => {
        var formData = new FormData($(`[name="${form_reset}"]`)[0]);
        const password = $('#password').val();
        const passwordConfirm = $('#password_confirmation').val();

        // Validasi kosong
        if (!password || !passwordConfirm) {
            saMessage({
                success: false,
                title: "Validasi Gagal",
                message: "Password dan konfirmasi password tidak boleh kosong.",
            });
            return;
        }

        // Validasi panjang minimal
        if (password.length < 8) {
            saMessage({
                success: false,
                title: "Validasi Gagal",
                message: "Password minimal 8 karakter.",
            });
            return;
        }

        // Validasi kecocokan
        if (password !== passwordConfirm) {
            saMessage({
                success: false,
                title: "Validasi Gagal",
                message: "Konfirmasi password tidak cocok.",
            });
            return;
        }
        loadBlock();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('auth.reset-password.update') }}",
            data: formData,
            method: 'post',
            processData: false,
            contentType: false,
            success: function(res) {
                unblock();
                if (res['success'] == true) {
                    saMessage({
                        success: res['success'],
                        title: res['title'],
                        message: res['message'],
                        callback: function() {
                            window.location.href = "/backoffice";
                        }
                    });
                }else{
                    saMessage({
                        success: false,
                        title: "Gagal",
                        message: "Gagal Mengubah Password",
                    });
                }
            }
        })
    }
</script>
