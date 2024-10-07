<x-layout title="Stok">
    <div class="d-flex justify-content-center" style="width: 70vw">
        <h1 class="fw-bold">STOK BARANG</h1>
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
                        
                        window.location.href = `{{ route('stok') }}?month=${selectedMonthValue}`;
                    });
                });

                yearDropdownItems.forEach(function(item) {
                    item.addEventListener('click', function(event) {
                        event.preventDefault();
                        const selectedYearText = this.textContent;
                        const selectedYearValue = this.getAttribute('data-value');
                        
                        yearDropdownButton.textContent = selectedYearText;
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
    </div>
</x-layout>