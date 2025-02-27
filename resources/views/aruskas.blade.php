<x-layout title="Arus Kas">
    <h1 class="fw-bold text-center responsive-margin-end" style="font-size: 2.5rem">LAPORAN ARUS KAS</h1>
    <h1 class="width-adjust"></h1>

    @php
        \Carbon\Carbon::setLocale('id');
    @endphp
    
    <div class="d-flex justify-content-center gap-3 mt-3 responsive-margin-end">
        <div class="dropdown">
            <button class="btn dropdown-toggle fw-semibold fs-5" type="button" style="min-width: 160px" id="monthDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
                {{ strtoupper(\Carbon\Carbon::now()->translatedFormat('F')) }}
            </button>
            <ul class="dropdown-menu w-100" id="month-dropdown-menu" aria-labelledby="monthDropdownButton">
                <li><a class="dropdown-item" href="#" data-value="1">JANUARI</a></li>
                <li><a class="dropdown-item" href="#" data-value="2">FEBRUARI</a></li>
                <li><a class="dropdown-item" href="#" data-value="3">MARET</a></li>
                <li><a class="dropdown-item" href="#" data-value="4">APRIL</a></li>
                <li><a class="dropdown-item" href="#" data-value="5">MEI</a></li>
                <li><a class="dropdown-item" href="#" data-value="6">JUNI</a></li>
                <li><a class="dropdown-item" href="#" data-value="7">JULI</a></li>
                <li><a class="dropdown-item" href="#" data-value="8">AGUSTUS</a></li>
                <li><a class="dropdown-item" href="#" data-value="9">SEPTEMBER</a></li>
                <li><a class="dropdown-item" href="#" data-value="10">OKTOBER</a></li>
                <li><a class="dropdown-item" href="#" data-value="11">NOVEMBER</a></li>
                <li><a class="dropdown-item" href="#" data-value="12">DESEMBER</a></li>
            </ul>
        </div>
    
        <div class="dropdown">
            <button class="btn dropdown-toggle fw-semibold fs-5" type="button" style="min-width: 160px" id="yearDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
              {{ now()->year }}
            </button>
            <ul class="dropdown-menu w-100" id="year-dropdown-menu" aria-labelledby="yearDropdownButton">
                <li><a class="dropdown-item" href="#" data-value="2022">2022</a></li>
                <li><a class="dropdown-item" href="#" data-value="2023">2023</a></li>
                <li><a class="dropdown-item" href="#" data-value="2024">2024</a></li>
                <li><a class="dropdown-item" href="#" data-value="2025">2025</a></li>
            </ul>
        </div>
    </div>

    <div class="card mt-5 responsive-margin-end" style="min-width: 750px">
        <div class="card-body">
            <h6 class="fw-bold">Arus Kas Operasional</h6>
            <div class="row" style="margin-bottom: -5px;">
                <div class="col">
                        <div class="justify-content-start">
                            <h3 class="text-start fs-6 fw-normal mt-2">Penerimaan Kas Penjualan</h3>
                        </div>
                </div>
                <div class="col">
                    @foreach ($pendapatan_operasional as $p)
                    <div class="justify-content-end">
                        <h3 class="text-end fs-6 fw-bold" style="color: rgba(13, 190, 0, 1)">Rp. {{ number_format($p->totalPerMonth, 0, ',', '.') }}</h3>
                    </div>
                    @endforeach
                </div>
            </div>

            @foreach ($semua_pengeluaran_operasional as $p)
            <div class="row" style="margin-bottom: -5px;">
                <div class="col">
                        <div class="justify-content-start">
                            <h3 class="text-start fs-6 fw-normal mt-2">{{ $p->deskripsi }}</h3>
                        </div>
                </div>
                <div class="col">
                    <div class="justify-content-end">
                        <h3 class="text-end fs-6 fw-bold" style="color: red">(Rp. {{ number_format($p->nominal, 0, ',', '.') }})</h3>
                    </div>
                </div>
            </div>
            @endforeach

            <hr class="my-2">

            <div class="row">
                <div class="col">
                    <div class="justify-content-start">
                        <h5 class="text-start fs-6 fw-bold">Total Arus Kas Operasional</h4>
                    </div>
                </div>
                <div class="col">
                    <div class="justify-content-end">
                        <h3 class="text-end fs-6 fw-bold">Rp. {{ number_format($total_arus_kas_operasional, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>

            <br>

            <h6 class="fw-bold mt-2">Arus Kas Investasi</h6>
            <div class="row">
                <div class="col">
                    <div class="justify-content-start" style="margin-bottom: -5px;">
                        <h3 class="text-start fs-6 fw-normal mt-2">Biaya Investasi Usaha</h3>
                    </div>
                </div>
                <div class="col">
                    @foreach ($pengeluaran_investasi as $p)
                        <div class="justify-content-end">
                            <h3 class="text-end fs-6 fw-bold" style="color: red">(Rp. {{ number_format($p->totalPerMonth, 0, ',', '.') }})</h3>
                        </div>
                    @endforeach
                </div>
            </div>

            <hr class="my-2">

            <div class="row">
                <div class="col">
                    <div class="justify-content-start">
                        <h5 class="text-start fs-6 fw-bold">Total Arus Kas Investasi</h4>
                    </div>
                </div>

                <div class="col">
                    <div class="justify-content-end">
                        <h3 class="text-end fs-6 fw-bold">Rp. {{ number_format($total_pengeluaran_investasi, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>

            <br>

            <div class="row mt-2">
                <div class="col">
                    <div class="justify-content-start">
                        <h5 class="text-start fs-6 fw-bold">Kenaikan/Penurunan Kas</h4>
                    </div>
                </div>

                <div class="col">
                    @if($status == 'Untung')
                        <div class="justify-content-end">
                            <h3 class="text-end fs-6 fw-bold" style="color: rgba(13, 190, 0, 1)">Rp. {{ number_format($kenaikan_arus_kas, 0, ',', '.') }}</h3>
                        </div>
                    @elseif($status == 'Rugi')
                        <div class="justify-content-end">
                            <h3 class="text-end fs-6 fw-bold" style="color: red">Rp. {{ number_format($kenaikan_arus_kas, 0, ',', '.') }}</h3>
                        </div>
                    @else
                        <div class="justify-content-end">
                            <h3 class="text-end fs-6 fw-bold">Rp. 0</h3>
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="justify-content-start">
                        <h5 class="text-start fs-6 fw-bold">Saldo Kas Awal</h4>
                    </div>
                </div>
                
                <div class="col">
                    <div class="justify-content-end">
                        <h3 class="text-end fs-6 fw-bold">Rp. {{ number_format($saldo_awal_kas, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="justify-content-start">
                        <h5 class="text-start fs-6 fw-bold">Saldo Kas Akhir</h4>
                    </div>
                </div>
                
                <div class="col">
                    <div class="justify-content-end">
                        <h3 class="text-end fs-6 fw-bold">Rp. {{ number_format($saldo_akhir_kas, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($pendapatan_operasional->count() != 0 || $pengeluaran_operasional->count() != 0 || $pengeluaran_investasi->count() != 0)
      <div class="d-flex justify-content-end mt-5 mb-5 responsive-margin-end">
          <button class="btn fw-semibold" type="button" id="exportButton">
            Ekspor
          </button>
      </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const monthDropdownButton = document.getElementById('monthDropdownButton');
            const monthDropdownItems = document.querySelectorAll('#month-dropdown-menu .dropdown-item');
            const yearDropdownButton = document.getElementById('yearDropdownButton');
            const yearDropdownItems = document.querySelectorAll('#year-dropdown-menu .dropdown-item');

            let selectedMonthValue = new URLSearchParams(window.location.search).get('month') || (new Date().getMonth() + 1);
            let selectedYearValue = new URLSearchParams(window.location.search).get('year') || new Date().getFullYear();

            function updateUrl() {
                window.location.href = `{{ route('aruskas') }}?month=${selectedMonthValue}&year=${selectedYearValue}`;
            }

            monthDropdownItems.forEach(function(item) {
                item.addEventListener('click', function(event) {
                    event.preventDefault();
                    const selectedMonthText = this.textContent;
                    selectedMonthValue = this.getAttribute('data-value');
                    
                    monthDropdownButton.textContent = selectedMonthText;
                    updateUrl();
                });
            });

            yearDropdownItems.forEach(function(item) {
                item.addEventListener('click', function(event) {
                    event.preventDefault();
                    const selectedYearText = this.textContent;
                    selectedYearValue = this.getAttribute('data-value');
                    
                    yearDropdownButton.textContent = selectedYearText;
                    updateUrl();
                });
            });

            const urlParams = new URLSearchParams(window.location.search);
            const month = urlParams.get('month');
            if (month) {
                const selectedItem = [...monthDropdownItems].find(item => item.getAttribute('data-value') === month);
                if (selectedItem) {
                    monthDropdownButton.textContent = selectedItem.textContent;
                }
            }

            const year = urlParams.get('year');
            if (year) {
                const selectedItem = [...yearDropdownItems].find(item => item.getAttribute('data-value') === year);
                if (selectedItem) {
                    yearDropdownButton.textContent = selectedItem.textContent;
                }
            }

            function exportUrl() {
                const exportRoute = `{{ route('aruskas_export') }}?month=${selectedMonthValue}&year=${selectedYearValue}`;

                window.location.href = exportRoute;
            }

            const exportButton = document.getElementById('exportButton');
            exportButton.addEventListener('click', function(event) {
                event.preventDefault();
                exportUrl();
            });
        });

    </script>
</x-layout>