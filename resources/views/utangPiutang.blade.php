<x-layout title="Utang Piutang">
    <div class="d-flex justify-content-center" style="width: 70vw">
        <h1 class="fw-bold">UTANG PIUTANG</h1>
    </div>

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
                                        <button data-bs-toggle="modal" data-bs-target="#deleteModal{{ $utang->utang_id }}" class="btn p-0" style="color: red; border: none">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                </div>

                                <div class="modal fade" id="deleteModal{{ $utang->utang_id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <center>
                                                    <i class="bi bi-exclamation-triangle-fill" style="font-size: 5rem; color: red"></i>
                                                </center>

                                                <h4 class="fw-bold text-center">Apakah Anda yakin ingin menghapus utang/piutang ini?</h4>

                                                <div class="d-flex justify-content-center gap-4 mt-4">
                                                    <button class="btn fw-semibold" style="border: 2px solid black; width: 5vw" data-bs-dismiss="modal">Tidak</button>

                                                    <form method="POST" action="{{ route('utang.delete', $utang->utang_id) }}">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button class="btn fw-semibold" style="background-color: rgba(210, 0, 0, 1); width: 5vw; color: white">Ya</button>
                                                        @csrf
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                        <form action="{{ route('utang.update', $utang->utang_id) }}" method="POST"  enctype="multipart/form-data">
                            @csrf
                            @method('UPDATE')

                            <div class="modal-body">
                                <div class="form-group position-relative mb-2">
                                    <label for="kodeTransaksi" class="col-form-label" id="inputModalLabel">Kode Transaksi</label>
                                    <input type="text" class="form-control border-style" id="kodeTransaksi" placeholder="{{$utang->utang_id}}" disabled>
                                </div>
                                <div class="form-group position-relative mb-2">
                                    <label for="deskripsi" class="col-form-label" id="inputModalLabel">Deskripsi</label>
                                    <input type="text" class="form-control border-style" id="deskripsi" name="deskripsi" value="{{ $utang->deskripsi }}" required>
                                </div>
                                <div class="form-group position-relative mb-2">
                                    <label for="batasWaktu" class="col-form-label" id="inputModalLabel">Batas Waktu</label>
                                    <input type="date" class="form-control border-style" id="batasWaktu" name="batasWaktu" value="{{ $utang->batasWaktu }}" required>
                                </div>
                                <div class="form-group position-relative mb-2">
                                    <label for="nominal" class="col-form-label" id="inputModalLabel">Nominal</label>
                                    <input type="text" class="form-control border-style" id="nominal" name="nominal" placeholder="Rp. {{ number_format($utang->nominal, 0, ',', '.') }},-"
                                    value="{{ $utang->nominal }}" required>
                                </div>
                                <div class="form-group position-relative mb-2">
                                    <label for="jenis" class="col-form-label" id="inputModalLabel">Jenis</label>
                                    <select class="form-select border-style" name="jenis" value="{{ $utang->jenis }}">
                                        <option value="Pemasukan" {{ $utang->jenis == 'Utang' ? 'selected' : '' }}>Utang</option>
                                        <option value="Piutang" {{ $utang->jenis == 'Piutang' ? 'selected' : '' }}>Piutang</option>
                                    </select>
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary custom-btn mt-2 btn-closed" data-bs-dismiss="modal">Tutup</button>
                                    @method('PUT')
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
                                    <input type="text" class="form-control border-style" id="kodeTransaksi" name="kodeTransaksi" placeholder="{{ $transactionID }}" disabled>
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
    </div>
</x-layout>