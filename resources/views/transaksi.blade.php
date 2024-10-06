<x-layout title="Transaksi">
    <div class="d-flex justify-content-center" style="width: 70vw">
        <h1 class="fw-bold">LAPORAN TRANSAKSI</h1>
    </div>

    <div class="d-flex justify-content-center gap-3 mt-3" style="width: 70vw">
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
    </div>

    <div class="card mt-5">
        <div class="card-body py-2">
            <table class="w-100">
                <thead>
                    <tr>
                        <th class="text-start" style="width: 15%;">Kode Transaksi</th>
                        <th class="text-start" style="width: 16%;">Tanggal</th>
                        <th class="text-start" style="width: 16%;">Nominal</th>
                        <th class="text-start" style="width: 16%;">Kategori</th>
                        <th class="text-start" style="width: 16%;">Jenis</th>
                        <th class="text-start" style="width: 16%;">Metode</th>
                        <th class="text-start" style="width: 10%;"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="mb-3">
        @foreach($transactions as $transaction)
            <div class="card mt-3">
                <div class="card-body py-2">
                    <table class="w-100">
                        <tbody>
                            <tr>
                                <td class="text-start" style="width: 15%;">{{ $transaction->id }}</td>
                                <td class="text-start" style="width: 16%;">{{ date('Y-m-d', strtotime($transaction->created_at)) }}</td>
                                @forEach($totals as $total)
                                    @if ($transaction->id == $total->id)
                                        <td class="text-start" style="width: 16%;">Rp. {{ number_format($total->totalNominal, 0, ',', '.') }}</td>
                                    @endif
                                @endforeach
                                <td class="text-start" style="width: 16%;">{{ $transaction->type }}</td>
                                <td class="text-start" style="width: 16%;">{{ $transaction->category }}</td>
                                <td class="text-start" style="width: 16%;">{{ $transaction->method }}</td>
                                <td class="text-start" style="width: 10%;">
                                    <div class="d-flex gap-4">
                                        <button class="btn p-0" style="border: none" data-bs-toggle="modal" data-bs-target="#editModal-{{ $transaction->id }}">
                                        <i class="bi bi-pencil-fill"></i>
                                        </button>

                                        <button data-bs-toggle="modal" data-bs-target="#deleteModal{{ $transaction->id }}" class="btn p-0" style="color: red; border: none">
                                        <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </div>

                                    <div class="modal fade" id="editModal-{{ $transaction->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered custom-modal-width">
                                            <div class="modal-content pl-3 pr-3">
                                                <div class="modal-header justify-content-center">
                                                    <p class="modal-title" id="exampleModalLabel">Detail Transaksi</p>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editTransaction" method="POST" action="{{ route('transaksi.update', $transaction->id) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('UPDATE')

                                                        <div class="form-group position-relative mb-2">
                                                            <label for="kodeTransaksi" class="col-form-label" id="inputModalLabel">Kode Transaksi</label>
                                                            <input type="text" class="form-control border-style" name="kodeTransaksi" placeholder="{{ $transaction->id }}" disabled>
                                                        </div>

                                                        <div class="form-group position-relative mb-2">
                                                            <label for="tanggalTransaksi" class="col-form-label" id="inputModalLabel">Tanggal Transaksi</label>
                                                            <input type="date" class="form-control disabled border-style" name="tanggalTransaksi" value="{{ date('Y-m-d', strtotime($transaction->created_at)) }}" disabled>
                                                        </div>

                                                        <div class="form-group position-relative mb-2">
                                                            <label for="nominalTransaksi" class="col-form-label" id="inputModalLabel">Nominal</label>
                                                            @forEach($totals as $total)
                                                                @if ($transaction->id == $total->id)
                                                                    @if ($transaction->type == 'Pemasukan')
                                                                        <input type="text" class="form-control border-style" name="nominalTransaksi" value="{{ $total->totalNominal }}" disabled>
                                                                    @else
                                                                        <input type="text" class="form-control border-style" name="nominalTransaksi" value="{{ $total->totalNominal }}">
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </div>

                                                        <div class="form-group position-relative mb-2">
                                                            <label for="jenisTransaksi" class="col-form-label" id="inputModalLabel">Jenis Transaksi</label>
                                                            <select class="form-select border-style" name="jenisTransaksi" value="{{ $transaction->type }}">
                                                                <option value="Pemasukan" {{ $transaction->type == 'Pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                                                                <option value="Pengeluaran" {{ $transaction->type == 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group position-relative mb-2">
                                                            <label for="kategoriTransaksi" class="col-form-label" id="inputModalLabel">Kategori</label>
                                                            <select class="form-select border-style" name="kategoriTransaksi" value="{{ $transaction->category }}">
                                                                <option value="Operasional" {{ $transaction->category == 'Operasional' ? 'selected' : '' }}>Operasional</option>
                                                                <option value="Investasi" {{ $transaction->category == 'Investasi' ? 'selected' : '' }}>Investasi</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group position-relative mb-2">
                                                            <label for="metodeTransaksi" class="col-form-label" id="inputModalLabel">Metode</label>
                                                            <select class="form-select border-style" name="metodeTransaksi" value="{{ $transaction->method }}">
                                                                <option value="Tunai" {{ $transaction->method == 'Tunai' ? 'selected' : '' }}>Tunai</option>
                                                                <option value="Non-Tunai" {{ $transaction->method == 'Non-Tunai' ? 'selected' : '' }}>Non-Tunai</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group position-relative mb-4">
                                                            <label for="deskripsiTransaksi" class="col-form-label" id="inputModalLabel">Deskripsi Transaksi</label>
                                                            <textarea class="form-control border-style" name="deskripsiTransaksi" rows="3">{{ $transaction->description }}</textarea>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary custom-btn mt-2 btn-closed" data-bs-dismiss="modal">Tutup</button>
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-primary custom-btn mt-2">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="deleteModal{{ $transaction->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <center>
                                                        <i class="bi bi-exclamation-triangle-fill" style="font-size: 5rem; color: red"></i>
                                                    </center>

                                                    <h4 class="fw-bold text-center">Apakah Anda yakin ingin menghapus transaksi ini?</h4>

                                                    <div class="d-flex justify-content-center gap-4 mt-4">
                                                        <button class="btn fw-semibold" style="border: 2px solid black; width: 5vw" data-bs-dismiss="modal">Tidak</button>

                                                        <form method="POST" action="{{ route('transaksi.delete', $transaction->id) }}">
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
        @endforeach

        @if ($transactions->count() > 0)
            <div class="d-flex justify-content-end mt-3">
                <div class="dropdown">
                    <button class="btn dropdown-toggle fw-semibold" type="button" id="exportDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
                        Ekspor
                    </button>
                    <ul class="dropdown-menu" id="export-dropdown-menu" aria-labelledby="exportDropdownButton">
                        <li><a class="dropdown-item" href="{{ route('transaksi_export_excel', ['month' => request('month', date('m')), 'year' => request('year', date('Y'))]) }}">xlsx</a></li>
                        <li><a class="dropdown-item" href="{{ route('transaksi_export_csv', ['month' => request('month', date('m')), 'year' => request('year', date('Y'))]) }}">csv</a></li>
                        <li><a class="dropdown-item" href="{{ route('transaksi_export_pdf', ['month' => request('month', date('m')), 'year' => request('year', date('Y'))]) }}">pdf</a></li>
                    </ul>
                </div>
            </div>
        @endif

        <!-- Alert Modal Component -->
        <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="okModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <center>
                            <i class="bi bi-check-circle-fill" style="font-size: 5rem; color: rgb(0, 205, 0)"></i>
                        </center>
                        <h4 class="fw-bold text-center" id="modalText">Default Text</h4>
                        <div class="d-flex justify-content-center gap-4 mt-4">
                            <button class="btn fw-semibold" style="border: 2px solid black; width: 5vw" data-bs-dismiss="modal">Oke</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Function to change modal text and show the modal -->
    <script>
        var alertModal = new bootstrap.Modal(document.getElementById('alertModal'));

        function showAlert(text) {
            document.getElementById('modalText').innerText = text;
            alertModal.show();
        }
    </script>

    @if (session('success'))
        <script>
            showAlert('{{ session('success') }}');
        </script>
    @endif

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

                    window.location.href = `{{ route('transaksi') }}?month=${selectedMonthValue}`;
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

        $(document).ready(function () {
            $("#deleteModal").on("show.bs.modal", function (e) {
                var id = $(e.relatedTarget).data('target-id');
                $('#pass_id').val(id);
            });
        });
    </script>

</x-layout>
