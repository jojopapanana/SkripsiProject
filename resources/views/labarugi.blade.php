<x-layout title="Laba Rugi">
    <div class="d-flex justify-content-center" style="width: 70vw">
        <h1 class="fw-bold">LAPORAN LABA RUGI</h1>
    </div>
    <div class="d-flex justify-content-center gap-3 mt-2" style="width: 70vw">
        <div class="dropdown">
            <button class="btn dropdown-toggle fw-semibold fs-5" type="button" id="monthDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
                {{ strtoupper(\Carbon\Carbon::now()->translatedFormat('F')) }}
            </button>
            <ul class="dropdown-menu" id="month-dropdown-menu" aria-labelledby="monthDropdownButton">
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
            <button class="btn dropdown-toggle fw-semibold fs-5" type="button" id="yearDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
              {{ now()->year }}
            </button>
            <ul class="dropdown-menu" id="year-dropdown-menu" aria-labelledby="yearDropdownButton">
                <li><a class="dropdown-item" href="#" data-value="2022">2022</a></li>
                <li><a class="dropdown-item" href="#" data-value="2023">2023</a></li>
                <li><a class="dropdown-item" href="#" data-value="2024">2024</a></li>
            </ul>
        </div>
    </div>

    <div class="card mt-5">
        <div class="card-body">
            <h6 class="fw-bold">Pemasukan</h6>
            <div class="row" style="margin-bottom: -5px;">
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
                            <h3 class="text-end fs-6 fw-bold" style="color: rgba(13, 190, 0, 1)">Rp. {{ number_format($profits->totalNominal, 0, ',', '.') }}</h3>
                        </div>
                    @endforeach
                </div>
            </div>

            <hr class="my-2">

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

            <h6 class="fw-bold mt-2">Pengeluaran</h6>
            <div class="row" style="margin-bottom: -5px;">
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
                            <h3 class="text-end fs-6 fw-bold" style="color: red">(Rp. {{ number_format($loss->nominal, 0, ',', '.') }})</h3>
                        </div>
                    @endforeach
                </div>
            </div>

            <hr class="my-2">

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

            <div class="row mt-2">
                <div class="col">
                    <div class="justify-content-start">
                        <h5 class="text-start fs-6 fw-bold">Total Laba/Rugi</h4>
                    </div>
                </div>
                <div class="col">
                    @if($status == 'Untung')
                        <div class="justify-content-end">
                            <h3 class="text-end fs-6 fw-bold" style="color: rgba(13, 190, 0, 1)">Rp. {{ number_format($balance, 0, ',', '.') }}</h3>
                        </div>
                    @elseif($status == 'Rugi')
                        <div class="justify-content-end">
                            <h3 class="text-end fs-6 fw-bold" style="color: red">Rp. {{ number_format($balance, 0, ',', '.') }}</h3>
                        </div>
                    @else
                        <div class="justify-content-end">
                            <h3 class="text-end fs-6 fw-bold">Rp. 0</h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if ($laba->count() != 0 || $rugi->count() != 0)
        <div class="d-flex justify-content-end mt-5">
            <button class="btn fw-semibold" type="button" id="exportLabaRugiButton">
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
                    window.location.href = `{{ route('labarugi') }}?month=${selectedMonthValue}&year=${selectedYearValue}`;
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
                    const exportRoute = `{{ route('labarugi_export') }}?month=${selectedMonthValue}&year=${selectedYearValue}`;

                    window.location.href = exportRoute;
                }

                const exportButton = document.getElementById('exportLabaRugiButton');
                exportButton.addEventListener('click', function(event) {
                    event.preventDefault();
                    exportUrl();
                });
            });
        </script>
    </div>
</x-layout>
