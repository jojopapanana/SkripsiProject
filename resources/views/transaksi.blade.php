<x-layout title="Transaksi">
    <div class="d-flex justify-content-center" style="width: 70vw">
        <h1 class="fw-bold">LAPORAN TRANSAKSI</h1>
    </div>
    
    <div class="d-flex justify-content-center gap-3 mt-3" style="width: 70vw">
        <div class="dropdown">
            <button class="dropdown-toggle fs-5 p-2 fw-bold" id="dropdown-bulan-transaksi" data-bs-toggle="dropdown" aria-expanded="true" style="border: 2px solid rgba(30, 3, 66, 1); border-radius: 10px; background-color: white;">
              AGUSTUS
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
        </div>
    
        <div class="dropdown" id="dropdown-tahun-transaksi">
            <button class="dropdown-toggle p-2 fs-5 fw-bold" type="button" data-bs-toggle="dropdown" aria-expanded="true" style="border: 2px solid rgba(30, 3, 66, 1); border-radius: 10px; background-color: white;">
              2024
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
        </div>
    </div>

    <div class="table-container mt-4" style="overflow: hidden; border-radius: 10px">
      <table class="table" style="border: none">
        <thead>
          <tr>
            <th scope="col">Kode Transaksi</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Nominal</th>
            <th scope="col">Kategori</th>
            <th scope="col">Jenis</th>
            <th scope="col">Metode</th>
            <th scope="col"></th>
          </tr>
        </thead>
  
        <tbody class="mt-3">
          <tr>
            <td scope="row">TR001</td>
            <td>08-08-2024</td>
            <td>Rp. 100.000</td>
            <td>Pemasukan</td>
            <td>Operasional</td>
            <td>Tunai</td>
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
    
  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 text-center fw-bold" id="editModalLabel">Detail Transaksi</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="kodeTransaksi" class="form-label">Kode Transaksi</label>
              <input type="text" class="form-control" id="kodeTransaksi" placeholder="TR001" disabled>
            </div>
            <div class="mb-3">
              <label for="tanggalTransaksi" class="form-label">Tanggal Transaksi</label>
              <input type="date" class="form-control disabled" id="tanggalTransaksi" placeholder=08/08/2024 disabled>
            </div>
            <div class="mb-3">
              <label for="nominalTransaksi" class="form-label">Nominal</label>
              <input type="text" class="form-control" id="nominalTransaksi">
            </div>
            <div class="mb-3">
              <label for="jenisTransaksi" class="form-label">Jenis Transaksi</label>
              <select class="form-select" id="jenisTransaksi">
                <option value="">Pemasukan</option>
                <option value="">Pengeluaran</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="kategoriTransaksi" class="form-label">Kategori</label>
              <select class="form-select" id="kategoriTransaksi">
                <option value="">Operasional</option>
                <option value="">Finanasial</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="metodeTransaksi" class="form-label">Metode</label>
              <select class="form-select" id="metodeTransaksi">
                <option value="">Tunai</option>
                <option value="">Non-Tunai</option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn fw-semibold" style="border: 2px solid rgba(30, 3, 66, 1)" data-bs-dismiss="modal">Tutup</button>
          <button type="button" class="btn fw-semibold" style="background-color: rgba(30, 3, 66, 1); color: white">Simpan</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <center>
            <i class="bi bi-exclamation-triangle-fill" style="font-size: 5rem; color: red"></i>
          </center>

          <h4 class="fw-bold text-center">Apakah kamu yakin ingin menghapus transaksi ini?</h4>

          <div class="d-flex justify-content-center gap-4 mt-4">
            <button type="button" class="btn fw-semibold" style="background-color: rgba(210, 0, 0, 1); width: 5vw; color: white">Ya</button>
            <button type="button" class="btn fw-semibold" style="border: 2px solid black; width: 5vw" data-bs-dismiss="modal">Tidak</button>
          </div>
        </div>
      </div>
    </div>
  </div>

</x-layout>