<script>
    let professionChart;
    let companyTypeChart;

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

        onChartProfession();
        categoryProfessionChart();
        onFetchTableProfession();
        onFetchTableWaitingTime();
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

        onChartProfession();
        categoryProfessionChart();
        onFetchTableProfession();
        onFetchTableWaitingTime();
    }

    onResetFilter = () => {
        $('#filter_year_start').val('').trigger('change');
        $('#filter_year_end').val('').trigger('change');
        $('#filter_study_program').val('').trigger('change');
        onChartProfession();
        categoryProfessionChart();
        onFetchTableProfession();
        onFetchTableWaitingTime();
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
        const colors = [
            '#FF6384', '#36A2EB', '#FFCE56',
            '#4BC0C0', '#9966FF', '#FF9F40',
            '#8BC34A', '#FF5722', '#795548',
            '#607D8B', '#BDBDBD', '#009688',
            '#3F51B5', '#E91E63', '#CDDC39'
        ];
        return colors.slice(0, count);
    }
</script>
