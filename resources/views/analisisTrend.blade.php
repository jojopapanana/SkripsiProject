<x-layout title="Analisis Trend">
    <h1 class="fw-bold">Analisis Tren</h1>

    <div class="dashboard-trenkeuntungan">
        <h3 class="fw-bold text-center">Pendapatan dan Pengeluaran Selama 6 Bulan Terakhir!</h3>
        <canvas id="myChart" style="width: 70vw; height: 40vh"></canvas>
    </div>

    <div class="dashboard-trenkeuntungan">
        <h3 class="fw-bold text-center">Pendapatan dan Pengeluaran Selama 7 Hari Terakhir!</h3>
        <canvas id="dailyChart" style="width: 70vw; height: 40vh"></canvas>
    </div>

    <div class="analisis-stok mt-5">
        <h3 class="fw-bold text-center">Laporan Penjualan Stok</h3>
        <div class="d-flex justify-content-center gap-3 mt-3 mb-3">
        <div class="dropdown">
            <button class="btn dropdown-toggle fw-semibold fs-5" type="button" id="timeRangeButton" data-bs-toggle="dropdown" aria-expanded="false">Pilih Waktu</button>
            <ul class="dropdown-menu" id="time-range-items" aria-labelledby="timeRangeButton">
                <li><a class="dropdown-item" data-value="bulanan" href="{{ route('analisisTrend', ['rangeWaktu' => 'bulanan']) }}">Bulanan</a></li>
                <li><a class="dropdown-item" data-value="mingguan" href="{{ route('analisisTrend', ['rangeWaktu' => 'mingguan']) }}">Mingguan</a></li>
                <li><a class="dropdown-item" data-value="tahunan" href="{{ route('analisisTrend', ['rangeWaktu' => 'tahunan']) }}">Tahunan</a></li>
            </ul>
        </div>
    </div>

    @if($produkTerbanyak->isNotEmpty())
        <h3 class="fw-bold text-center">Laporan Penjualan Stok Terbanyak</h3>
        <div class="card mt-3">
            <div class="card-body py-2">
                <table class="w-100">
                    <thead>
                        <tr>
                            <th class="text-start" style="width: 20%;">Periode</th>
                            <th class="text-start" style="width: 30%;">Nama Produk</th>
                            <th class="text-start" style="width: 25%;">Jumlah Terjual</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        @foreach($produkTerbanyak as $product)
            <div class="card mt-3">
                <div class="card-body py-2">
                    <table class="w-100">
                        <tbody>
                            <tr>
                                <td class="text-start" style="width: 20%;">
                                    @if($rangeWaktu == 'bulanan')
                                        {{ date('F', mktime(0, 0, 0, $product->bulan)) }}
                                    @elseif($rangeWaktu == 'mingguan')
                                        Minggu ke-{{ $product->minggu }}
                                    @elseif($rangeWaktu == 'tahunan')
                                        {{ $product->tahun }}
                                    @endif
                                </td>
                                <td class="text-start" style="width: 30%;">{{ $product->productName }}</td>
                                <td class="text-start" style="width: 25%;">{{ $product->total_terjual }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @else
        <p>Ups, belum ada penjualan!</p>
    @endif
    <br>

    @if($produkTerdikit->isNotEmpty())
        <h3 class="fw-bold text-center">Laporan Penjualan Stok Terdikit</h3>
        <div class="card mt-3">
            <div class="card-body py-2">
                <table class="w-100">
                    <thead>
                        <tr>
                            <th class="text-start" style="width: 20%;">Periode</th>
                            <th class="text-start" style="width: 30%;">Nama Produk</th>
                            <th class="text-start" style="width: 25%;">Jumlah Terjual</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        @foreach($produkTerdikit as $product)
            <div class="card mt-3">
                <div class="card-body py-2">
                    <table class="w-100">
                        <tbody>
                            <tr>
                                <td class="text-start" style="width: 20%;">
                                    @if($rangeWaktu == 'bulanan')
                                        {{ date('F', mktime(0, 0, 0, $product->bulan)) }}
                                    @elseif($rangeWaktu == 'mingguan')
                                        Minggu ke-{{ $product->minggu }}
                                    @elseif($rangeWaktu == 'tahunan')
                                        {{ $product->tahun }}
                                    @endif
                                </td>
                                <td class="text-start" style="width: 30%;">{{ $product->productName }}</td>
                                <td class="text-start" style="width: 25%;">{{ $product->total_terjual }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @else
        <p>Ups, belum ada penjualan!</p>
    @endif
    <br>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="module">
        const data = {
            labels: @json($data->map(fn ($data) => date('F', strtotime($data->month)))), 
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
        document.addEventListener('DOMContentLoaded', function() {
            const timeRangeButton = document.getElementById('timeRangeButton');
            const timeRangeItems = document.querySelectorAll('#time-range-items .dropdown-item');

            let selectedTimeRange = 'bulanan';

            timeRangeItems.forEach(function(item) {
                item.addEventListener('click', function(event) {
                    event.preventDefault();
                    const selectedTimeRangeText = this.textContent;
                    selectedTimeRange = this.getAttribute('data-value');
                    
                    timeRangeButton.textContent = selectedTimeRangeText;
                    window.location.href = `{{ route('analisisTrend') }}?rangeWaktu=${selectedTimeRange}`;
                });
            });

            const urlParams = new URLSearchParams(window.location.search);
            const rangeWaktu = urlParams.get('rangeWaktu');
            if (rangeWaktu) {
                const selectedItem = [...timeRangeItems].find(item => item.getAttribute('data-value') === rangeWaktu);
                if (selectedItem) {
                    timeRangeButton.textContent = selectedItem.textContent;
                }
            }
        });
    </script>
</x-layout>
