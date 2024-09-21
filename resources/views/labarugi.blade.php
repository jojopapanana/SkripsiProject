<x-layout title="Transaksi">
    <div class="d-flex justify-content-center" style="width: 70vw">
        <h1 class="fw-bold">LAPORAN LABA RUGI</h1>
    </div>
    <div class="d-flex justify-content-center gap-3 mt-3" style="width: 70vw">
        <div class="dropdown">
            <select id="month" class="form-select px-5 py-2 fs-5 fw-bold" style="border: 1.5px solid rgba(30, 3, 66, 1); border-radius: 10px; background-color: white;">
                <option value="">BULAN</option>
                <option value="1" {{ $month == 1 ? 'selected' : '' }}>Januari</option>
                <option value="2" {{ $month == 2 ? 'selected' : '' }}>Februari</option>
                <option value="3" {{ $month == 3 ? 'selected' : '' }}>Maret</option>
                <option value="4" {{ $month == 4 ? 'selected' : '' }}>April</option>
                <option value="5" {{ $month == 5 ? 'selected' : '' }}>Mei</option>
                <option value="6" {{ $month == 6 ? 'selected' : '' }}>Juni</option>
                <option value="7" {{ $month == 7 ? 'selected' : '' }}>Juli</option>
                <option value="8" {{ $month == 8 ? 'selected' : '' }}>Agustus</option>
                <option value="9" {{ $month == 9 ? 'selected' : '' }}>September</option>
                <option value="10" {{ $month == 10 ? 'selected' : '' }}>Oktober</option>
                <option value="11" {{ $month == 11 ? 'selected' : '' }}>November</option>
                <option value="12" {{ $month == 12 ? 'selected' : '' }}>Desember</option>
            </select>
        </div>
        <div class="dropdown">
            <select id="year" class="form-select px-5 py-2 fs-5 fw-bold" style="border: 1.5px solid rgba(30, 3, 66, 1); border-radius: 10px; background-color: white;">
                <option value="">TAHUN</option>
                <option value="2024" {{ $year == 2024 ? 'selected' : '' }}>2024</option>
                <option value="2025" {{ $year == 2025 ? 'selected' : '' }}>2025</option>
                <option value="2026" {{ $year == 2026 ? 'selected' : '' }}>2026</option>
            </select>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h6 class="fw-bold">Pemasukan</h6>
            <div class="row">
                <div class="col">
                    @forEach($laba as $profits)
                        <div class="justify-content-start">
                            <h3 class="text-start fs-6 fw-normal mt-2">{{ $profits->description }}</h3>
                        </div>
                    @endforeach
                </div>
                <div class="col">
                    @forEach($laba as $profits)
                            <div class="justify-content-end">
                            <h3 class="text-end fs-6 fw-bold text-success">Rp. {{ number_format($profits->nominal, 0, ',', '.') }}</h3>
                        </div>
                    @endforeach
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <div class="justify-content-start">
                        <h5 class="text-start fs-6 fw-bold">Total Pemasukan</h4>
                    </div>
                </div>
                <div class="col">
                    <div class="justify-content-end">
                        <h3 class="text-end fs-6 fw-bold">Rp. {{ number_format($total_laba, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <br>
            <h6 class="fw-bold">Pengeluaran</h6>
            <div class="row">
                <div class="col">
                    @forEach($rugi as $loss)
                        <div class="justify-content-start">
                            <h3 class="text-start fs-6 fw-normal mt-2">{{ $loss->description }}</h3>
                        </div>
                    @endforeach
                </div>
                <div class="col">
                    @forEach($rugi as $loss)
                            <div class="justify-content-end">
                            <h3 class="text-end fs-6 fw-bold text-danger">- Rp. {{ number_format($loss->nominal, 0, ',', '.') }}</h3>
                        </div>
                    @endforeach
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <div class="justify-content-start">
                        <h5 class="text-start fs-6 fw-bold">Total Pengeluaran</h4>
                    </div>
                </div>
                <div class="col">
                    <div class="justify-content-end">
                        <h3 class="text-end fs-6 fw-bold">Rp. {{ number_format($total_rugi, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="justify-content-start">
                        <h5 class="text-start fs-6 fw-bold">Total Laba/Rugi</h4>
                    </div>
                </div>
                <div class="col">
                    @if($status == 'Untung')
                        <div class="justify-content-end">
                            <h3 class="text-end fs-6 fw-bold text-success">Rp. {{ number_format($balance, 0, ',', '.') }}</h3>
                        </div>
                    @elseif($status == 'Rugi')
                        <div class="justify-content-end">
                            <h3 class="text-end fs-6 fw-bold text-danger">- Rp. {{ number_format($balance, 0, ',', '.') }}</h3>
                        </div>
                    @else
                        <div class="justify-content-end">
                            <h3 class="text-end fs-6 fw-bold text-success">Rp. 0</h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <script>
            document.getElementById('month').addEventListener('change', function() {
                var month = this.value;
                var year = document.getElementById('year').value;
                if (month && year) {
                    window.location.href = `?month=${month}&year=${year}`;
                }
            });

            document.getElementById('year').addEventListener('change', function() {
                var year = this.value;
                var month = document.getElementById('month').value;
                if (month && year) {
                    window.location.href = `?month=${month}&year=${year}`;
                }
            });
        </script>
    </div>
</x-layout>