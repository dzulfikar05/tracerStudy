<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div style="overflow-x: auto; width: 100%;">
                    <table class="table table-striped table-hover table-row-bordered border align-middle rounded w-100"
                           id="table_answer" style="white-space: nowrap;">
                        <thead class="text-center">
                            <tr class="fw-bolder">
                                <th style="width: 50px">No</th>

                                @if ($data['type'] === 'alumni')
                                    <th>Program Studi</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>No. HP</th>
                                    <th>Email</th>
                                    <th>Angkatan</th>
                                    <th>Tanggal Lulus</th>
                                    <th>Tahun Lulus</th>
                                    <th>Tanggal Pertama Kerja</th>
                                    <th>Masa Tunggu</th>
                                    <th>Tanggal Kerja Instansi</th>

                                    <th>Jenis Instansi</th>
                                    <th>Nama Instansi</th>
                                    <th>Skala</th>
                                    <th>Lokasi</th>

                                    <th>Kategori Profesi</th>
                                    <th>Profesi</th>

                                    <th>Nama Atasan Langsung</th>
                                    <th>Jabatan Atasan Langsung</th>
                                    <th>No. HP Atasan Langsung</th>
                                    <th>Email Atasan</th>

                                @elseif ($data['type'] === 'superior')
                                    <th>Nama</th>
                                    <th>Instansi</th>
                                    <th>Jabatan</th>
                                    <th>Email</th>

                                    <th>Nama Alumni</th>
                                    <th>Program Studi</th>
                                    <th>Angkatan</th>
                                    <th>Tahun Lulus</th>
                                @endif



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
