<x-layout title="Stok">
    <h1 class="fw-bold text-center responsive-margin-end" style="font-size: 2.5rem">STOK BARANG</h1>
    <h1 class="width-adjust"></h1>

    <div class="card responsive-margin-end" style="margin-top: 3.5rem; min-width: 750px">
        <div class="card-body py-2">
            <table class="w-100">
                <thead>
                    <tr>
                        <th class="text-start" style="width: 21%;">Kode Stok</th>
                        <th class="text-start" style="width: 31%;">Nama Produk</th>
                        <th class="text-start" style="width: 26%;">Harga Jual Satuan</th>
                        <th class="text-start" style="width: 16%;">Sisa</th>
                        <th class="text-start" style="width: 6%;"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @if($stokData->count() > 0)
        @foreach($stokData as $index => $stok)
            <div class="card {{ $index === 0 ? 'mt-3' : 'mt-2' }} responsive-margin-end">
                <div class="card-body py-2">
                    <table class="w-100">
                        <tbody>
                            <tr>
                                <td class="text-start" style="width: 21%;">{{ $index + 1 }}</td>
                                <td class="text-start" style="width: 31%;">{{ $stok->nama }}</td>
                                <td class="text-start" style="width: 26%;">Rp. {{ number_format($stok->nominal, 0, ',', '.') }}</td>
                                <td class="text-start" style="width: 16%;">{{ $stok->sisa }}</td>
                                <td class="text-start" style="width: 6%;">
                                    <div class="d-flex gap-4">
                                        <button type="button" class="btn p-0 icon-default-button" style="border: none" data-bs-toggle="modal" data-bs-target="#editModal{{ $stok->stok_id }}">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <button data-bs-toggle="modal" data-bs-target="#deleteModal{{ $stok->stok_id }}" class="btn p-0 delete-button" style="border: none">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal fade" id="editModal{{ $stok->stok_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content pl-3 pr-3">
                        <div class="modal-header justify-content-center">
                            <p class="modal-title" id="exampleModalLabel">Detail Stok Barang</p>
                        </div>
                        <form action="{{ route('stok.update', $stok->stok_id) }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="modal-body">
                                <div class="form-group position-relative mb-2">
                                    <label for="kodeTransaksi" class="col-form-label" id="inputModalLabel">Kode Transaksi</label>
                                    <input type="text" class="form-control border-style" id="kodeTransaksi" name="kodeTransaksi" value="{{ $index + 1 }}" disabled>
                                </div>
                                <div class="form-group position-relative mb-2">
                                    <label for="nama" class="col-form-label" id="inputModalLabel">Nama Produk</label>
                                    <input type="text" class="form-control border-style" id="nama" name="nama" value="{{ $stok->nama }}" required>
                                    <div class="mt-1" id="product-check-message" style="color: red;"></div>
                                </div>
                                <div class="form-group position-relative mb-2">
                                    <label for="nominal" class="col-form-label" id="inputModalLabel">Harga Jual Satuan</label>
                                    <input type="text" class="form-control border-style nominal" id="nominal" name="nominal" value="Rp. {{ number_format($stok->nominal, 0, ',', '.') }},-" required>
                                </div>
                                <div class="form-group position-relative mb-2">
                                    <label for="sisa" class="col-form-label" id="inputModalLabel">Sisa</label>
                                    <div class="input-group input-group-outline border-style">
                                        <button class="btn decrement" type="button">
                                            <span class="iconify" data-icon="ph:minus-bold" data-width="24" data-height="24"></span>
                                        </button>
                                        <input type="text" class="form-control border-style text-center sisa" id="sisa" name="sisa" value="{{ $stok->sisa }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required min="0">
                                        <button class="btn increment" type="button">
                                            <span class="iconify" data-icon="ic:round-plus" data-width="24" data-height="24"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer mb-2">
                                <button type="button" class="btn btn-primary custom-btn mt-2 btn-closed footer-button" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary custom-btn mt-2 footer-button">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteModal{{ $stok->stok_id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body ps-4 pe-4 pb-4">
                            <center>
                                <i class="bi bi-exclamation-triangle-fill" style="font-size: 5rem; color: red"></i>
                            </center>

                            <h4 class="fw-bold text-center">Apakah Anda yakin ingin menghapus stok ini?</h4>

                            <div class="d-flex justify-content-center gap-4 mt-4">
                                <button class="btn fw-semibold cancel-btn" data-bs-dismiss="modal">Tidak</button>

                                <form method="POST" action="{{ route('stok.delete', $stok->stok_id) }}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="btn fw-semibold confirm-btn">Ya</button>
                                @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary custom-btn mt-5 mb-5 responsive-margin-end float-end" data-bs-toggle="modal" data-bs-target="#addStok">Tambah</button>
    @else
        <div class="card mt-3 responsive-margin-end">
            <div class="card-body py-2 m-3">
                <center>
                    <div class="mb-1"><img src="/assets/no-data.png" alt="NO-DATA" style="width:100px"></div>
                    <p class="fw-bold mb-2" style="font-size: 1.5rem">Oops..!</p>
                    <p class="fw-semibold mb-5">Saat ini belum ada data stok barang nih. Yuk, tambahkan stok barangmu untuk mulai mencatat!</p>
                    <button type="submit" class="btn btn-primary custom-btn" data-bs-toggle="modal" data-bs-target="#addStok">Tambah</button>
                </center>
            </div>
        </div>
    @endif

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <div class="modal fade" id="addStok" tabindex="-1" aria-labelledby="addStokModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body ps-4 pe-4 pb-4">
                    <center>
                        <i class="bi bi-info-circle-fill" style="font-size: 5rem; color: #1E0342;"></i>
                    </center>
                    <p class="fw-normal text-center ps-3 pe-3 pb-3 pt-3" style="background-color: #E1F7F5; border-radius: 10px">Tambah stok dapat dilakukan di Halaman Utama dengan menekan tombol <strong>Tambah Pengeluaran</strong></p>
                    <div class="d-flex justify-content-center gap-4 mt-4">
                        <form action="{{ route('Dashboard') }}" method="GET">
                            <input type="hidden" name="status" value="1">
                            <button type="submit" class="btn btn-primary custom-btn-modal-onboarding">Lanjut</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('[id^="editModal"]').on('show.bs.modal', function () {
                const modal = $(this);
                modal.find('#product-check-message').text('');
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stockData = @json($stokData->map(fn($stok) => ['stok_id' => $stok->stok_id, 'nama' => $stok->nama]));

            // Function to check for duplicate names
            function checkDuplicateName(inputField, currentStockId) {
                // Use querySelector within the modal to get the correct message element
                const modal = inputField.closest('.modal');
                const message = modal.querySelector('#product-check-message'); 
                const inputName = inputField.value.toLowerCase();

                // Check if the name already exists in other stocks
                const duplicate = stockData.some(stock =>
                    stock.nama.toLowerCase() === inputName && stock.stok_id !== currentStockId
                );

                if (duplicate) {
                    message.textContent = "Stok dengan nama ini sudah tersedia!";
                } else {
                    message.textContent = ""; // Clear the message
                }
            }

            // Attach listeners to all edit modals
            stockData.forEach(stock => {
                const modal = document.querySelector(`#editModal${stock.stok_id}`);
                const nameInput = modal.querySelector('#nama');

                nameInput.addEventListener('input', function () {
                    checkDuplicateName(nameInput, stock.stok_id);
                });
            });
        });
    </script>

    <script>
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function(event) {
                let nominalFields = form.querySelectorAll('#nominal');  // Select nominal and nominalPengeluaran within the current form

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
        $('[id^="editModal"]').on('submit', function(e) {
            var form = $(this);

            // Check if the nominal field is empty
            if (form.find('#nominal').val() === '') {
                e.preventDefault();
                alert('Silahkan isi nominal terlebih dahulu!');
                return;
            }

            // Check if the product-check-message has any content
            var message = form.find('#product-check-message').text().trim();
            if (message !== '') {
                e.preventDefault();
                alert('Stok dengan nama ini sudah tersedia! Silahkan masukkan nama lain.');
                return;
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            var originalNominalValue = ''; // Variable to store the original value
            var originalNamaValue = '';
            var originalSisaStokValue = '';

            // When any edit modal is shown, store the original value
            $(document).on('show.bs.modal', '[id^="editModal"]', function() {
                var modal = $(this);
                originalNominalValue = modal.find('#nominal').val(); // Capture the original value
                originalNamaValue = modal.find('#nama').val();
                originalSisaStokValue = modal.find('#sisa').val();
            });

            // When any edit modal is hidden (closed without form submission), restore the original value
            $(document).on('hidden.bs.modal', '[id^="editModal"]', function() {
                var modal = $(this);
                modal.find('#nominal').val(originalNominalValue); // Restore the original value
                modal.find('#nama').val(originalNamaValue);
                modal.find('#sisa').val(originalSisaStokValue);
            });

            $(document).on('input', '.nominal', enforceNumericInput);
            $(document).on('blur', '.nominal', addCurrencySuffix);
            $(document).on('input', '.sisa', handleSisaInput);
            $(document).on('input', '#nama', enforceInputDeskripsi);

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
            function enforceNumericInput(event) {
                var input = event.target;
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

                // Limit the input to the first 9 digits
                if (numberValue.length > 9) {
                    numberValue = numberValue.slice(0, 9); // Keep only the first 9 characters
                    alert('Batas maksimum input harga jual barang adalah 9 digit angka!');
                }

                // Format the number with dots as thousand separators
                var formattedValue = numberValue.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                // Update the input value with the formatted number
                input.value = 'Rp. ' + formattedValue;
            }

            function handleSisaInput(event) {
                var input = event.target;
                var value = input.value;

                // Allow only numeric input
                var numberValue = value.replace(/\D/g, '');

                // If input starts with '0' and is not just '0', remove the leading '0'
                if (numberValue.startsWith('0') && numberValue.length > 1) {
                    numberValue = numberValue.replace(/^0+/, '');
                }

                // If the input becomes empty, default back to '0'
                if (numberValue === '') {
                    numberValue = '0';
                }

                if (numberValue.length > 5) {
                    numberValue = numberValue.slice(0, 5);
                    alert('Batas maksimum input jumlah stok barang adalah 5 digit angka!');
                }

                // Update the input value
                input.value = numberValue;
            }

            function addCurrencySuffix() {
                var input = event.target;
                var value = input.value;

                // Ensure the value ends with ",-"
                if (value.length > 4 && !value.endsWith(',-')) {
                    input.value = value + ',-';
                }
            }

            // Event delegation for increment and decrement buttons inside the modal
            $(document).on('click', '.increment', function () {
                var input = $(this).closest('.input-group').find('input#sisa');
                var currentVal = parseInt(input.val()) || 0;
                if (currentVal < 99999) {
                    input.val(currentVal + 1);
                } else {
                    alert('Batas maksimum input jumlah stok barang adalah 5 digit angka!');
                }
            });

            $(document).on('click', '.decrement', function () {
                var input = $(this).closest('.input-group').find('input#sisa');
                var currentVal = parseInt(input.val()) || 0;
                if (currentVal > 0) {
                    input.val(currentVal - 1);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // handle for when error happens in the backend
            $('#alertModal').on('hidden.bs.modal', function() {
                @if (session('errorDataUpdate'))
                    const errorData = @json(session('errorDataUpdate'));
                    $('#editModal' + errorData.id).modal('show'); 
                    $('#editModal' + errorData.id).attr('action', `{{ url('/stok/update') }}/${errorData.id}`);
                    $('#kodeTransaksi').val(errorData.id);
                    $('#nama').val(errorData.nama);
                    $('#nominal').val(errorData.nominal);
                    $('#sisa').val(errorData.sisa);
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

        $(document).ready(function () {
            $("#deleteModal").on("show.bs.modal", function (e) {
                var id = $(e.relatedTarget).data('target-id');
                $('#pass_id').val(id);
            });
        });
    </script>
</x-layout>
