<x-layout title="Stok">
    <div class="d-flex justify-content-center" style="width: 70vw">
        <h1 class="fw-bold">UTANG PIUTANG</h1>
    </div>
    {{-- <div class="d-flex justify-content-center gap-3 mt-3" style="width: 70vw">
        <div class="dropdown">
            <button class="btn dropdown-toggle fw-semibold fs-5" type="button" id="monthDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
                {{ strtoupper(date('F')) }}
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
    </div> --}}

        <div class="card mt-3">
            <div class="card-body py-2">
                <table class="w-100">
                    <thead>
                        <tr>
                            <th class="text-start" style="width: 15%;">Kode Transaksi</th>
                            <th class="text-start" style="width: 25%;">Deskripsi</th>
                            <th class="text-start" style="width: 16%;">Batas Waktu</th>
                            <th class="text-start" style="width: 15%;">Nominal</th>
                            <th class="text-start" style="width: 19%;">Jenis</th>
                            <th class="text-start" style="width: 10%;"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        @foreach($utangPiutang as $utang)
            <div class="card mt-3">
                <div class="card-body py-2">
                    <table class="w-100">
                        <tbody>
                            <tr>
                                <td class="text-start" style="widd: 15%;">{{ $utang->utang_id }}</td>
                                <td class="text-start" style="width: 25%;">{{ $utang->deskripsi }}</td>
                                <td class="text-start" style="width: 16%;">{{ $utang->batasWaktu }}</td>
                                <td class="text-start" style="width: 15%;">{{ $utang->nominal }}</td>
                                <td class="text-start" style="width: 19%;">{{ $utang->jenis }}</td>
                                <td class="text-start" style="width: 10%;">
                                <div class="d-flex gap-4">
                                        <button type="button" class="btn p-0" style="border: none" data-bs-toggle="modal" data-bs-target="#calendarModal{{ $utang->utang_id }}">
                                            <i class="bi bi-calendar-event-fill"></i>
                                        </button>
                                        <button type="button" class="btn p-0" style="border: none" data-bs-toggle="modal" data-bs-target="#editModal{{ $utang->utang_id }}">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <form action="{{ route('utang.delete', $utang->utang_id) }}" method="POST" onsubmit="return confirm('Apakah Anda ingin menghapus stok ini?')">
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
            <div class="modal fade" id="editModal{{ $utang->utang_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered custom-modal-width">
                    <div class="modal-content pl-3 pr-3">
                        <div class="modal-header justify-content-center">
                            <p class="modal-title" id="exampleModalLabel">Ubah Utang Piutang</p>
                        </div>
                        <form action="{{ route('utang.update', $utang->utang_id) }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="modal-body">
                                <div class="form-group position-relative mb-2">
                                    <label for="kodeTransaksi" class="col-form-label" id="inputModalLabel">Kode Transaksi</label>
                                    <input type="text" class="form-control border-style" id="kodeTransaksi" placeholder="{{$utang->utang_id}}" disabled>
                                </div>
                                <div class="form-group position-relative mb-2">
                                    <label for="nama" class="col-form-label" id="inputModalLabel">Deskripsi</label>
                                    <input type="text" class="form-control border-style" id="nama" name="nama" value="{{ $utang->deskripsi }}" required>
                                </div>
                                <div class="form-group position-relative mb-2">
                                    <label for="batasWaktu" class="col-form-label" id="inputModalLabel">Batas Waktu</label>
                                    <input type="date" class="form-control border-style" id="batasWaktu" name="batasWaktu" value="{{ $utang->batasWaktu }}" required>
                                </div>
                                <div class="form-group position-relative mb-2">
                                    <label for="nominal" class="col-form-label" id="inputModalLabel">Nominal</label>
                                    <input type="text" class="form-control border-style" id="nominal" name="nominal" value="Rp. {{ number_format($utang->nominal, 0, ',', '.') }},-" required>
                                </div>
                                <div class="form-group position-relative mb-2">
                                    <label for="nominal" class="col-form-label" id="inputModalLabel">Jenis</label>
                                    <input type="text" class="form-control border-style" id="nominal" name="nominal" value="{{ $utang-> jenis }}" required>
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary custom-btn mt-2 btn-closed" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary custom-btn mt-2">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
            <button type="submit" class="btn btn-primary custom-btn mt-2 float-end" data-bs-toggle="modal" data-bs-target="#addModal">Tambah</button>
            <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered custom-modal-width">
                    <div class="modal-content pl-3 pr-3">
                        <div class="modal-header justify-content-center">
                            <p class="modal-title" id="exampleModalLabel">Tambah Utang Piutang</p>
                        </div>
                        <form action="{{ route('utang.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group position-relative mb-2">
                                    <label for="kodeTransaksi" class="col-form-label" id="inputModalLabel">Kode Transaksi</label>
                                    <input type="text" class="form-control border-style" id="kodeTransaksi" name="kodeTransaksi" placeholder="{{$utang->utang_id}}"required>
                                </div>
                                <div class="form-group position-relative mb-2">
                                    <label for="deskripsi" class="col-form-label" id="inputModalLabel">Deskripsi</label>
                                    <input type="text" class="form-control border-style" id="deskripsi" name="deskripsi" required>
                                </div>
                                <div class="form-group position-relative mb-2">
                                    <label for="batasWaktu" class="col-form-label" id="inputModalLabel">Batas Waktu</label>
                                    <input type="date" class="form-control border-style" id="batasWaktu" name="batasWaktu" required>
                                </div>
                                <div class="form-group position-relative mb-2">
                                    <label for="nominal" class="col-form-label" id="inputModalLabel">Nominal</label>
                                    <input type="text" class="form-control border-style" id="nominal" name="nominal" required>
                                </div>
                                <div class="form-group position-relative mb-2">
                                    <label for="jenis" class="col-form-label">Jenis</label>
                                    <select class="form-control border-style" id="jenis" name="jenis" required>
                                        <option value="Utang">Utang</option>
                                        <option value="Piutang">Piutang</option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary custom-btn mt-2 btn-closed" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary custom-btn mt-2">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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