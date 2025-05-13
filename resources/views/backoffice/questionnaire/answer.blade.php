<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                {{-- Gunakan overflow-x dan pastikan table tidak wrap --}}
                <div style="overflow-x: auto; width: 100%;">
                    <table class="table table-striped table-hover table-row-bordered border align-middle rounded w-100"
                           id="table_answer" style="white-space: nowrap;">
                        <thead class="text-center">
                            <tr class="fw-bolder">
                                <th style="width: 50px">No</th>
                                <th>Pengisi</th>

                                @if ($data['type'] === 'alumni')
                                    <th>NIM</th>
                                    <th>Email</th>
                                    <th>Program Studi</th>
                                    <th>Atasan</th>
                                    <th>Posisi Atasan</th>
                                    <th>Email Atasan</th>
                                @elseif ($data['type'] === 'superior')
                                    <th>Jabatan</th>
                                    <th>Nama Alumni</th>
                                    <th>NIM Alumni</th>
                                    <th>Prodi Alumni</th>
                                @endif

                                <th>Nama Perusahaan</th>
                                <th>Alamat Perusahaan</th>
                                <th>Tipe Perusahaan</th>

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
