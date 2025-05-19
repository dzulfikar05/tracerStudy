<script>
    let professionChart;
    let companyTypeChart;

    $(() => {
        onChartProfession();
        categoryProfessionChart();
    });

    function onChartProfession() {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `{{ route('backoffice.dashboard.get-chart-profession') }}`,
            method: 'post',
            success: function (response) {
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
            error: function () {
                alert('Gagal memuat data profesi.');
            }
        });
    }

    function categoryProfessionChart() {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `{{ route('backoffice.dashboard.get-chart-company-type') }}`,
            method: 'post',
            success: function (response) {
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
            error: function () {
                alert('Gagal memuat data kategori perusahaan.');
            }
        });
    }

    function chartOptions(title) {
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
                        label: function (context) {
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

    function generateColors(count) {
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
