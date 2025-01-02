<x-layout title="Transaksi">
    <div class="d-flex justify-content-center" style="width: 70vw">
        <h1 class="fw-bold">LAPORAN TRANSAKSI</h1>
    </div>

    <div class="d-flex justify-content-center gap-3 mt-2" style="width: 70vw">
        <div class="dropdown">
            <button class="btn dropdown-toggle fw-semibold fs-5" type="button" id="monthDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
                {{ strtoupper(\Carbon\Carbon::now()->translatedFormat('F')) }}
            </button>
            <ul class="dropdown-menu w-100" id="month-dropdown-menu" aria-labelledby="monthDropdownButton">
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
            <ul class="dropdown-menu w-100" id="year-dropdown-menu" aria-labelledby="yearDropdownButton">
                <li><a class="dropdown-item" href="#" data-value="2022">2022</a></li>
                <li><a class="dropdown-item" href="#" data-value="2023">2023</a></li>
                <li><a class="dropdown-item" href="#" data-value="2024">2024</a></li>
                <li><a class="dropdown-item" href="#" data-value="2025">2025</a></li>
            </ul>
        </div>
    </div>

    <div class="card mt-5">
        <div class="card-body py-2">
            <table class="w-100">
                <thead>
                    <tr>
                        <th class="text-start" style="width: 15%;">Kode Transaksi</th>
                        <th class="text-start" style="width: 15%;">Tanggal</th>
                        <th class="text-start" style="width: 19%;">Nominal</th>
                        <th class="text-start" style="width: 15%;">Kategori</th>
                        <th class="text-start" style="width: 15%;">Jenis</th>
                        <th class="text-start" style="width: 15%;">Metode</th>
                        <th class="text-start" style="width: 6%;"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @if($transactions->count() > 0)
        @foreach($transactions as $index => $transaction)
            <div class="card {{ $index === 0 ? 'mt-3' : 'mt-2' }}">
                <div class="card-body py-2">
                    <table class="w-100">
                        <tbody>
                            <tr>
                                <td class="text-start" style="width: 15%;">{{ $index + 1 }}</td>
                                <td class="text-start" style="width: 15%;">{{ date('Y-m-d', strtotime($transaction->created_at)) }}</td>
                                @if ($totals->contains('id', $transaction->id))
                                    @forEach($totals as $total)
                                        @if ($transaction->id == $total->id)
                                            <td class="text-start" style="width: 19%;">Rp. {{ number_format($total->totalNominal, 0, ',', '.') }}</td>
                                        @endif
                                    @endforeach
                                @else 
                                    <td class="text-start" style="width: 19%;">Rp. 0</td>
                                @endif
                                <td class="text-start" style="width: 15%;">{{ $transaction->type }}</td>
                                <td class="text-start" style="width: 15%;">{{ $transaction->category }}</td>
                                <td class="text-start" style="width: 15%;">{{ $transaction->methodName }}</td>
                                <td class="text-start" style="width: 6%;">

                                    <div class="d-flex gap-4">
                                    <button class="btn p-0 icon-default-button" style="border: none" data-bs-toggle="modal" data-bs-target="#editModal-{{ $transaction->id }}">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                    
                                    <button data-bs-toggle="modal" data-bs-target="#deleteModal{{ $transaction->id }}" class="btn p-0 delete-button" style="border: none">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                    </div>
                    
                                    <div class="modal fade" id="editModal-{{ $transaction->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered custom-modal-width">
                                            <div class="modal-content pl-3 pr-3">
                                                <div class="modal-header justify-content-center">
                                                    <p class="modal-title" id="exampleModalLabel">Detail Transaksi</p>
                                                </div>
                                                <form id="editTransaction" method="POST" action="{{ route('transaksi.update', $transaction->id) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('UPDATE')

                                                    <div class="modal-body">
                                                        <div class="form-group position-relative mb-2">
                                                            <label for="kodeTransaksi" class="col-form-label" id="inputModalLabel">Kode Transaksi</label>
                                                            <input type="text" class="form-control border-style" id="kodeTransaksi" name="kodeTransaksi" value="{{ $index + 1 }}" disabled>
                                                        </div>

                                                        <input type="hidden" id="kodeTransaksi" name="kodeTransaksi" value="{{ $index + 1 }}">

                                                        <div class="form-group position-relative mb-2">
                                                            <label for="tanggalTransaksi" class="col-form-label" id="inputModalLabel">Tanggal</label>
                                                            <input type="date" class="form-control border-style" id="tanggalTransaksi" name="tanggalTransaksi" value="{{ date('Y-m-d', strtotime($transaction->created_at)) }}" disabled>
                                                        </div>

                                                        <input type="hidden" id="tanggalTransaksi" name="tanggalTransaksi" value="{{ date('Y-m-d', strtotime($transaction->created_at)) }}">

                                                        <div class="form-group position-relative mb-2">
                                                            <label for="nominalTransaksi" class="col-form-label" id="inputModalLabel">Nominal</label>
                                                            @if ($totals->contains('id', $transaction->id))
                                                                @forEach($totals as $total)
                                                                    @if ($transaction->id == $total->id)
                                                                        @if ($transaction->type == 'Pemasukan')
                                                                        <input type="text" class="form-control border-style" 
                                                                            id="nominalTransaksi"
                                                                            name="nominalTransaksi" 
                                                                            value="Rp. {{ number_format($total->totalNominal, 0, ',', '.') }},-" 
                                                                            disabled>

                                                                        <input type="hidden" id="nominalTransaksi" name="nominalTransaksi" value="Rp. {{ number_format($total->totalNominal, 0, ',', '.') }},-">
                                                                        @else
                                                                        <input type="text" class="form-control border-style"
                                                                            id="nominalTransaksi"
                                                                            name="nominalTransaksi" 
                                                                            value="Rp. {{ number_format($total->totalNominal, 0, ',', '.') }},-">
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                <input type="text" class="form-control border-style" 
                                                                    id="nominalTransaksi"
                                                                    name="nominalTransaksi" 
                                                                    value="Rp. 0,-" 
                                                                    disabled>
                                                            @endif
                                                        </div>

                                                        <div class="form-group position-relative mb-2">
                                                            <label for="jenisTransaksi" class="col-form-label" id="inputModalLabel">Jenis</label>
                                                            <input type="text" class="form-control border-style" id="jenisTransaksi" name="jenisTransaksi" value="{{ $transaction->type }}" disabled>
                                                        </div>

                                                        <input type="hidden" id="jenisTransaksi" name="jenisTransaksi" value="{{ $transaction->type }}">

                                                        <div class="form-group position-relative mb-2">
                                                            <label for="kategoriTransaksi" class="col-form-label" id="inputModalLabel">Kategori</label>
                                                            <select class="form-select border-style" id="kategoriTransaksi" name="kategoriTransaksi" value="{{ $transaction->category }}">
                                                                <option value="Operasional" {{ $transaction->category == 'Operasional' ? 'selected' : '' }}>Operasional</option>
                                                                <option value="Investasi" {{ $transaction->category == 'Investasi' ? 'selected' : '' }}>Investasi</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group position-relative mb-2">
                                                            <label for="metodeTransaksi" class="col-form-label" id="inputModalLabel">Metode</label>
                                                            <select class="form-select border-style" id="metodeTransaksi" name="metodeTransaksi" value="{{ $transaction->methodName }}">
                                                                @foreach($payment_methods as $method)
                                                                    <option value="{{ $method->name }}" {{ $transaction->methodName == $method->name ? 'selected' : '' }}>
                                                                        {{ $method->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group position-relative mb-2">
                                                            <label for="deskripsiTransaksi" class="col-form-label" id="inputModalLabel">Deskripsi</label>
                                                            <textarea class="form-control border-style" id="transactionDesc" name="deskripsiTransaksi" rows="3" required>{{ $transaction->description }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer mb-2">
                                                        <button type="button" class="btn btn-primary custom-btn mt-2 btn-closed" data-bs-dismiss="modal">Tutup</button>
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-primary custom-btn mt-2">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="deleteModal{{ $transaction->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body ps-4 pe-4 pb-4">
                                                    <center>
                                                        <i class="bi bi-exclamation-triangle-fill" style="font-size: 5rem; color: red"></i>
                                                    </center>

                                                    <h4 class="fw-bold text-center">Apakah Anda yakin ingin menghapus transaksi ini?</h4>

                                                    <div class="d-flex justify-content-center gap-4 mt-4">
                                                        <button class="btn fw-semibold cancel-btn" data-bs-dismiss="modal">Tidak</button>

                                                        <form method="POST" action="{{ route('transaksi.delete', $transaction->id) }}">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <button class="btn fw-semibold confirm-btn">Ya</button>
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

        <div class="d-flex justify-content-end mt-5 mb-5">
            <div class="dropdown">
                <button class="btn dropdown-toggle fw-semibold" type="button" id="exportDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Ekspor
                </button>
                <ul class="dropdown-menu" id="export-dropdown-menu" aria-labelledby="exportDropdownButton">
                    <li><a class="dropdown-item" id="export-link-excel">xlsx</a></li>
                    <li><a class="dropdown-item" id="export-link-csv">csv</a></li>
                    <li><a class="dropdown-item" id="export-link-pdf">pdf</a></li>
                </ul>
            </div>
        </div>
    @else 
        <div class="card mt-3">
            <div class="card-body py-2 m-3">
                <center>
                    <div class="mb-1"><img src="/assets/no-data.png" alt="NO-DATA" style="width:100px"></div>
                    <p class="fw-bold mb-2" style="font-size: 1.5rem">Oops..!</p>
                    <p class="fw-semibold mb-5">Saat ini belum ada data transaksi nih. Yuk, tambahkan pemasukan atau pengeluaranmu untuk mulai melihat data!</p>
                    <a href="{{ route('Dashboard') }}" style="text-decoration: none"><button type="submit" class="btn btn-primary custom-btn">Tambah</button></a>
                </center>
            </div>
        </div>
    @endif

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function(event) {
                let nominalFields = form.querySelectorAll('#nominalTransaksi');  // Select nominal and nominalPengeluaran within the current form

                nominalFields.forEach(function(field) {
                    if (field) {
                        let originalValue = field.value
                        field.value = originalValue.replace(/\D/g, '');  // Replace all non-numeric characters
                        setTimeout(function() {
                            field.value = originalValue;  // Restore the original value to display
                        }, 0);
                    }
                });
            });
        });
    </script>

    <script>
        $('[id^="editModal-"]').on('submit', function(e) {
            var form = $(this);

            if (form.find('#nominalTransaksi').val() === '') {
                e.preventDefault();
                alert('Silahkan isi nominal terlebih dahulu!');
                return;
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            var originalNominalValue = ''; // Variable to store the original value
            var originalKategoriValue = '';
            var originalMetodeValue = '';
            var originalDeskripsiValue = '';

            // When any edit modal is shown, store the original value
            $(document).on('show.bs.modal', '[id^="editModal-"]', function() {
                var modal = $(this);
                originalNominalValue = modal.find('#nominalTransaksi').val(); // Capture the original value
                originalKategoriValue = modal.find('#kategoriTransaksi').val();
                originalMetodeValue = modal.find('#metodeTransaksi').val();
                originalDeskripsiValue = modal.find('#transactionDesc').val();
            });

            // When any edit modal is hidden (closed without form submission), restore the original value
            $(document).on('hidden.bs.modal', '[id^="editModal-"]', function() {
                var modal = $(this);
                modal.find('#nominalTransaksi').val(originalNominalValue); // Restore the original value
                modal.find('#kategoriTransaksi').val(originalKategoriValue);
                modal.find('#metodeTransaksi').val(originalMetodeValue);
                modal.find('#transactionDesc').val(originalDeskripsiValue);
            });

            $(document).on('input', '#nominalTransaksi', function(event) {
                enforceNumericInput(this);
            });
            $(document).on('blur', '#nominalTransaksi', function(event) {
                addCurrencySuffix(this);
            });
            $(document).on('input', '#transactionDesc', enforceInputDeskripsi);

            // Fun ction to enforce numeric input
            function enforceInputDeskripsi(event) {
                var input = event.target;
                var value = input.value;

                if (value.length > 255) {
                    value = value.slice(0, 255);
                    alert('Jumlah input karakter maksimal adalah 255 huruf!');
                }

                input.value = value;
            }

            // Function to enforce numeric input
            function enforceNumericInput(input) {
                var value = input.value;

                // Remove any non-digit characters except the prefix
                var numberValue = value.slice(4).replace(/\D/g, '');

                if (numberValue.startsWith('0') && numberValue.length > 1) {
                    numberValue = numberValue.replace(/^0+/, '');
                }

                // Restrict the input to prevent entering numbers starting with 0 (except 0 itself)
                if (numberValue.startsWith('0')) {
                    numberValue = ''; // If first character is 0, restrict the rest of the input
                }

                // Limit the input to the first 12 digits
                if (numberValue.length > 12) {
                    numberValue = numberValue.slice(0, 12); // Keep only the first 12 characters
                    alert('Batas maksimum input nominal transaksi adalah 12 digit angka!');
                }

                // Format the number with dots as thousand separators
                var formattedValue = numberValue.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                // Update the input value with the formatted number
                input.value = 'Rp. ' + formattedValue;
            }

            function addCurrencySuffix(input) {
                var value = input.value;

                // Ensure the value ends with ",-"
                if (value.length > 4 && !value.endsWith(',-')) {
                    input.value = value + ',-';
                }
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            // handle for when error happens in the backend
            $('#alertModal').on('hidden.bs.modal', function() {
                @if (session('errorDataUpdate'))
                    const errorData = @json(session('errorDataUpdate'));
                    $('#editModal-' + errorData.id).modal('show'); 
                    $('#editModal-' + errorData.id).attr('action', `{{ url('/transaksi/update') }}/${errorData.id}`);
                    $('#kodeTransaksi').val(errorData.id);
                    $('#tanggalTransaksi').val(errorData.tanggalTransaksi);
                    $('#nominalTransaksi').val(errorData.nominalTransaksi);
                    $('#jenisTransaksi').val(errorData.jenisTransaksi);
                    $('#kategoriTransaksi').val(errorData.kategoriTransaksi);
                    $('#metodeTransaksi').val(errorData.metodeTransaksi);
                    $('#transactionDesc').val(errorData.transactionDesc);
                @endif
            });
        });
    </script>

    <!-- Alert Modal Component -->
    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="okModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body ps-4 pe-4 pb-4">
                    <center>
                        <i id="modalIcon" class="bi bi-check-circle-fill" style="font-size: 5rem; color: rgb(0, 205, 0)"></i>
                    </center>
                    <h4 class="fw-bold text-center" id="modalText">Default Text</h4>
                    <div class="d-flex justify-content-center gap-4 mt-4">
                        <button class="btn fw-semibold cancel-btn" data-dismiss="modal">Oke</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Function to change modal text, icon, and show the modal -->
    <script>
        var alertModal = new bootstrap.Modal(document.getElementById('alertModal'));

        function showAlert(text, iconClass, iconColor) {
            document.getElementById('modalText').innerText = text;
            const modalIcon = document.getElementById('modalIcon');
            modalIcon.className = iconClass;
            modalIcon.style.color = iconColor;
            alertModal.show();
        }
    </script>

    @if (session('success'))
        <script>
            showAlert(
                '{{ session('success') }}',
                'bi bi-check-circle-fill',
                'rgb(0, 205, 0)' // Green for success
            );
        </script>
    @endif

    @if (session('error'))
        <script>
            showAlert(
                '{{ session('error') }}',
                'bi bi-exclamation-triangle-fill',
                'red' // Red for error
            );
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const monthDropdownButton = document.getElementById('monthDropdownButton');
            const monthDropdownItems = document.querySelectorAll('#month-dropdown-menu .dropdown-item');
            const yearDropdownButton = document.getElementById('yearDropdownButton');
            const yearDropdownItems = document.querySelectorAll('#year-dropdown-menu .dropdown-item');

            let selectedMonthValue = new URLSearchParams(window.location.search).get('month') || (new Date().getMonth() + 1);
            let selectedYearValue = new URLSearchParams(window.location.search).get('year') || new Date().getFullYear();

            function updateUrl() {
                window.location.href = `{{ route('transaksi') }}?month=${selectedMonthValue}&year=${selectedYearValue}`;
            }

            monthDropdownItems.forEach(function(item) {
                item.addEventListener('click', function(event) {
                    event.preventDefault();
                    const selectedMonthText = this.textContent;
                    selectedMonthValue = this.getAttribute('data-value');
                    
                    monthDropdownButton.textContent = selectedMonthText;
                    updateUrl();
                });
            });

            yearDropdownItems.forEach(function(item) {
                item.addEventListener('click', function(event) {
                    event.preventDefault();
                    const selectedYearText = this.textContent;
                    selectedYearValue = this.getAttribute('data-value');
                    
                    yearDropdownButton.textContent = selectedYearText;
                    updateUrl();
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

            function exportUrlExcel() {
                const exportRoute = `{{ route('transaksi_export_excel') }}?month=${selectedMonthValue}&year=${selectedYearValue}`;

                window.location.href = exportRoute;
            }

            const exportButtonExcel = document.getElementById('export-link-excel');
            exportButtonExcel.addEventListener('click', function(event) {
                event.preventDefault();
                exportUrlExcel();
            });

            function exportUrlCSV() {
                const exportRoute = `{{ route('transaksi_export_csv') }}?month=${selectedMonthValue}&year=${selectedYearValue}`;

                window.location.href = exportRoute;
            }

            const exportButtonCSV = document.getElementById('export-link-csv');
            exportButtonCSV.addEventListener('click', function(event) {
                event.preventDefault();
                exportUrlCSV();
            });

            function exportUrlPDF() {
                const exportRoute = `{{ route('transaksi_export_pdf') }}?month=${selectedMonthValue}&year=${selectedYearValue}`;

                window.location.href = exportRoute;
            }

            const exportButtonPDF = document.getElementById('export-link-pdf');
            exportButtonPDF.addEventListener('click', function(event) {
                    event.preventDefault();
                    exportUrlPDF();
            });
        });


        $(document).ready(function () {
            $("#deleteModal").on("show.bs.modal", function (e) {
                var id = $(e.relatedTarget).data('target-id');
                $('#pass_id').val(id);
            });
        });
    </script>

</x-layout>
