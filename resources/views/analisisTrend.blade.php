<x-layout title="Analisis Tren">
    <h1 class="fw-bold text-center responsive-margin-end" style="font-size: 2.5rem">ANALISIS TREN</h1>
    <h1 class="width-adjust"></h1>

    <div class="dashboard-trenkeuntungan width-adjust responsive-margin-end" style="margin-top: 3.5rem">
        <h3 class="fw-bold text-center" style="font-size: 25px; margin-bottom: 20px;">Pendapatan dan Pengeluaran Selama 6 Bulan Terakhir!</h3>
        @if($data->isNotEmpty())
            <canvas id="myChart" style="width: 60vw; height: 30vh"></canvas>
        @else
            <div class="card mt-3">
                <div class="card-body py-2 m-3">
                    <center>
                        <div class="mb-1" style="margin-top: 13.5px"><img src="/assets/bar-graph.png" alt="BAR-GRAPH" style="width:150px"></div>
                        <p class="fw-semibold mb-2" style="font-size: 25px; padding-bottom: 13.5px">Belum ada data analisis nih!</p>
                    </center>
                </div>
            </div>
        @endif
    </div>

    <div class="dashboard-trenkeuntungan mt-5">
        <h3 class="fw-bold text-center" style="font-size: 25px; margin-bottom: 20px;">Pendapatan dan Pengeluaran Selama 7 Hari Terakhir!</h3>
        @if($data->isNotEmpty())
            <canvas id="dailyChart" style="width: 60vw; height: 30vh"></canvas>
        @else
            <div class="card mt-3">
                <div class="card-body py-2 m-3">
                    <center>
                        <div class="mb-1" style="margin-top: 13.5px"><img src="/assets/bar-graph.png" alt="BAR-GRAPH" style="width:150px"></div>
                        <p class="fw-semibold mb-2" style="font-size: 25px; padding-bottom: 13.5px">Belum ada data analisis nih!</p>
                    </center>
                </div>
            </div>
        @endif
    </div>

    <div class="analisis-stok mt-5">
        <h2 class="fw-bold text-center responsive-margin-end" style="font-size: 2rem">Laporan Penjualan Stok Barangmu!</h2>
        <div class="d-flex gap-3 mt-3 mb-5 justify-content-center responsive-margin-end">
            <div class="dropdown">
                <button class="btn dropdown-toggle fw-semibold fs-5" style="min-width: 160px" type="button" id="timeRangeButton" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ ucfirst($rangeWaktu) }}
                </button>
                <ul class="dropdown-menu w-100" id="time-range-items" aria-labelledby="timeRangeButton">
                    <li><a class="dropdown-item" data-value="mingguan" href="{{ route('analisisTrend', ['rangeWaktu' => 'mingguan']) }}">Mingguan</a></li>
                    <li><a class="dropdown-item" data-value="bulanan" href="{{ route('analisisTrend', ['rangeWaktu' => 'bulanan']) }}">Bulanan</a></li>
                    <li><a class="dropdown-item" data-value="tahunan" href="{{ route('analisisTrend', ['rangeWaktu' => 'tahunan']) }}">Tahunan</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="analisis-stok-content responsive-margin-end">
        @include('components.analisisStokForTrend', [
            'produkTerbanyak' => $produkTerbanyak,
            'produkTerdikit' => $produkTerdikit,
            'rangeWaktu' => $rangeWaktu
        ])
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="module">
        const data = {
            labels: @json($data->map(fn ($data) => \Carbon\Carbon::parse($data->month)->translatedFormat('F'))), 
            datasets: [
                {
                    label: 'Pendapatan',
                    backgroundColor: 'rgb(0, 0, 255)',
                    data: @json($data->map(fn ($data) => $data->pendapatan)),
                },
                {
                    label: 'Pengeluaran',
                    backgroundColor: 'rgb(255, 0, 0)',
                    data: @json($data->map(fn ($data) => $data->pengeluaran)),
                },
                {
                    label: 'Untung/Rugi',
                    backgroundColor: 'rgb(128, 128, 128)',
                    data: @json($data->map(fn ($data) => $data->total)),
                }
            ]
        };

        const config = {
            type: 'bar', 
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    }
                }
            }
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    </script>

    <script type="module">
        const dailyData = {
            labels: @json($dailyData->map(fn ($data) => $data->date)), 
            datasets: [
                {
                    label: 'Pendapatan',
                    backgroundColor: 'rgb(0, 0, 255)',
                    data: @json($dailyData->map(fn ($data) => $data->pendapatan)), 
                },
                {
                    label: 'Pengeluaran',
                    backgroundColor: 'rgb(255, 0, 0)', 
                    data: @json($dailyData->map(fn ($data) => $data->pengeluaran)), 
                },
                {
                    label: 'Untung/Rugi',
                    backgroundColor: 'rgb(128, 128, 128)',
                    data: @json($dailyData->map(fn ($data) => $data->total)),
                }
            ]
        };

        const dailyConfig = {
            type: 'bar', 
            data: dailyData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true 
                    }
                }
            }
        };

        const myDailyChart = new Chart(
            document.getElementById('dailyChart'),
            dailyConfig
        );
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const timeRangeButton = document.getElementById('timeRangeButton');
            const timeRangeItems = document.querySelectorAll('#time-range-items .dropdown-item');
            const dataContainer = document.querySelector('.analisis-stok-content'); // Adjust to the specific container you want to update

            timeRangeItems.forEach(function (item) {
                item.addEventListener('click', function (event) {
                    event.preventDefault();

                    const selectedTimeRange = this.getAttribute('data-value');
                    const selectedTimeRangeText = this.textContent;

                    // Update button text
                    timeRangeButton.textContent = selectedTimeRangeText;

                    // Fetch data asynchronously
                    fetch(`{{ route('analisisTrend') }}?rangeWaktu=${selectedTimeRange}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest' // Optional: To identify an AJAX request
                        }
                    })
                        .then((response) => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.text(); // Assume the server returns HTML
                        })
                        .then((html) => {
                            // Update the specific container with the new HTML
                            dataContainer.innerHTML = html;
                        })
                        .catch((error) => {
                            console.error('There was a problem with the fetch operation:', error);
                        });
                });
            });
        });
    </script>
</x-layout>
