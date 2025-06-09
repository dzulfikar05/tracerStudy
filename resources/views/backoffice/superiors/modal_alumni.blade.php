<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Daftar Alumni</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Alumni</th>
                        <th>NIM</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Status Survei</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($alumnis as $index => $alumni)
                        @php
                            $isFilled = \DB::table('answers')
                                ->where('filler_type', 'superior')
                                ->where('filler_id', $alumni->superior_id)
                                ->where('alumni_id', $alumni->id)
                                ->exists();
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $alumni->full_name }}</td>
                            <td>{{ $alumni->nim }}</td>
                            <td>{{ $alumni->email }}</td>
                            <td>{{ $alumni->phone }}</td>
                            <td>
                                @if ($isFilled)
                                    <span class="text-success">
                                        <i class="fas fa-check-circle"></i> Terisi
                                    </span>
                                @else
                                    <span class="text-danger">
                                        <i class="fas fa-times-circle"></i> Belum Terisi
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada alumni.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-end mt-3 @if ($alumnis->isEmpty()) d-none @endif"
                onclick="sendReminderAll()">
                <button class="btn btn-primary" onclick="sendReminderAll()"><i class="fa fa-paper-plane"></i> Kirim Reminder </button>
            </div>
        </div>
    </div>
</div>


<script>
    (function() {
        emailjs.init({
            publicKey: "bSz0C_s_3J3SWGx5N",
        });
    })();


    function sendReminderAll() {

        const superiorId = "{{ $alumnis->first()->superior_id ?? null }}";
        if (!superiorId) {
            Swal.fire('Error!', 'Tidak dapat menemukan atasan terkait', 'error');
            return;
        }

        sendReminder(superiorId);
    }


    function sendReminder(superiorId) {
        Swal.fire({
            title: 'Kirim Reminder?',
            text: 'Email berisi passcode akan dikirim ke atasan',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Kirim',
            cancelButtonText: 'Batal',
            focusConfirm: false
        }).then((result) => {
            if (result.value == true) {
                Swal.fire({
                    title: 'Mengirim email...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                $.ajax({
                    url: `/backoffice/superior/send-reminder/${superiorId}`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        Swal.close();
                        console.log('Response:', response);
                        if (response.success) {
                            const data = response.data;

                            console.log('Data untuk email:', data);

                            emailjs.send("service_dqt1thn", "template_yhckvkj", {
                                    name: data.name,
                                    email: data.email,
                                    passcode: data.passcode,
                                    company_name: data.company_name,
                                    redirect_link: "{{ route('list-questionnaire') }}"
                                })
                                .then(() => {
                                    Swal.fire('Sukses!', 'Email reminder telah dikirim',
                                        'success');
                                })
                                .catch((error) => {
                                    console.error('Error EmailJS:', error);
                                    Swal.fire(
                                        'Error!',
                                        'Gagal mengirim email.',
                                        'error'
                                    );
                                });
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.close();
                        let message = 'Gagal mengirim reminder';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        console.error('Error AJAX:', xhr.responseText);
                        Swal.fire('Error!', message, 'error');
                    }
                });
            }
        });
    }
</script>
