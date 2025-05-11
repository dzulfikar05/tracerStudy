<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive ">
                    <table class="table table-striped table-hover table-row-bordered border align-middle rounded w-100"
                        id="table_answer">
                        <thead class="text-center">
                            <tr class="fw-bolder">
                                <th style="width: 50px">No</th>
                                <th>Pengisi</th>

                                @if ($data['type'] === 'alumni')
                                    <th>NIM</th>
                                    <th>Email</th>
                                    <th>Program Studi</th>
                                @elseif ($data['type'] === 'superior')
                                    <th>Jabatan</th>
                                    <th>Nama Alumni</th>
                                    <th>NIM Alumni</th>
                                    <th>Prodi Alumni</th>
                                @endif

                                {{-- Kolom perusahaan tampil untuk semua --}}
                                <th>Nama Perusahaan</th>
                                <th>Alamat Perusahaan</th>
                                <th>Tipe Perusahaan</th>

                                {{-- Pertanyaan --}}
                                @foreach ($data['questions'] as $question)
                                    <th>{{ $question->question }}</th>
                                @endforeach

                                <th style="width: 100px">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('backoffice.questionnaire.javascriptAnswer')
