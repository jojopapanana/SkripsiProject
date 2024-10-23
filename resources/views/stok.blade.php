<x-layout title="Stok">
    <div class="d-flex justify-content-center" style="width: 70vw">
        <h1 class="fw-bold">STOK BARANG</h1>
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
                                        <button data-bs-toggle="modal" data-bs-target="#deleteModal{{ $stok->stok_id }}" class="btn p-0" style="color: red; border: none">
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
                <div class="modal-dialog modal-dialog-centered custom-modal-width">
                    <div class="modal-content pl-3 pr-3">
                        <div class="modal-header justify-content-center">
                            <p class="modal-title" id="exampleModalLabel">Ubah Stok</p>
                        </div>
                        <form action="{{ route('stok.update', $stok->stok_id) }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="modal-body">
                                <div class="form-group position-relative mb-2">
                                    <label for="kodeTransaksi" class="col-form-label" id="inputModalLabel">Kode Transaksi</label>
                                    <input type="text" class="form-control border-style" id="kodeTransaksi" placeholder="{{$stok->stok_id}}" disabled>
                                </div>
                                <div class="form-group position-relative mb-2">
                                    <label for="nama" class="col-form-label" id="inputModalLabel">Nama Produk</label>
                                    <input type="text" class="form-control border-style" id="nama" name="nama" value="{{ $stok->nama }}" required>
                                </div>
                                <div class="form-group position-relative mb-2">
                                    <label for="nominal" class="col-form-label" id="inputModalLabel">Nominal</label>
                                    <input type="text" class="form-control border-style" id="nominal" name="nominal" value="Rp. {{ number_format($stok->nominal, 0, ',', '.') }},-" required>
                                </div>
                                <div class="form-group position-relative mb-4">
                                    <label for="sisa" class="col-form-label" id="inputModalLabel">Sisa Stok</label>
                                    <div class="input-group input-group-outline border-style">
                                        <button class="btn decrement" type="button">
                                            <span class="iconify" data-icon="ph:minus-bold" data-width="24" data-height="24"></span>
                                        </button>
                                        <input type="text" class="form-control border-style text-center" id="sisa" name="sisa" value="{{ $stok->sisa }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required min="1">
                                        <button class="btn increment" type="button">
                                            <span class="iconify" data-icon="ic:round-plus" data-width="24" data-height="24"></span>
                                        </button>
                                    </div>
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

            <div class="modal fade" id="deleteModal{{ $stok->stok_id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <center>
                                <i class="bi bi-exclamation-triangle-fill" style="font-size: 5rem; color: red"></i>
                            </center>

                            <h4 class="fw-bold text-center">Apakah Anda yakin ingin menghapus stok ini?</h4>

                            <div class="d-flex justify-content-center gap-4 mt-4">
                                <button class="btn fw-semibold" style="border: 2px solid black; width: 5vw" data-bs-dismiss="modal">Tidak</button>

                                <form method="POST" action="{{ route('stok.delete', $stok->stok_id) }}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="btn fw-semibold" style="background-color: rgba(210, 0, 0, 1); width: 5vw; color: white">Ya</button>
                                @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <br>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

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

                if (form.find('#nominal').val() === '') {
                    e.preventDefault();
                    alert('Silahkan isi nominal terlebih dahulu!');
                    return;
                }
            });
        </script>

        <script>
            $(document).ready(function() {
                // Enforce minimum value of 1 for #sisa input field
                $('#sisa').on('input', function() {
                    let sisaValue = $(this).val();

                    // If the value is less than 1, reset it to 1
                    if (parseInt(sisaValue) < 1) {
                        $(this).val(1);
                    }
                });
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

                $('#nominal').on('keydown', preventBackspace);
                $('#nominal').on('input', enforceNumericInput);
                $('#nominal').on('blur', addCurrencySuffix);

                // Function to enforce numeric input
                function enforceNumericInput(input) {
                    var input = event.target;
                    var value = input.value;

                    // Remove any non-digit characters except the prefix
                    var numberValue = value.slice(4).replace(/\D/g, '');

                    // Restrict the input to prevent entering numbers starting with 0 (except 0 itself)
                    if (numberValue.startsWith('0')) {
                        numberValue = ''; // If first character is 0, restrict the rest of the input
                    }

                    // Format the number with dots as thousand separators
                    var formattedValue = numberValue.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                    // Update the input value with the formatted number
                    input.value = 'Rp. ' + formattedValue;
                }

                function addCurrencySuffix() {
                    var input = event.target;
                    var value = input.value;

                    // Ensure the value ends with ",-"
                    if (value.length > 4 && !value.endsWith(',-')) {
                        input.value = value + ',-';
                    }
                }

                // Function to prevent deleting the "Rp. " prefix
                function preventBackspace(input, event) {
                    // Prevent user from deleting the "Rp. " prefix using backspace or delete key
                    if (input.selectionStart <= 4 && (event.key === 'Backspace' || event.key === 'Delete')) {
                        event.preventDefault();
                    }
                }

                // Event delegation for increment and decrement buttons inside the modal
                $(document).on('click', '.increment', function () {
                    var input = $(this).closest('.input-group').find('input#sisa');
                    var currentVal = parseInt(input.val()) || 1;
                    input.val(currentVal + 1);
                });

                $(document).on('click', '.decrement', function () {
                    var input = $(this).closest('.input-group').find('input#sisa');
                    var currentVal = parseInt(input.val()) || 1;
                    if (currentVal > 1) {
                        input.val(currentVal - 1);
                    }
                });
            });
        </script>

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
    </div>
</x-layout>
