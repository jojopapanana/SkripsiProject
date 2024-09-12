<x-layout title="Arus Kas">
    <div class="d-flex justify-content-center" style="width: 70vw">
        <h1 class="fw-bold">LAPORAN ARUS KAS</h1>
    </div>
    
    <div class="d-flex justify-content-center gap-3 mt-3" style="width: 70vw">
        <div class="dropdown">
            <button class="btn dropdown-toggle fw-bold" type="button" id="monthDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
                BULAN
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
            <button class="btn dropdown-toggle fw-bold" type="button" id="yearDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
                TAHUN
            </button>
            <ul class="dropdown-menu" id="year-dropdown-menu" aria-labelledby="yearDropdownButton">
                <li><a class="dropdown-item" href="#" data-value="2022">2022</a></li>
                <li><a class="dropdown-item" href="#" data-value="2023">2023</a></li>
                <li><a class="dropdown-item" href="#" data-value="2024">2024</a></li>
            </ul>
        </div>
    </div>


    <div class="aruskas-container">
        <p class="fw-bold">Arus Kas Operasional</p>
        <div class="d-flex justify-content-between">
            <p>Penerimaan kas penjualan</p>
            @foreach ($pendapatan_operasional as $p)
                <p class="fw-bold" style="color: rgba(13, 190, 0, 1)">Rp. {{ number_format($p->totalPerMonth, 0, ',', '.') }}</p>
            @endforeach
        </div>

        <div class="d-flex justify-content-between" style="border-bottom: 1px solid black; border-bottom-color: black">
            <p>Biaya operasional usaha</p>
            @foreach ($pengeluaran_operasional as $p)
                <p class="fw-bold" style="color: rgba(255, 0, 0, 1)">(Rp. {{ number_format($p->totalPerMonth, 0, ',', '.') }})</p>
            @endforeach
        </div>

        <div class="d-flex justify-content-between">
            <p class="fw-bold">Total Arus Kas Operasional</p>
            <p class="fw-bold">Rp. {{ number_format($total_arus_kas_operasional, 0, ',', '.') }}</p>
        </div>

        <br><br><br>


        <p class="fw-bold">Arus Kas Investasi</p>
        <div class="d-flex justify-content-between">
            <p>Penerimaan kas investasi</p>
            @foreach ($pendapatan_investasi as $p)
                <p class="fw-bold" style="color: rgba(13, 190, 0, 1)">Rp. {{ number_format($p->totalPerMonth, 0, ',', '.') }}</p>
            @endforeach
        </div>

        <div class="d-flex justify-content-between" style="border-bottom: 1px solid black; border-bottom-color: black">
            <p>Biaya investasi usaha</p>
            @foreach ($pengeluaran_investasi as $p)
                <p class="fw-bold" style="color: rgba(255, 0, 0, 1)">(Rp. {{ number_format($p->totalPerMonth, 0, ',', '.') }})</p>
            @endforeach
        </div>

        <div class="d-flex justify-content-between">
            <p class="fw-bold">Total Arus Kas Investasi</p>
            <p class="fw-bold">Rp. {{ number_format($total_arus_kas_investasi, 0, ',', '.') }}</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const monthDropdownButton = document.getElementById('monthDropdownButton');
            const monthDropdownItems = document.querySelectorAll('#month-dropdown-menu .dropdown-item');
            const yearDropdownButton = document.getElementById('yearDropdownButton');
            const yearDropdownItems = document.querySelectorAll('#year-dropdown-menu .dropdown-item');

            monthDropdownItems.forEach(function(item) {
                item.addEventListener('click', function(event) {
                    event.preventDefault();
                    const selectedMonthText = this.textContent;
                    const selectedMonthValue = this.getAttribute('data-value');
                    
                    monthDropdownButton.textContent = selectedMonthText;
                    
                    window.location.href = `{{ route('aruskas') }}?month=${selectedMonthValue}`;
                });
            });

            yearDropdownItems.forEach(function(item) {
                item.addEventListener('click', function(event) {
                    event.preventDefault();
                    const selectedYearText = this.textContent;
                    const selectedYearValue = this.getAttribute('data-value');
                    
                    yearDropdownButton.textContent = selectedYearText;
                    
                    // window.location.href = `{{ route('aruskas') }}?month=${selectedMonthValue}`;
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
        });
    </script>
</x-layout>