
<x-layout title="Halaman Utama">
    <h1 class="fw-bold">HALAMAN UTAMA</h1>

    <div class="d-flex gap-4">
        <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-top">
                <div>
                    <h4 class="fw-semibold">Pendapatan bersihmu per hari ini</h4>
                    <h4 class="fw-bold" style="color: rgba(14, 70, 163, 1)">Rp. {{ number_format($pendapatan_bersih_bulanan, 0, ',', '.') }}</h4>
                </div>

                <img src="/assets/profits.png" alt="MONEY-PROFIT" style="width: 60px; height: 60px">
            </div>
        </div>

        <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-top">
                <div>
                    <h4 class="fw-semibold">Kasmu per hari ini</h4>
                    <h4 class="fw-bold" style="color: rgba(14, 70, 163, 1)">Rp. {{ number_format($kas_bulanan, 0, ',', '.') }}</h4>
                </div>

                <img src="/assets/wallet.png" alt="WALLET" style="width: 60px; height: 60px">
            </div>
        </div>
    </div>

    <div class="dashboard-trenkeuntungan">
        <h3 class="fw-bold" style="font-size: 25px; margin-bottom: 20px;">Tren Pendapatan-mu Bulan Ini!</h3>
        @if($data->isNotEmpty())
            <canvas id="myChart" style="width: 60vw; height: 30vh"></canvas>
        @else
            <div class="card mt-3">
                <div class="card-body py-2 m-3">
                    <center>
                        <div class="mb-1" style="margin-top: 13.5px"><img src="/assets/bar-graph.png" alt="BAR-GRAPH" style="width:150px"></div>
                        <p class="fw-semibold mb-2" style="font-size: 25px; padding-bottom: 13.5px">Belum ada data analisis nih!</p>
                    </center>
                </div>
            </div>
        @endif
    </div>

    <div class="d-flex justify-content-between" style="margin-top: 70px">
        <button type="button" class="btn btn-primary custom-modal-btn mr-2" data-toggle="modal" data-target="#modalityPemasukan">
            Tambah Pemasukan
        </button>
        <button type="button" class="btn btn-primary custom-modal-btn" data-toggle="modal" data-target="#modalityPengeluaran">
            Tambah Pengeluaran
        </button>
    </div>

    <!-- Modal Pemasukan -->
    <div class="modal fade" id="modalityPemasukan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered custom-modal-width" role="document">
            <div class="modal-content pl-3 pr-3">
                <div class="modal-header justify-content-center">
                    <p class="modal-title" id="exampleModalLabel">Tambah Transaksi</p>
                </div>
                <form id="formInput" action="{{ route('transaksi.store') }}" method="POST" class="mb-2">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="modalType" value="pemasukan">
                        <div class="form-group position-relative mb-2">
                            <label for="tanggal" class="col-form-label" id="inputModalLabel">Tanggal</label>
                            <input type="text" class="form-control border-style tanggal" name="tanggal" id="tanggal" value="" readonly>
                        </div>
                        <div class="form-group position-relative mb-2">
                            <label for="jenisTransaksi" class="col-form-label" id="inputModalLabel">Jenis Transaksi</label>
                            <input type="text" class="form-control border-style" id="jenisTransaksi" name="jenisTransaksi" value="Pemasukan" readonly>
                        </div>
                        <div class="form-group-select position-relative mb-2 mt-4">
                            <div class=" d-flex justify-content-between align-items-center">
                                <label for="daftarBarang" class="col-form-label" id="inputModalLabel">Daftar Barang</label>
                                <button class="btn p-0 d-flex align-items-center" type="button" id="addDaftarBarang">
                                    <span class="ms-2 mt-1 mb-1 iconify" data-icon="ph:plus-fill" data-width="20" data-height="20"></span>
                                    <span class="ms-1 me-2">Tambah Barang</span>
                                </button>
                            </div>
                            <table class="table mt-2" id="barangTable">
                                <thead>
                                  <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Jenis Barang</th>
                                    <th scope="col">Jumlah</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <th scope="row">1</th>
                                    <td>
                                        <select class="form-control border-style-jenisBarang" id="jenisBarang" name="jenisBarang[]">
                                            <option value="None">None</option>
                                            @foreach($products as $product)
                                                @if($product->productStock > 0)
                                                    <option value="{{ $product->id }}" data-stock="{{ $product->productStock }}" data-price="{{ $product->productPrice }}">{{ $product->productName }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <div class="input-group-pemasukan input-group-outline-pemasukan border-style-jenisBarangJumlah">
                                            <button class="btn" type="button" id="decrement">
                                                <span class="iconify" data-icon="ph:minus-bold" data-width="20" data-height="20"></span>
                                            </button>
                                            <input type="text" class="form-control border-style-jenisBarangJumlah text-center" name="jumlahBarang[]" id="jumlahBarang" value="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required min="1">
                                            <button class="btn" type="button" id="increment">
                                                <span class="iconify" data-icon="ic:round-plus" data-width="20" data-height="20"></span>
                                            </button>
                                        </div>
                                        <div class="overlay-button">
                                            <button type="button" class="btn delete-button" style="font-size: 1.2rem;">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                  </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group position-relative mb-2">
                            <label for="nominal" class="col-form-label" id="inputModalLabel">Total Harga Barang</label>
                            <input type="text" class="form-control border-style" id="nominal" name="nominal" value="Rp. 0,-" readonly>
                        </div>
                        <div class="form-group-select position-relative mb-2">
                            <label for="metode" class="col-form-label" id="inputModalLabel">Metode</label>
                            <select class="form-control border-style" id="metode" name="metode">
                                @foreach($payment_methods as $method)
                                    <option value="{{ $method->name }}">{{ $method->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer mb-2">
                        <button type="button" class="btn btn-primary custom-btn mt-2 btn-closed" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary custom-btn mt-2">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Pengeluaran -->
    <div class="modal fade" id="modalityPengeluaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered custom-modal-width" role="document">
            <div class="modal-content pl-3 pr-3">
                <div class="modal-header justify-content-center">
                    <p class="modal-title" id="exampleModalLabel">Tambah Transaksi</p>
                </div>
                <form id="formInputPengeluaran" action="{{ route('transaksi.store') }}" method="POST" class="mb-2">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="modalType" value="pengeluaran">
                        <div class="form-group position-relative mb-2">
                            <label for="tanggal" class="col-form-label" id="inputModalLabel">Tanggal</label>
                            <input type="text" class="form-control border-style tanggal" id="tanggal" name="tanggal" value="" readonly>
                        </div>
                        <div class="form-group position-relative mb-2">
                            <label for="jenisTransaksi" class="col-form-label" id="inputModalLabel">Jenis Transaksi</label>
                            <input type="text" class="form-control border-style" id="jenisTransaksi" name="jenisTransaksi" value="Pengeluaran" readonly>
                        </div>
                        <div class="form-group-select position-relative mb-2">
                            <label for="deskripsi" class="col-form-label" id="inputModalLabel">Deskripsi</label>
                            <select class="form-control border-style" id="deskripsi" name="deskripsi">
                                <option value="Tambah Stok">Tambah Stok</option>
                                <option value="Tambah Stok Baru">Tambah Stok Baru</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        
                        <input type="hidden" name="modalType1" value="tambahStok">
                        <div id="dynamicFields">
                            <div class="form-group-select position-relative mb-2" id="jenisBarangField">
                                <label for="jenisBarangPengeluaran" class="col-form-label" id="inputModalLabel">Jenis Barang</label>
                                <select class="form-control border-style" id="jenisBarangPengeluaran" name="jenisBarangPengeluaran">
                                    <option value="None">None</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-stock="{{ $product->productStock }}" data-price="{{ $product->productPrice }}">{{ $product->productName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group position-relative mb-2" id="jumlahBarangField">
                                <label for="jumlahBarangPengeluaran" class="col-form-label" id="inputModalLabel">Jumlah Barang</label>
                                <div class="input-group input-group-outline border-style">
                                    <button class="btn" type="button" id="decrementPengeluaran">
                                        <span class="iconify" data-icon="ph:minus-bold" data-width="24" data-height="24"></span>
                                    </button>
                                    <input type="text" class="form-control border-style text-center" id="jumlahBarangPengeluaran" name="jumlahBarangPengeluaran" value="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required min="1">
                                    <button class="btn" type="button" id="incrementPengeluaran">
                                        <span class="iconify" data-icon="ic:round-plus" data-width="24" data-height="24"></span>
                                    </button>
                                </div>
                            </div>

                            <div class="form-group position-relative mb-2" id="nominalField">
                                <label for="nominalPengeluaran" class="col-form-label" id="inputModalLabel">Total Harga Beli Barang</label>
                                <input type="text" class="form-control border-style" id="nominalPengeluaran" name="nominalPengeluaran" value="Rp. " autocomplete="off">
                            </div>
                            <div class="form-group-select position-relative mb-2">
                                <label for="metode" class="col-form-label" id="inputModalLabel">Metode</label>
                                <select class="form-control border-style" id="metode" name="metode">
                                    @foreach($payment_methods as $method)
                                        <option value="{{ $method->name }}">{{ $method->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mb-2">
                        <button type="button" class="btn btn-primary custom-btn mt-2 btn-closed" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary custom-btn mt-2">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery, Popper.js, and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Iconify icon -->
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

    <!-- Lottie animation -->
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>

    <!-- Alert Modal Component -->
    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="okModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body ps-4 pe-4 pb-4">
                    <center>
                        <i class="bi bi-check-circle-fill" style="font-size: 5rem; color: rgb(0, 205, 0)"></i>
                    </center>
                    <h4 class="fw-bold text-center" id="modalText">Default Text</h4>
                    <div class="d-flex justify-content-center gap-4 mt-4">
                        <button class="btn fw-semibold cancel-btn" data-dismiss="modal">Oke</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="module">
        const data = {
            labels: @json($data->map(fn ($data) => date('Y-m-d', strtotime($data->date)))),
            datasets: [{
                label: 'Pendapatan dalam bulan ini',
                backgroundColor: 'rgba(30, 3, 66, 1)',
                borderColor: 'rgba(30, 3, 66, 1)',
                data: @json($data->map(fn ($data) => $data->total)),
            }]
        };

        const config = {
            type: 'bar',
            data: data
        };
        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    </script>

    <div class="modal fade" id="onboarding-modal-1" tabindex="-1" role="dialog" aria-labelledby="okModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered custom-modal-size" role="document">
            <div class="modal-content">
                <div class="modal-body ps-4 pe-4 pb-4">
                    <div class="icon-container">
                        <img src="/assets/dark icon.png" alt="LOGO" class="icon-size">
                    </div>
                    <h4 class="fw-bold text-center" id="modalText">Selamat Datang di BukuKasUMKM</h4>
                    <div class="d-flex justify-content-center gap-4 custom-button-container">
                        <button class="btn btn-primary custom-btn-modal-onboarding" id="nextModalButton">Lanjut</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="onboarding-modal-2" tabindex="-1" role="dialog" aria-labelledby="okModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered custom-modal-size" role="document">
            <div class="modal-content">
                <div class="modal-body ps-4 pe-4 pb-4">
                    <h3 class="fw-bold text-center" id="modalText">Hampir Selesai</h3>
                    <center class="custom-lottie-container">
                        <dotlottie-player src="https://lottie.host/7901cec0-c27f-418f-bb0f-04ea92357c73/Ns0p3a4GrY.json" background="transparent" speed="1.5" style="width: 150px; height: 150px;" loop autoplay></dotlottie-player>
                    </center>
                    <h5 class="fw-bold text-center" id="modalText">Silahkan lengkapi 'Data Stok Barang' untuk melanjutkan!</h5>
                    <div class="d-flex justify-content-center gap-4 custom-button-container">
                        <button class="btn btn-primary custom-btn-modal-onboarding" id="nextModalButton-1">Lengkapi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="onboarding-modal-3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered custom-modal-width" role="document">
            <div class="modal-content pl-3 pr-3">
                <div class="modal-header justify-content-center">
                    <p class="modal-title" id="exampleModalLabel">Daftar Stok Barang</p>
                </div>
                <form id="formInputOnboarding" action="{{ route('transaksi.store') }}" method="POST" class="mb-2">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="modalType" value="onboarding">
                        <div class="form-group-select position-relative mb-2 mt-4">
                            <div class=" d-flex justify-content-between align-items-center">
                                <label for="daftarBarang" class="col-form-label" id="inputModalLabel">Daftar Barang</label>
                                <button class="btn p-0 d-flex align-items-center" type="button" id="addDaftarBarangOnboarding">
                                    <span class="ms-2 mt-1 mb-1 iconify" data-icon="ph:plus-fill" data-width="20" data-height="20"></span>
                                    <span class="ms-1 me-2">Tambah Barang</span>
                                </button>
                            </div>
                            <table class="table mt-2" id="barangTableOnboarding">
                                <thead>
                                <tr>
                                    <th scope="col" style="width: 8%">No.</th>
                                    <th scope="col">Jenis Barang</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col" style="width: 30%">Harga Jual Satuan</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>
                                        <input type="text" class="form-control border-style-jenisBarang-onboarding" name="namaBarangOnboarding[]" id="namaBarangOnboarding"  value="None" required>
                                    </td>
                                    <td>
                                        <div class="input-group-pemasukan input-group-outline-pemasukan border-style-jenisBarangJumlah">
                                            <button class="btn decrement" type="button">
                                                <span class="iconify" data-icon="ph:minus-bold" data-width="20" data-height="20"></span>
                                            </button>
                                            <input type="text" class="form-control border-style-jenisBarangJumlah text-center jumlahBarang" name="jumlahBarangOnboarding[]" id="jumlahBarangOnboarding" value="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required min="1">
                                            <button class="btn increment" type="button">
                                                <span class="iconify" data-icon="ic:round-plus" data-width="20" data-height="20"></span>
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control border-style-jenisBarang-onboarding" name="nominalHargaBarangOnboarding[]" id="nominalHargaBarangOnboarding" value="Rp. " required>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn delete-button" style="font-size: 1.2rem;">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer mb-2">
                        <button type="submit" class="btn btn-primary custom-btn mt-2">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            @if ($isOnboarded == 0) 
                $('#onboarding-modal-1').modal('show');

                $('#nextModalButton').on('click', function() {
                    $('#onboarding-modal-1').modal('hide');
                    $('#onboarding-modal-2').modal('show');
                });

                $('#nextModalButton-1').on('click', function() {
                    $('#onboarding-modal-2').modal('hide');
                    $('#onboarding-modal-3').modal('show');
                });

                $('#formInputOnboarding').on('submit', function() {
                    localStorage.setItem('onboardingCompleted', 'true');
                });
            @endif
        });
    </script>

    <!-- check for auto open modal pengeluaran untuk tambah stok-->
    <script>
        $(document).ready(function () {
            // Check for the "status" parameter in the URL
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');

            if (status === '1') {
                // Show the modal if "status=1" is in the URL
                $('#modalityPengeluaran').modal('show');

                // Remove the "status" parameter from the URL to prevent reopening on refresh
                const newUrl = window.location.origin + window.location.pathname;
                window.history.replaceState({}, document.title, newUrl);
            }

            // Close the modal when "Tutup" is clicked
            $('#modalityPengeluaran .btn-closed').on('click', function () {
                $('#modalityPengeluaran').modal('hide');
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Enforce minimum value of 1 for dynamically added input fields
            $(document).on('input', 'input[name="jumlahBarang[]"], input[name="jumlahBarangOnboarding[]"]', function() {
                var input = $(this).closest('tr').find('input[name="jumlahBarangOnboarding[]"], input[name="jumlahBarang[]"]');

                let sisaValue = input.val();

                // If the value is less than 1, reset it to 1
                if (parseInt(sisaValue) < 1 || isNaN(sisaValue)) {
                    $(this).val(1);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Enforce minimum value of 1 for dynamically added input fields
            $(document).on('input', '#jumlahBarangPengeluaran', function() {
                let sisaValue = $(this).val();

                // If the value is less than 1, reset it to 1
                if (parseInt(sisaValue) < 1 || isNaN(sisaValue)) {
                    $(this).val(1);
                }
            });
        });
    </script>

    <!-- daftar barang onboarding event handler -->
    <script>
        $(document).ready(function () {
            // Apply input formatting to nominalHargaBarangOnboarding inputs
            $(document).on('keydown', 'input[name="nominalHargaBarangOnboarding[]"]', function (event) {
                if (!preventInvalidOperations(event)) {
                    return; // Stop further execution if preventInvalidOperations returns false
                }

                // preventBackspace(this, event);
            });

            $(document).on('input', 'input[name="nominalHargaBarangOnboarding[]"]', function () {
                enforceNumericInput(this);
            });

            $(document).on('blur', 'input[name="nominalHargaBarangOnboarding[]"]', function () {
                addCurrencySuffix(this);
            });

            // Function to enforce numeric input
            function enforceNumericInput(input) {
                var value = input.value;

                // Remove any non-digit characters except the prefix
                var numberValue = value.slice(4).replace(/\D/g, '');

                // Restrict the input to prevent entering numbers starting with 0 (except 0 itself)
                if (numberValue.startsWith('0')) {
                    numberValue = ''; // If first character is 0, restrict the rest of the input
                }

                // Limit the input to the first 9 digits
                if (numberValue.length > 9) {
                    numberValue = numberValue.slice(0, 9); // Keep only the first 9 characters
                }

                // Format the number with dots as thousand separators
                var formattedValue = numberValue.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                // Update the input value with the formatted number
                input.value = 'Rp. ' + formattedValue;
            }

            // Function to add ",-" suffix on blur
            function addCurrencySuffix(input) {
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

            // Prevent increment/decrement if the namaBarangOnboarding[] field is empty or set to "None"
            function preventInvalidOperations(event) {
                var row = $(event.target).closest('tr'); // Find the closest row
                var jenisBarangInput = row.find('input[name="namaBarangOnboarding[]"]'); // Select the corresponding namaBarang input
                var jenisBarang = jenisBarangInput.val(); // Get the value of the input

                // Check if the input is undefined or empty or contains "None"
                if (jenisBarang.trim() === '' || jenisBarang === 'None') {
                    alert('Silahkan ketik nama barang terlebih dahulu!');
                    event.preventDefault();  // Prevent the action (increment, decrement, etc.)
                    return false;
                }

                return true;
            }

            function preventNullAndMaxInput(event) {
                var input = event.target;
                var value = input.value

                if (input.value === '') {
                    input.value = 1
                }

                if (value.length > 5) {
                    value = value.slice(0, 5);
                    input.value = value
                }
            }

            // Event to add a new row to the onboarding table
            $('#addDaftarBarangOnboarding').on('click', function () {
                var rowCount = $('#barangTableOnboarding tbody tr').length + 1;

                var newRow = `
                    <tr data-input-value="1">
                        <!-- Set the initial input value for this row -->
                        <th scope="row">${rowCount}</th>
                        <td>
                            <input type="text" class="form-control border-style-jenisBarang-onboarding" name="namaBarangOnboarding[]" value="None" required>
                        </td>
                        <td>
                            <div class="input-group-pemasukan input-group-outline-pemasukan border-style-jenisBarangJumlah">
                                <button class="btn decrement" type="button">
                                    <span class="iconify" data-icon="ph:minus-bold" data-width="20" data-height="20"></span>
                                </button>
                                <input type="text" class="form-control border-style-jenisBarangJumlah text-center jumlahBarang" name="jumlahBarangOnboarding[]" value="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required min="1">
                                <button class="btn increment" type="button">
                                    <span class="iconify" data-icon="ic:round-plus" data-width="20" data-height="20"></span>
                                </button>
                            </div>
                        </td>
                        <td>
                            <input type="text" class="form-control border-style-jenisBarang-onboarding" name="nominalHargaBarangOnboarding[]" value="Rp. " required>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn delete-button" style="font-size: 1.2rem;">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </td>
                    </tr>
                `;

                // Append the new row to the table body
                $('#barangTableOnboarding tbody').append(newRow);
            });

            // Event delegation for increment and decrement buttons
            $(document).on('click', '.increment', function (event) {
                if (!preventInvalidOperations(event)) {
                    return; // Stop further execution if preventInvalidOperations returns false
                }

                var input = $(this).closest('tr').find('input[name="jumlahBarangOnboarding[]"]');
                var currentVal = parseInt(input.val()) || 1;

                if (currentVal < 99999) {
                    input.val(currentVal + 1);
                }
            });

            $(document).on('click', '.decrement', function (event) {
                if (!preventInvalidOperations(event)) {
                    return; // Stop further execution if preventInvalidOperations returns false
                }

                var input = $(this).closest('tr').find('input[name="jumlahBarangOnboarding[]"]');
                var currentVal = parseInt(input.val()) || 1;
                if (currentVal > 1) {
                    input.val(currentVal - 1);
                }
            });

            // Event delegation to handle delete button
            $(document).on('click', '#barangTableOnboarding .delete-button', function () {
                var rowCount = $('#barangTableOnboarding tbody tr').length;

                // If there's only one row left, prevent deletion
                if (rowCount === 1) {
                    alert('Baris terakhir Daftar Barang tidak dapat dihapus!');
                    return false;  // Prevent further execution
                }

                // Remove the row if there are multiple rows
                $(this).closest('tr').remove();

                // Update the row numbers after deleting a row
                $('#barangTableOnboarding tbody tr').each(function (index) {
                    $(this).find('th').text(index + 1);
                });
            });

            // Prevent operations on jumlahBarangOnboarding[] if namaBarangOnboarding[] is empty or "None"
            $(document).on('keydown', 'input[name="jumlahBarangOnboarding[]"]', preventInvalidOperations);

            $(document).on('input', 'input[name="jumlahBarangOnboarding[]"]', preventNullAndMaxInput);
        });
    </script>

    <script>
        $('[id^="onboarding-modal-3"]').on('submit', function(e) {
            var form = $(this);
            var hasNoValue = false;
            var hasDuplicates = false;

            // Check for empty or "None" values in 'namaBarangOnboarding[]'
            form.find('input[name="namaBarangOnboarding[]"]').each(function() {
                if ($(this).val() === 'None') {
                    hasNoValue = true;
                    return false;
                }
            });

            // Check for empty values in 'nominalHargaBarangOnboarding[]'
            form.find('input[name="nominalHargaBarangOnboarding[]"]').each(function() {
                if ($(this).val() === '') {
                    hasNoValue = true;
                    return false;
                }
            });

            // Check for duplicate values in 'namaBarangOnboarding[]'
            var values = [];
            form.find('input[name="namaBarangOnboarding[]"]').each(function() {
                var value = $(this).val().trim();
                if (values.includes(value)) {
                    hasDuplicates = true;
                    return false; // Stop the loop once a duplicate is found
                }
                values.push(value);
            });

            if (hasNoValue) {
                e.preventDefault();
                alert('Silahkan lengkapi Daftar Barang terlebih dahulu!');
                return;
            }

            if (hasDuplicates) {
                e.preventDefault();
                alert('Terdapat nama barang yang duplikat. Mohon untuk diperbaiki terlebih dahulu!');
                return;
            }
        });
    </script>

    <!-- initialize tooltip-->
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

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
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function(event) {
                let nominalFields = form.querySelectorAll('#nominal, #nominalPengeluaran, #hargaJualSatuan');

                nominalFields.forEach(function(field) {
                    if (field) {
                        let originalValue = field.value
                        field.value = originalValue.replace(/\D/g, '');
                        setTimeout(function() {
                            field.value = originalValue;
                        }, 0);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('form').on('submit', function(event) {
                $(this).find('input[name="nominalHargaBarangOnboarding[]"]').each(function() {
                    var currentField = $(this);
                    var originalValue = currentField.val();
                    var cleanedValue = originalValue.replace(/\D/g, '');
                    currentField.val(cleanedValue);
                    setTimeout(function() {
                        currentField.val(originalValue);
                    }, 0);
                });
            });
        });
    </script>

    <script>
        $(document).ready(function(){
            var today = new Date();
            var day = String(today.getDate()).padStart(2, '0');
            var month = String(today.getMonth() + 1).padStart(2, '0');
            var year = today.getFullYear();

            today = year + '-' + month + '-' + day;
            $('.tanggal').val(today);
        });
    </script>

    <script>
        $(document).ready(function() {
            var selectedItems = [];

            function updateTotalNominal(revertSkipRow = null) {
                var totalNominal = 0;

                $('#barangTable tbody tr').each(function() {
                    var row = $(this);
                    var jenisBarang = $(this).find('select[name="jenisBarang[]"]');
                    var selectedOption = jenisBarang.find('option:selected');
                    var pricePerItem = parseInt(selectedOption.data('price')) || 0;
                    var productStock = parseInt(selectedOption.data('stock')) || 1;
                    var jumlahBarang = parseInt($(this).attr('data-input-value')) || 1;

                    if (jumlahBarang > productStock) {
                        jumlahBarang = productStock;
                        row.find('input[name="jumlahBarang[]"]').val(productStock);
                    }

                    var nominal = pricePerItem * jumlahBarang;

                    totalNominal += nominal;
                });

                $('#nominal').val('Rp. ' + totalNominal.toLocaleString('id-ID') + ',-');
            }

            function limitInput(event) {
                var input = event.target;
                var row = $(input).closest('tr');
                var currVal = input.value;

                var prevValue = row.attr('data-input-value') || 1;
                var value = parseInt(input.value) || 1;
                var jenisBarang = row.find('select[name="jenisBarang[]"]');
                var selectedOption = jenisBarang.find('option:selected');
                var productStock = parseInt(selectedOption.data('stock')) || 1;

                if (value > productStock) {
                    alert('Jumlah tidak boleh melebihi stok yang tersedia: ' + productStock);
                    input.value = prevValue;
                    return;
                }

                if (input.value === '') {
                    input.value = 1
                }

                row.attr('data-input-value', value);
                updateTotalNominal();
            }

            function preventDeletion(event) {
                var input = event.target;
                var row = $(input).closest('tr');
                var jenisBarang = row.find('select[name="jenisBarang[]"]');
                var selectedOption = jenisBarang.val();

                if (selectedOption === 'None') {
                    alert('Silahkan pilih Jenis Barang terlebih dahulu!');
                    event.preventDefault();
                }
            }

            $('#barangTable').on('click', '#increment, #decrement', function() {
                var button = $(this);
                var row = button.closest('tr');
                var jumlahBarang = row.find('input[name="jumlahBarang[]"]');
                var jenisBarang = row.find('select[name="jenisBarang[]"]');
                var selectedOption = jenisBarang.find('option:selected');
                var productStock = parseInt(selectedOption.data('stock')) || 0;

                if (jenisBarang.val() === 'None') {
                    alert('Silahkan pilih Jenis Barang terlebih dahulu!');
                    return;
                }

                var currentVal = parseInt(jumlahBarang.val()) || 1;

                if (button.attr('id') === 'increment') {
                    if (currentVal < productStock) {
                        currentVal++;
                        jumlahBarang.val(currentVal);
                    } else {
                        alert('Stok tidak mencukupi! Stok tersedia: ' + productStock);
                    }
                } else if (button.attr('id') === 'decrement') {
                    if (currentVal > 1) {
                        currentVal--;
                        jumlahBarang.val(currentVal);
                    }
                }

                row.attr('data-input-value', currentVal);
                updateTotalNominal();
            });

            $('#barangTable').on('input change', 'select[name="jenisBarang[]"], input[name="jumlahBarang[]"]', function() {
                updateTotalNominal();
            });

            $('#barangTable').on('click', '.delete-button', function() {
                var rowCount = $('#barangTable tbody tr').length;

                if (rowCount === 1) {
                    alert('Baris terakhir Daftar Barang tidak dapat dihapus!');
                    return false;
                }

                var row = $(this).closest('tr');
                row.remove(); // Remove the row

                // Recalculate total nominal after a row is removed
                updateTotalNominal();

                // Update row numbers after a row is removed
                $('#barangTable tbody tr').each(function(index) {
                    $(this).find('th').text(index + 1); // Reassign the row number, starting from 1
                });
            });

            // Add a new row dynamically
            $('#addDaftarBarang').on('click', function() {
                var rowCount = $('#barangTable tbody tr').length + 1;

                var newRow = `
                    <tr data-input-value="1"> <!-- Set the initial input value for this row -->
                        <th scope="row">${rowCount}</th>
                        <td>
                            <select class="form-control border-style-jenisBarang" name="jenisBarang[]">
                                <option value="None">None</option>
                                @foreach($products as $product)
                                    @if($product->productStock > 0)
                                        <option value="{{ $product->id }}" data-stock="{{ $product->productStock }}" data-price="{{ $product->productPrice }}">{{ $product->productName }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <div class="input-group-pemasukan input-group-outline-pemasukan border-style-jenisBarangJumlah">
                                <button class="btn" type="button" id="decrement">
                                    <span class="iconify" data-icon="ph:minus-bold" data-width="20" data-height="20"></span>
                                </button>
                                <input type="text" class="form-control border-style-jenisBarangJumlah text-center" name="jumlahBarang[]" value="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required min="1">
                                <button class="btn" type="button" id="increment">
                                    <span class="iconify" data-icon="ic:round-plus" data-width="20" data-height="20"></span>
                                </button>
                            </div>
                            <div class="overlay-button">
                                <button type="button" class="btn delete-button" style="font-size: 1.2rem;">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;

                $('#barangTable tbody').append(newRow);
            });

            // Store the previous selected value and jumlahBarang in data attributes when the select gains focus
            $('#barangTable').on('focus', 'select[name="jenisBarang[]"]', function() {
                var currentRow = $(this).closest('tr');
                currentRow.data('previous', {
                    jenisBarang: $(this).val(),
                    jumlahBarang: currentRow.find('input[name="jumlahBarang[]"]').val() // Store current jumlahBarang as well
                });
            });

            // Handle the selection change
            $('#barangTable').on('change', 'select[name="jenisBarang[]"]', function() {
                var selectedValue = $(this).val();
                var selectedItems = [];
                var currentRow = $(this).closest('tr'); // Get the current row

                // Loop through all rows to gather selected items
                $('#barangTable tbody tr').each(function() {
                    var currentValue = $(this).find('select[name="jenisBarang[]"]').val();

                    // Check if the current row is the same as the row where the event occurred
                    if (!$(this).is(currentRow) && currentValue !== 'None') {
                        selectedItems.push(currentValue); // Add the value if it's not 'None' and not the current row
                    }
                });

                // Check if the selected value already exists in the array
                if (selectedValue !== 'None' && selectedItems.includes(selectedValue)) {
                    alert('Jenis Barang ini sudah ada! Silahkan pilih jenis barang yang berbeda.');

                    // Revert to the previous value stored in the row
                    var previousData = currentRow.data('previous'); // Retrieve both jenisBarang and jumlahBarang
                    $(this).val(previousData.jenisBarang ? previousData.jenisBarang : 'None'); // Set to previous jenisBarang
                    currentRow.find('input[name="jumlahBarang[]"]').val(previousData.jumlahBarang); // Set to previous jumlahBarang
                }

                // Update the previous value for both jenisBarang and jumlahBarang
                currentRow.data('previous', {
                    jenisBarang: selectedValue,
                    jumlahBarang: currentRow.find('input[name="jumlahBarang[]"]').val() // Update to current jumlahBarang
                });

                updateTotalNominal();
            });

            // Prevent deletion when the input value is already 1
            $('#barangTable').on('keydown', 'input[name="jumlahBarang[]"]', preventDeletion);
            // Apply limit input functionality to prevent exceeding stock or invalid numbers
            $('#barangTable').on('input', 'input[name="jumlahBarang[]"]', limitInput);
        });
    </script>

    <script>
        // Prevent form submission if jenisBarang is None
        $('#formInput, #formInputPengeluaran').on('submit', function(e) {
            var form = $(this);

            if (form.is('#formInputPengeluaran')) {
                if (form.find('#jenisBarangPengeluaran').length && form.find('#jenisBarangPengeluaran').val() === 'None') {
                    e.preventDefault();
                    alert('Silahkan pilih Jenis Barang terlebih dahulu!');
                    return;
                }
                if (form.find('#stokBaru').length) {
                    const products = @json($products->pluck('productName'));
                    const lowerCaseProducts = products.map(name => name.toLowerCase());
                    const stokBaruLowerCase = form.find('#stokBaru').val().toLowerCase();

                    if (lowerCaseProducts.includes(stokBaruLowerCase)) {
                        e.preventDefault();
                        alert('Stok dengan nama ini sudah tersedia! Silahkan masukkan nama lain.');
                        return;
                    }
                }
                if (form.find('#nominalPengeluaran').val() === '' || form.find('#hargaJualSatuan').val() === '') {
                    e.preventDefault();
                    alert('Silahkan isi nominal terlebih dahulu!');
                    return;
                }
            } else {
                var hasNone = false; // Flag to check if any row has 'None'

                // Loop through each row in the barangTable
                $('#barangTable tbody tr').each(function() {
                    var jenisBarangValue = $(this).find('select[name="jenisBarang[]"]').val();
                    if (jenisBarangValue === 'None') {
                        hasNone = true; // Set flag if 'None' is found
                        return false; // Break out of the loop
                    }
                });

                // If any row has 'None', prevent form submission and alert
                if (hasNone) {
                    e.preventDefault();
                    alert('Silahkan lengkapi Daftar Barang terlebih dahulu!');
                    return;
                }
            }
        });
    </script>

    <!-- Increment/Decrement for Pengeluaran -->
    <script>
        $(document).ready(function(){
            var isLoaded = false;
            var globalInputValue = 1;

            if (isLoaded == false) {
                rebindPengeluaranEvents();
                isLoaded = true
            }

            // Rebind custom input handling functions
            $(document).on('keydown', '#nominalPengeluaran', function(event) {
                preventBackspace(this, event);
            });
            $(document).on('input', '#nominalPengeluaran', function(event) {
                enforceNumericInput(this);
            });
            $(document).on('blur', '#nominalPengeluaran', function(event) {
                addCurrencySuffix(this);
            });
            $(document).on('keydown', '#jumlahBarangPengeluaran', function(event) {
                preventDeletionPengeluaran(event);
            });
            $(document).on('input', '#jumlahBarangPengeluaran', function(event) {
                handleJumlahBarangPengeluaranInput(event);
            });
            $(document).on('keydown', '#hargaJualSatuan', function(event) {
                preventBackspace(this, event);
            });
            $(document).on('input', '#hargaJualSatuan', function(event) {
                enforceNumericInput(this);
            });
            $(document).on('blur', '#hargaJualSatuan', function(event) {
                addCurrencySuffix(this);
            });

            function handleJumlahBarangPengeluaranInput(event) {
                var input = event.target;
                var value = input.value;
                var deskripsiValue = $('#deskripsi').val();

                if (deskripsiValue === 'Tambah Stok') {
                    var jenisBarang = document.getElementById('jenisBarangPengeluaran');
                    var selectedOption = jenisBarang.options[jenisBarang.selectedIndex];
                    var productStock = parseInt(selectedOption.dataset.stock) || 1;
                    var maxProductToBeAdded = 99999 - productStock;

                    if (value > maxProductToBeAdded) {
                        alert('Jumlah stok maksimal yang dapat ditambahkan adalah ' + maxProductToBeAdded);
                        value = String(globalInputValue);
                    }
                }

                if (value.length > 5) {
                    value = value.slice(0, 5);
                }

                // If the input becomes empty, default back to '0'
                if (value === '') {
                    value = '1';
                }

                // Update the input value
                input.value = value;
                globalInputValue = value;
            }

            function preventInvalidOperationsPengeluaran() {
                var deskripsiValue = $('#deskripsi').val();

                if (deskripsiValue === 'Tambah Stok Baru') {
                    var jenisBarang = document.getElementById('stokBaru')

                    if (jenisBarang.value === '') {
                        alert('Silahkan masukkan nama stok barang terlebih dahulu!')
                        return false;
                    } 
                } else if (deskripsiValue === 'Lainnya') {
                    var deskripsiTransaksi = document.getElementById('deskripsiTransaksi')

                    if (deskripsiTransaksi.value === '') {
                        alert('Silahkan masukkan deskripsi transaksi terlebih dahulu!')
                        return false;
                    } 
                } else {
                    var jenisBarang = document.getElementById('jenisBarangPengeluaran');

                    if (jenisBarang.options[jenisBarang.selectedIndex].value === 'None') {
                        alert('Silahkan pilih Jenis Barang terlebih dahulu!');
                        return false;
                    } 
                }
                
                return true;
            }

            // Function to handle events for Pengeluaran modal dynamically
            function rebindPengeluaranEvents() {
                var deskripsiValue = $('#deskripsi').val();
                var jumlahBarang = $('#jumlahBarangPengeluaran');

                $('#incrementPengeluaran').on('click', function() {
                    if (deskripsiValue === 'Tambah Stok Baru') {
                        var jenisBarang = document.getElementById('stokBaru')

                        if (jenisBarang.value === '') {
                            alert('Silahkan masukkan nama stok barang terlebih dahulu!');
                            return;
                        }

                        if (parseInt(jumlahBarang.val()) < 99999) {
                            jumlahBarang.val(parseInt(jumlahBarang.val()) + 1);
                        }
                    } else {
                        var jenisBarang = document.getElementById('jenisBarangPengeluaran');

                        if (jenisBarang.options[jenisBarang.selectedIndex].value === 'None') {
                            alert('Silahkan pilih Jenis Barang terlebih dahulu!');
                            return;
                        }

                        // pake if === Tambah Stok cuman buat make sure aja yang valuenya si Tambah Stok
                        if (deskripsiValue === 'Tambah Stok') {
                            var selectedOption = jenisBarang.options[jenisBarang.selectedIndex];
                            var productStock = parseInt(selectedOption.dataset.stock) || 1;
                            var maxProductToBeAdded = 99999 - productStock;

                            if (parseInt(jumlahBarang.val()) >= maxProductToBeAdded) {
                                alert('Jumlah stok maksimal yang dapat ditambahkan adalah ' + maxProductToBeAdded);
                                return;
                            } else {
                                jumlahBarang.val(parseInt(jumlahBarang.val()) + 1);
                            }
                        }
                    }

                    globalInputValue = parseInt(jumlahBarang.val());
                });

                $('#decrementPengeluaran').on('click', function() {
                    if (deskripsiValue === 'Tambah Stok Baru') {
                        var jenisBarang = document.getElementById('stokBaru')

                        if (jenisBarang.value === '') {
                            alert('Silahkan masukkan nama stok barang terlebih dahulu!');
                            return;
                        }
                    } else {
                        var jenisBarang = document.getElementById('jenisBarangPengeluaran');

                        if (jenisBarang.options[jenisBarang.selectedIndex].value === 'None') {
                            alert('Silahkan pilih Jenis Barang terlebih dahulu!');
                            return;
                        }
                    }

                    if (parseInt(jumlahBarang.val()) > 1) {
                        jumlahBarang.val(parseInt(jumlahBarang.val()) - 1);
                        globalInputValue = parseInt(jumlahBarang.val());
                    }
                });
            }

            function preventDeletionPengeluaran(event) {
                var deskripsiValue = $('#deskripsi').val();
                if (deskripsiValue === 'Tambah Stok Baru') {
                    var stokBaruValue = document.getElementById('stokBaru');

                    if (stokBaruValue.value === '') {
                        alert('Silahkan masukkan nama stok barang terlebih dahulu!');
                        event.preventDefault();
                        return;
                    }
                } else {
                    var jenisBarang = document.getElementById('jenisBarangPengeluaran');
                    var selectedValue = jenisBarang.options[jenisBarang.selectedIndex].value;

                    if (selectedValue === 'None') {
                        alert('Silahkan pilih Jenis Barang terlebih dahulu!');
                        event.preventDefault();
                        return;
                    }
                }
            }

            function enforceNumericInput(input) {
                var value = input.value;

                // Remove any non-digit characters except the prefix
                var numberValue = value.slice(4).replace(/\D/g, '');

                // Restrict the input to prevent entering numbers starting with 0 (except 0 itself)
                if (numberValue.startsWith('0')) {
                    numberValue = ''; // If first character is 0, restrict the rest of the input
                }

                // Limit the input
                var maxLength = (input.id === 'hargaJualSatuan' ? 9 : 12);

                if (numberValue.length > maxLength) {
                    numberValue = numberValue.slice(0, maxLength);
                }

                // Format the number with dots as thousand separators
                var formattedValue = numberValue.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                // Update the input value with the formatted number
                input.value = 'Rp. ' + formattedValue;
            }

            function preventBackspace(input, event) {
                if (!preventInvalidOperationsPengeluaran()) {
                    event.preventDefault();
                    return;
                }

                // Below is needed if you want to enable key not to be deleted
                // if (input.selectionStart <= 4 && (event.key === 'Backspace' || event.key === 'Delete')) {
                //     event.preventDefault();
                // }
            }

            function addCurrencySuffix(input) {
                var value = input.value;

                // Ensure the value ends with ",-"
                if (value.length > 4 && !value.endsWith(',-')) {
                    input.value = value + ',-';
                }
            }

            function checkStockNameExist() {
                const products = @json($products->pluck('productName')); // Pass the product names as a JavaScript array

                document.getElementById('stokBaru').addEventListener('input', function() {
                    let productName = this.value.toLowerCase();
                    let message = document.getElementById('product-check-message');
                    const lowerCaseProducts = products.map(name => name.toLowerCase());

                    // Check if the product name already exists in the products array
                    if (lowerCaseProducts.includes(productName)) {
                        message.textContent = "Stok dengan nama ini sudah tersedia!";
                        return;
                    } else {
                        message.textContent = "";
                    }
                });
            }

            // Handle 'Deskripsi' change event to switch between dynamic fields
            $('#deskripsi').on('change', function() {
                if ($(this).val() === 'Lainnya') {
                    $('#dynamicFields').html(`
                        <input type="hidden" name="modalType1" value="tambahLainnya">
                        <div class="form-group position-relative mb-2">
                            <label for="deskripsiTransaksi" class="col-form-label" id="inputModalLabel">Deskripsi Transaksi</label>
                            <textarea class="form-control border-style" id="deskripsiTransaksi" name="deskripsiTransaksi" placeholder="Masukkan deskripsi transaksi" rows="3" required></textarea>
                        </div>
                        <div class="form-group-select position-relative mb-2">
                            <label for="kategori" class="col-form-label d-flex align-items-center" id="inputModalLabel">
                                Kategori
                                <!-- Flexbox will align the icon vertically in the center -->
                                <span data-toggle="tooltip" data-placement="top" title="Operasional: Pengeluaran untuk kegiatan sehari-hari, seperti gaji, listrik, dsb.\n\nInvestasi: Pengeluaran untuk pengembangan masa depan, seperti pembelian aset atau peralatan baru." class="ml-2 d-flex align-items-center">
                                    <span class="iconify" data-icon="ri:question-fill"></span>
                                </span>
                            </label>
                            <select class="form-control border-style" id="kategori" name="kategori">
                                <option value="Operasional">Operasional</option>
                                <option value="Investasi">Investasi</option>
                            </select>
                        </div>
                        <div class="form-group position-relative mb-2" id="nominalField">
                            <label for="nominalPengeluaran" class="col-form-label" id="inputModalLabel">Total Pengeluaran</label>
                            <input type="text" class="form-control border-style" id="nominalPengeluaran" name="nominalPengeluaran" value="Rp. " autocomplete="off">
                        </div>
                        <div class="form-group-select position-relative mb-2">
                            <label for="metode" class="col-form-label" id="inputModalLabel">Metode</label>
                            <select class="form-control border-style" id="metode" name="metode">
                                @foreach($payment_methods as $method)
                                    <option value="{{ $method->name }}">{{ $method->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    `);
                } else if ($(this).val() === 'Tambah Stok') {
                    $('#dynamicFields').html(`
                        <input type="hidden" name="modalType1" value="tambahStok">
                        <div id="dynamicFields">
                            <div class="form-group-select position-relative mb-2" id="jenisBarangField">
                                <label for="jenisBarangPengeluaran" class="col-form-label" id="inputModalLabel">Jenis Barang</label>
                                <select class="form-control border-style" id="jenisBarangPengeluaran" name="jenisBarangPengeluaran">
                                    <option value="None">None</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-stock="{{ $product->productStock }}" data-price="{{ $product->productPrice }}">{{ $product->productName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group position-relative mb-2" id="jumlahBarangField">
                                <label for="jumlahBarangPengeluaran" class="col-form-label" id="inputModalLabel">Jumlah Barang</label>
                                <div class="input-group input-group-outline border-style">
                                    <button class="btn" type="button" id="decrementPengeluaran">
                                        <span class="iconify" data-icon="ph:minus-bold" data-width="24" data-height="24"></span>
                                    </button>
                                    <input type="text" class="form-control border-style text-center" id="jumlahBarangPengeluaran" name="jumlahBarangPengeluaran" value="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required min="1">
                                    <button class="btn" type="button" id="incrementPengeluaran">
                                        <span class="iconify" data-icon="ic:round-plus" data-width="24" data-height="24"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group position-relative mb-2" id="nominalField">
                                <label for="nominalPengeluaran" class="col-form-label" id="inputModalLabel">Total Harga Beli Barang</label>
                                <input type="text" class="form-control border-style" id="nominalPengeluaran" name="nominalPengeluaran" value="Rp. " autocomplete="off">
                            </div>
                            <div class="form-group-select position-relative mb-2">
                                <label for="metode" class="col-form-label" id="inputModalLabel">Metode</label>
                                <select class="form-control border-style" id="metode" name="metode">
                                    @foreach($payment_methods as $method)
                                        <option value="{{ $method->name }}">{{ $method->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    `);
                } else {
                    $('#dynamicFields').html(`
                        <input type="hidden" name="modalType1" value="tambahStokBaru">
                        <div id="dynamicFields">
                            <div class="form-group position-relative mb-2" id="stokBaruField">
                                <label for="stokBaru" class="col-form-label" id="inputModalLabel">Nama Stok Baru</label>
                                <input type="text" class="form-control border-style" id="stokBaru" name="stokBaru" placeholder="Masukkan nama stok baru" required>
                                <div class="mt-1" id="product-check-message" style="color: red;"></div>
                            </div>
                            <div class="form-group position-relative mb-2" id="jumlahBarangField">
                                <label for="jumlahBarangPengeluaran" class="col-form-label" id="inputModalLabel">Jumlah Barang</label>
                                <div class="input-group input-group-outline border-style">
                                    <button class="btn" type="button" id="decrementPengeluaran">
                                        <span class="iconify" data-icon="ph:minus-bold" data-width="24" data-height="24"></span>
                                    </button>
                                    <input type="text" class="form-control border-style text-center" id="jumlahBarangPengeluaran" name="jumlahBarangPengeluaran" value="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required min="1">
                                    <button class="btn" type="button" id="incrementPengeluaran">
                                        <span class="iconify" data-icon="ic:round-plus" data-width="24" data-height="24"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group position-relative mb-2" id="nominalField">
                                <label for="nominalPengeluaran" class="col-form-label" id="inputModalLabel">Total Harga Beli Barang</label>
                                <input type="text" class="form-control border-style" id="nominalPengeluaran" name="nominalPengeluaran" value="Rp. " autocomplete="off">
                            </div>
                            <div class="form-group position-relative mb-2" id="nominalField2">
                                <label for="hargaJualSatuan" class="col-form-label" id="inputModalLabel">Harga Jual Barang Satuan</label>
                                <input type="text" class="form-control border-style" id="hargaJualSatuan" name="hargaJualSatuan" value="Rp. ">
                            </div>
                            <div class="form-group-select position-relative mb-2">
                                <label for="metode" class="col-form-label" id="inputModalLabel">Metode</label>
                                <select class="form-control border-style" id="metode" name="metode">
                                    @foreach($payment_methods as $method)
                                        <option value="{{ $method->name }}">{{ $method->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    `);
                    checkStockNameExist();
                }

                // Rebind events for the newly created elements
                rebindPengeluaranEvents();
            });
        });
    </script>
</x-layout>
