<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div style="overflow-x: auto; width: 100%;">
                    <table
                        class="table table-bordered table-hover table-striped table-row-bordered align-middle rounded w-100"
                        id="table_answer" style="white-space: nowrap;">
                        <thead class="text-center bg-primary text-white">
                            <tr class="fw-bolder">
                                <th style="width: 50px" rowspan="2">No</th>
                                <th rowspan="2" class="text-start">Jenis Kemampuan</th>
                                <th colspan="{{ count($getHeaders) }}">Tingkat (%)</th>
                            </tr>
                            <tr>
                                @foreach ($getHeaders as $header)
                                    <th>{{ $header }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($listAnswer as $question => $answers)
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td class="text-start">{{ $question }}</td>
                                    @foreach ($getHeaders as $header)
                                        <td class="text-center fw-semibold">{{ $answers[$header] }}%</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="text-center fw-bold bg-secondary text-white">
                            <tr>
                                <td colspan="2" class="text-start">Jumlah Rata-rata</td>
                                @foreach ($getHeaders as $header)
                                    <td>{{ $footerTotal[$header] }}%</td>
                                @endforeach
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

@include('backoffice.questionnaire.javascriptAssessment')
