<script>
    let professionChart;
    let companyTypeChart;

    $(document).ready(function() {
        $('#myTab a').on('click', function(e) {
            e.preventDefault();
            $(this).tab('show');
        });
    });

    $(() => {

        $('#filter_year_start').select2({
            dropdownParent: $('.filter_card')
        });
        $('#filter_year_end').select2({
            dropdownParent: $('.filter_card')
        });
        $('#filter_study_program').select2({
            dropdownParent: $('.filter_card')
        });

        onFetchDashboard();
    });

    onFetchFilter = () => {
        year_start = $('#filter_year_start').val();
        year_end = $('#filter_year_end').val();

        if (year_start == "" || year_end == "") {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Filter tahun mulai dan sampai tahun tidak boleh kosong',
            });
            return;
        }

        if (parseInt(year_start) > parseInt(year_end)) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Tahun mulai tidak boleh lebih dari tahun sampai.',
            });
            return;
        }

        onFetchDashboard();
    }

    onResetFilter = () => {
        $('#filter_year_start').val('').trigger('change');
        $('#filter_year_end').val('').trigger('change');
        $('#filter_study_program').val('').trigger('change');

        onFetchDashboard();
    }

    onFetchDashboard = () => {
        onChartProfession();
        categoryProfessionChart();

        setTimeout(() => {
            onFetchTableProfession();
            onFetchTableWaitingTime();
        }, 200);

        setTimeout(() => {
            onFetchTableAssessment();
            onAssessmentChart();
        }, 800);

    }


    onFetchTableProfession = () => {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `{{ route('backoffice.dashboard.get-table-profession') }}`,
            data: {
                year_start: $('#filter_year_start').val(),
                year_end: $('#filter_year_end').val(),
                study_program: $('#filter_study_program').val(),
            },
            method: 'post',
            success: function(response) {
                const tbody = $('#table_profession tbody');
                const data = response.data;

                tbody.empty();

                // Inisialisasi total
                let total = {
                    count_alumni: 0,
                    count_alumni_filled: 0,
                    infokom: 0,
                    non_infokom: 0,
                    multi: 0,
                    national: 0,
                    wirausaha: 0,
                };

                data.forEach(row => {
                    tbody.append(`
                    <tr class="text-center">
                        <td>${row.year}</td>
                        <td>${row.count_alumni}</td>
                        <td>${row.count_alumni_filled}</td>
                        <td>${row.infokom}</td>
                        <td>${row.non_infokom}</td>
                        <td>${row.multi}</td>
                        <td>${row.national}</td>
                        <td>${row.wirausaha}</td>
                    </tr>
                `);

                    // Tambah total
                    total.count_alumni += row.count_alumni;
                    total.count_alumni_filled += row.count_alumni_filled;
                    total.infokom += row.infokom;
                    total.non_infokom += row.non_infokom;
                    total.multi += row.multi;
                    total.national += row.national;
                    total.wirausaha += row.wirausaha;
                });

                // Set total ke tfoot
                $('#sum_count_alumni').text(total.count_alumni);
                $('#sum_count_alumni_filled').text(total.count_alumni_filled);
                $('#sum_infokom').text(total.infokom);
                $('#sum_non_infokom').text(total.non_infokom);
                $('#sum_multi').text(total.multi);
                $('#sum_national').text(total.national);
                $('#sum_wirausaha').text(total.wirausaha);
            },
            error: function() {
                alert('Gagal memuat data profesi.');
            }
        });
    }

    onFetchTableWaitingTime = () => {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `{{ route('backoffice.dashboard.get-table-waiting-time') }}`,
            method: 'post',
            data: {
                year_start: $('#filter_year_start').val(),
                year_end: $('#filter_year_end').val(),
                study_program: $('#filter_study_program').val(),
            },
            success: function(response) {
                const tbody = $('#table_waiting_time tbody');
                const data = response.data;

                tbody.empty();

                data.forEach(row => {
                    tbody.append(`
                    <tr class="text-center">
                        <td>${row.year}</td>
                        <td>${row.count_alumni}</td>
                        <td>${row.count_alumni_filled}</td>
                        <td>${row.avg_waiting_time}</td>
                    </tr>
                `);
                });
            },
            error: function() {
                alert('Gagal memuat data profesi.');
            }
        });
    }

    onFetchTableAssessment = () => {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `{{ route('backoffice.dashboard.get-table-assessment') }}`,
            method: 'post',
            data: {
                year_start: $('#filter_year_start').val(),
                year_end: $('#filter_year_end').val(),
                study_program: $('#filter_study_program').val(),
            },
            success: function(response) {
                const table = $('#table_assessment');
                table.empty();

                const headers = response.get_headers;
                const listAnswer = response.list_answer;
                const footerTotal = response.footer_total;

                let thead = `
                <thead class="text-center bg-primary text-white">
                    <tr class="fw-bolder">
                        <th style="width: 50px" rowspan="2">No</th>
                        <th rowspan="2" class="text-start">Jenis Kemampuan</th>
                        <th colspan="${headers.length}">Tingkat (%)</th>
                    </tr>
                    <tr>
                        ${headers.map(header => `<th>${header}</th>`).join('')}
                    </tr>
                </thead>
            `;

                let tbody = `<tbody>`;
                let no = 1;
                for (const [question, answers] of Object.entries(listAnswer)) {
                    tbody += `<tr>`;
                    tbody += `<td class="text-center">${no++}</td>`;
                    tbody += `<td class="text-start">${question}</td>`;
                    headers.forEach(header => {
                        const value = answers[header] ?? 0;
                        tbody += `<td class="text-center fw-semibold">${value}%</td>`;
                    });
                    tbody += `</tr>`;
                }
                tbody += `</tbody>`;

                let tfoot = `
                <tfoot class="text-center fw-bold bg-secondary text-white">
                    <tr>
                        <td colspan="2" class="text-start">Jumlah Rata-rata</td>
                        ${headers.map(header => `<td>${footerTotal[header] ?? 0}%</td>`).join('')}
                    </tr>
                </tfoot>
            `;

                const fullTable = thead + tbody + tfoot;
                table.append(fullTable);
            },
            error: function(xhr) {
                alert('Gagal mengambil data assessment.');
            }
        });
    };



    onChartProfession = () => {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `{{ route('backoffice.dashboard.get-chart-profession') }}`,
            method: 'post',
            data: {
                year_start: $('#filter_year_start').val(),
                year_end: $('#filter_year_end').val(),
                study_program: $('#filter_study_program').val(),
            },
            success: function(response) {
                const labels = response.data.map(item => item.label);
                const values = response.data.map(item => item.value);

                const ctx = document.getElementById('professionChart').getContext('2d');

                if (professionChart) professionChart.destroy();

                professionChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Sebaran Profesi',
                            data: values,
                            backgroundColor: generateColors(labels.length),
                            borderColor: '#fff',
                            borderWidth: 1
                        }]
                    },
                    options: chartOptions('Grafik Sebaran Profesi Lulusan')
                });
            },
            error: function() {
                alert('Gagal memuat data profesi.');
            }
        });
    }

    onAssessmentChart = () => {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `{{ route('backoffice.dashboard.get-chart-assessment') }}`,
            method: 'post',
            data: {
                year_start: $('#filter_year_start').val(),
                year_end: $('#filter_year_end').val(),
                study_program: $('#filter_study_program').val(),
            },
            success: function(response) {
                const container = $('#chart-assessment');
                container.empty();

                response.data.forEach((item, index) => {
                    const chartId = `assessmentChart${index}`;

                    container.append(`
                        <div class="col-md-4">
                            <div class="card p-3">
                                <canvas id="${chartId}" height="200"></canvas>
                            </div>
                        </div>
                `);

                    const ctx = document.getElementById(chartId).getContext('2d');

                    const labels = item.data.map(d => d.label);
                    const values = item.data.map(d => d.percentage);

                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: item.question,
                                data: values,
                                backgroundColor: generateColors(labels.length),
                                borderColor: '#fff',
                                borderWidth: 1
                            }]
                        },
                        options: chartOptions(item.question)
                    });
                });
            },
            error: function() {
                alert('Gagal memuat data grafik penilaian.');
            }
        });
    }


    categoryProfessionChart = () => {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `{{ route('backoffice.dashboard.get-chart-company-type') }}`,
            method: 'post',
            data: {
                year_start: $('#filter_year_start').val(),
                year_end: $('#filter_year_end').val(),
                study_program: $('#filter_study_program').val(),
            },
            success: function(response) {
                const labels = response.data.map(item => item.label);
                const values = response.data.map(item => item.value);

                const ctx = document.getElementById('categoryProfessionChart').getContext('2d');

                if (companyTypeChart) companyTypeChart.destroy();

                companyTypeChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Sebaran Jenis Perusahaan',
                            data: values,
                            backgroundColor: generateColors(labels.length),
                            borderColor: '#fff',
                            borderWidth: 1
                        }]
                    },
                    options: chartOptions('Grafik Sebaran Jenis Perusahaan Lulusan ')
                });
            },
            error: function() {
                alert('Gagal memuat data kategori perusahaan.');
            }
        });
    }

    chartOptions = (title) => {
        return {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#333',
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed;
                            return `${label}: ${value} %`;
                        }
                    }
                },
                title: {
                    display: true,
                    text: title,
                    font: {
                        size: 16
                    }
                }
            }
        };
    }

    generateColors = (count) => {
        const pieChartColors = [
            '#FFB5A7', // soft coral pink
            '#FCD5CE', // light peach
            '#F8EDEB', // off white blush
            '#F9DCC4', // muted beige
            '#A2D2FF', // light sky blue
            '#BDE0FE', // pastel blue
            '#CDB4DB', // soft purple
            '#FFC8DD', // soft pink
            '#D8E2DC', // muted mint gray
            '#E2ECE9', // cool soft teal
            '#B5DAD8', // muted aqua
            '#E4C1F9', // soft lilac
            '#B5EAD7', // pastel green
            '#FFDAC1', // peach
            '#FFD6A5' // soft orange
        ];
        return pieChartColors.slice(0, count);
    }
</script>
