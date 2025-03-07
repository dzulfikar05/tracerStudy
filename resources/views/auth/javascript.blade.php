<script>
    var form = 'form_login';

    onLogin = () => {
        loadBlock();
        var formData = new FormData($(`[name="${form}"]`)[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : "{{ route('auth.login.authentication') }}",
            data: formData,
            method: 'post',
            processData: false,
            contentType: false,
            success: function(res){
                unblock();
                if(res['success'] == false){
                    saMessage({
                        message: res['message'],
                        callback:function(res){
                            if(res){
                                location.reload()
                            }
                        }
                    });
                }else{
                    location.reload()
                }
            }
        })
    }

</script>
