<x-layout title="Stok">
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
            <h5 class="fw-bold">Stok Terbanyak</h4>
            <div class="row">
                <div class="col">
                    @foreach($top_products as $product)
                        <div class="justify-content-start">
                            <h3 class="text-start fs-6 fw-normal mt-2">{{ $product->productName }}</h3>
                        </div>
                    @endforeach
                </div>
                <div class="col">
                    @foreach($top_products as $product)
                    <div class="justify-content-end">
                        <h3 class="text-end fs-6 fw-normal mt-2">{{ $product->productStock }}</h3>
                    </div>
                    @endforeach
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
                        <h3 class="text-end fs-6 fw-bold">{{ $total_products_sold }}</h3>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body py-2">
                <table class="w-100">
                    <thead>
                        <tr>
                            <th class="text-start" style="width: 20%;">Kode Stok</th>
                            <th class="text-start" style="width: 30%;">Nama</th>
                            <th class="text-start" style="width: 25%;">Nominal</th>
                            <th class="text-start" style="width: 15%;">Sisa</th>
                            <th class="text-start" style="width: 10%;"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        @foreach($stokData as $stok)
            <div class="card mt-3">
                <div class="card-body py-2">
                    <table class="w-100">
                        <tbody>
                            <tr>
                                <td class="text-start" style="width: 20%;">{{ $stok->stok_id }}</td>
                                <td class="text-start" style="width: 30%;">{{ $stok->nama }}</td>
                                <td class="text-start" style="width: 25%;">Rp. {{ number_format($stok->nominal, 0, ',', '.') }}</td>
                                <td class="text-start" style="width: 15%;">{{ $stok->sisa }}</td>
                                <td class="text-start" style="width: 10%;">
                                    <div class="d-flex gap-4">
                                        <form action="{{ route('stok.delete', $stok->stok_id) }}" method="POST" onsubmit="return confirm('Apakah Anda ingin menghapus stok ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn p-0" style="color: red; border: none">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
        <br>
    </div>
</x-layout>