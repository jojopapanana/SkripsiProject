<x-layout title="Arus Kas">
    <div class="d-flex justify-content-center" style="width: 70vw">
        <h1 class="fw-bold">LAPORAN ARUS KAS</h1>
    </div>
    
    <div class="d-flex justify-content-center gap-3 mt-3" style="width: 70vw">
        <div class="dropdown">
            <button class="dropdown-toggle fs-5 p-2 fw-bold" id="dropdown-bulan-transaksi" data-bs-toggle="dropdown" aria-expanded="true" style="border: 2px solid rgba(30, 3, 66, 1); border-radius: 10px; background-color: white;">
              BULAN
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdown-bulan-transaksi">
              <li><a class="dropdown-item" href="#">JANUARI</a></li>
              <li><a class="dropdown-item" href="#">FEBRUARI</a></li>
              <li><a class="dropdown-item" href="#">MARET</a></li>
              <li><a class="dropdown-item" href="#">APRIL</a></li>
              <li><a class="dropdown-item" href="#">MEI</a></li>
              <li><a class="dropdown-item" href="#">JUNI</a></li>
              <li><a class="dropdown-item" href="#">JULI</a></li>
              <li><a class="dropdown-item" href="#">AGUSTUS</a></li>
              <li><a class="dropdown-item" href="#">SEPTEMBER</a></li>
              <li><a class="dropdown-item" href="#">OKTOBER</a></li>
              <li><a class="dropdown-item" href="#">NOVEMBER</a></li>
              <li><a class="dropdown-item" href="#">DESEMBER</a></li>
            </ul>
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
            <p class="fw-bold" style="color: rgba(13, 190, 0, 1)">Rp. {{ $pendapatan_operasional }}</p>
        </div>

        <div class="d-flex justify-content-between" style="border-bottom: 1px solid black; border-bottom-color: black">
            <p>Biaya operasional perusahaan</p>
            <p class="fw-bold" style="color: rgba(255, 0, 0, 1)">-Rp. 1.000.000</p>
        </div>

        <div class="d-flex justify-content-between">
            <p class="fw-bold">Total Arus Kas Operasional</p>
            <p class="fw-bold">Rp. 14.000.000</p>
        </div>
    </div>
</x-layout>