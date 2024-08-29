<x-layout title="Transaksi">
    <div class="d-flex justify-content-center" style="width: 70vw">
        <h1 class="fw-bold">STOK BARANG</h1>
    </div>
    <div class="d-flex justify-content-center gap-3 mt-3" style="width: 70vw">
      <div class="dropdown">
          <button class="dropdown-toggle px-5 py-2 fs-5 fw-bold" id="dropdown-bulan-transaksi" data-bs-toggle="dropdown" aria-expanded="true" style="border: 1.5px solid rgba(30, 3, 66, 1); border-radius: 10px; background-color: white;">
              BULAN
          </button>
          <ul class="dropdown-menu" style="width: 100%;">
              <li><a class="dropdown-item" href="#">Januari</a></li>
              <li><a class="dropdown-item" href="#">Februari</a></li>
              <li><a class="dropdown-item" href="#">Maret</a></li>
              <li><a class="dropdown-item" href="#">April</a></li>
              <li><a class="dropdown-item" href="#">Mei</a></li>
              <li><a class="dropdown-item" href="#">Juni</a></li>
              <li><a class="dropdown-item" href="#">Juli</a></li>
              <li><a class="dropdown-item" href="#">Agustus</a></li>
              <li><a class="dropdown-item" href="#">September</a></li>
              <li><a class="dropdown-item" href="#">Oktober</a></li>
              <li><a class="dropdown-item" href="#">November</a></li>
              <li><a class="dropdown-item" href="#">Desember</a></li>
          </ul>
      </div>

      <div class="dropdown" id="dropdown-tahun-transaksi">
          <button class="dropdown-toggle px-5 py-2 fs-5 fw-bold" type="button" data-bs-toggle="dropdown" aria-expanded="true" style="border: 1.5px solid rgba(30, 3, 66, 1); border-radius: 10px; background-color: white;">
              TAHUN
          </button>
          <ul class="dropdown-menu" style="width: 100%;">
              <li><a class="dropdown-item" href="#">2024</a></li>
              <li><a class="dropdown-item" href="#">2025</a></li>
              <li><a class="dropdown-item" href="#">2026</a></li>
          </ul>
      </div>
  </div>
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="fw-bold">Penjualan Terbanyak</h4>
            <div class="row">
                <div class="col">
                    <div class="justify-content-start">
                        <h3 class="text-start fs-6 fw-normal mt-2">Handphone</h3>
                    </div>
                    <div class="justify-content-start">
                        <h3 class="text-start fs-6 fw-normal mt-3">Charger</h3>
                    </div>
                </div>
                <div class="col">
                    <div class="justify-content-end">
                        <h3 class="text-end fs-6 fw-normal">20</h3>
                    </div>
                    <div class="justify-content-end">
                        <h3 class="text-end fs-6 fw-normal">10</h3>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <div class="justify-content-start">
                        <h5 class="text-start fs-6 fw-bold">Total Terjual</h4>
                    </div>
                </div>
                <div class="col">
                    <div class="justify-content-end">
                        <h3 class="text-end fs-6 fw-bold">30</h3>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <div class="table-container mt-4" style="overflow: hidden; border-radius: 10px">
      <table class="table" style="border: none">
        <thead>
          <tr>
            <th scope="col">Kode Stok</th>
            <th scope="col">Nama</th>
            <th scope="col">Nominal</th>
            <th scope="col">Sisa</th>
            <th scope="col"></th>
          </tr>
        </thead>
  
        <tbody class="mt-3">
            <tr>
                <td scope="row">ST001</td>
                <td>Handphone</td>
                <td>Rp. 100.000</td>
                <td>30</td>
                <td>
                  <div class="d-flex gap-4">
                      <button type="button" class="btn p-0" style="border: none" data-bs-toggle="modal" data-bs-target="#editModal">
                      <i class="bi bi-pencil-fill"></i>
                      </button>

                      <button type="button" class="btn p-0" style="color: red; border: none" data-bs-toggle="modal" data-bs-target="#deleteModal">
                      <i class="bi bi-trash3-fill"></i>
                      </button>
                  </div>
                </td>
            </tr>
        </tbody>
      </table>
    </div>
</x-layout>