<x-layout title="Arus Kas">
    <div class="d-flex justify-content-center" style="width: 70vw">
        <h1 class="fw-bold">LAPORAN ARUS KAS</h1>
    </div>
    
    <div class="d-flex justify-content-center gap-3 mt-3" style="width: 70vw">
        <div class="dropdown">
            <select id="month-dropdown" name="month" class="form-select">
                <option class="dropdown-item-month" value=0>BULAN</option>
                <option class="dropdown-item-month" value=1>JANUARI</option>
                <option class="dropdown-item-month" value=2>FEBRUARI</option>
                <option class="dropdown-item-month" value=3>MARET</option>
                <option class="dropdown-item-month" value=4>APRIL</option>
                <option class="dropdown-item-month" value=5>MEI</option>
                <option class="dropdown-item-month" value=6>JUNI</option>
                <option class="dropdown-item-month" value=7>JULI</option>
                <option class="dropdown-item-month" value=8>AGUSTUS</option>
                <option class="dropdown-item-month" value=9>SEPTEMBER</option>
                <option class="dropdown-item-month" value=10>OKTOBER</option>
                <option class="dropdown-item-month" value=11>NOVEMBER</option>
                <option class="dropdown-item-month" value=12>DESEMBER</option>
              </select>
        </div>
    
        <div class="dropdown" id="dropdown-tahun-transaksi">
            <button class="dropdown-toggle p-2 fs-5 fw-bold" type="button" data-bs-toggle="dropdown" aria-expanded="true" style="border: 2px solid rgba(30, 3, 66, 1); border-radius: 10px; background-color: white;">
              2024
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">2022</a></li>
              <li><a class="dropdown-item" href="#">2023</a></li>
              <li><a class="dropdown-item" href="#">2024</a></li>
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
            const monthDropdown = document.getElementById('month-dropdown');
            
            monthDropdown.addEventListener('change', function() {
                // Get the text of the selected option
                const selectedOptionText = this.options[this.selectedIndex].text;
                
                // Change the text displayed on the dropdown button (if any)
                const dropdownToggle = document.querySelector('.dropdown-toggle');
                if (dropdownToggle) {
                    dropdownToggle.textContent = selectedOptionText;
                }

                // Optionally, navigate to another page with the selected month
                const selectedMonthValue = this.value;
                window.location.href = `{{ route('aruskas') }}?month=${selectedMonthValue}`;
            });
        });

        // document.getElementById('month-dropdown').addEventListener('change', function() {
        //     const months = ['JANUARI', 'FEBRUARI', 'MARET'];
        //     const selectedMonth = this.value;
            
        //     window.location.href = `{{ route('aruskas') }}?month=${selectedMonth}`;
        // });
    </script>
</x-layout>