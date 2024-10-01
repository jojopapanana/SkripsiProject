<x-layout title="Stok">
    <div class="d-flex justify-content-center" style="width: 70vw">
        <h1 class="fw-bold">STOK BARANG</h1>
    </div>
    <div class="d-flex justify-content-center gap-3 mt-3" style="width: 70vw">
        <div class="dropdown">
            <select id="month" class="form-select px-5 py-2 fs-5 fw-bold" style="border: 1.5px solid rgba(30, 3, 66, 1); border-radius: 10px; background-color: white;">
                <option value="">BULAN</option>
                <option value="1" {{ request('month') == 1 ? 'selected' : '' }}>Januari</option>
                <option value="2" {{ request('month') == 2 ? 'selected' : '' }}>Februari</option>
                <option value="3" {{ request('month') == 3 ? 'selected' : '' }}>Maret</option>
                <option value="4" {{ request('month') == 4 ? 'selected' : '' }}>April</option>
                <option value="5" {{ request('month') == 5 ? 'selected' : '' }}>Mei</option>
                <option value="6" {{ request('month') == 6 ? 'selected' : '' }}>Juni</option>
                <option value="7" {{ request('month') == 7 ? 'selected' : '' }}>Juli</option>
                <option value="8" {{ request('month') == 8 ? 'selected' : '' }}>Agustus</option>
                <option value="9" {{ request('month') == 9 ? 'selected' : '' }}>September</option>
                <option value="10" {{ request('month') == 10 ? 'selected' : '' }}>Oktober</option>
                <option value="11" {{ request('month') == 11 ? 'selected' : '' }}>November</option>
                <option value="12" {{ request('month') == 12 ? 'selected' : '' }}>Desember</option>
            </select>
        </div>

        <div class="dropdown">
            <select id="year" class="form-select px-5 py-2 fs-5 fw-bold" style="border: 1.5px solid rgba(30, 3, 66, 1); border-radius: 10px; background-color: white;">
                <option value="">TAHUN</option>
                <option value="2024" {{ request('year') == 2024 ? 'selected' : '' }}>2024</option>
                <option value="2025" {{ request('year') == 2025 ? 'selected' : '' }}>2025</option>
                <option value="2026" {{ request('year') == 2026 ? 'selected' : '' }}>2026</option>
            </select>
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
                                        <button type="button" class="btn p-0" style="border: none" data-bs-toggle="modal" data-bs-target="#editModal{{ $stok->stok_id }}">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
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
            <div class="modal fade" id="editModal{{ $stok->stok_id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Stok</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('stok.update', $stok->stok_id) }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="kodeTransaksi" class="form-label">Kode Transaksi</label>
                                    <input type="text" class="form-control" id="kodeTransaksi" placeholder="{{$stok->stok_id}}" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Produk</label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $stok->nama }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nominal" class="form-label">Nominal</label>
                                    <input type="text" class="form-control" id="nominal" name="nominal" value="{{ $stok->nominal }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="sisa" class="form-label">Sisa Stok</label>
                                    <input type="number" class="form-control" id="sisa" name="sisa" value="{{ $stok->sisa }}" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn fw-semibold" style="border: 2px solid rgba(30, 3, 66, 1)" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn fw-semibold" style="background-color: rgba(30, 3, 66, 1); color: white">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
        <br>
        @if ($stokData->count() > 0)
        <div class="d-flex justify-content-end">
            <div class="dropdown">
            <button class="btn dropdown-toggle fw-semibold" type="button" id="exportDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
                Ekspor
            </button>
            <ul class="dropdown-menu" id="export-dropdown-menu" aria-labelledby="exportDropdownButton">
                <li><a class="dropdown-item" href="{{ route('stok_export_excel', ['month' => request('month', date('m')), 'year' => request('year', date('Y'))]) }}">XLSX</a></li>
                <li><a class="dropdown-item" href="{{ route('stok_export_csv', ['month' => request('month', date('m')), 'year' => request('year', date('Y'))]) }}">CSV</a></li>
                <li><a class="dropdown-item" href="{{ route('stok_export_pdf', ['month' => request('month', date('m')), 'year' => request('year', date('Y'))]) }}">PDF</a></li>
            </ul>
            </div>
        </div>
        @endif

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