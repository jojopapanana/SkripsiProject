<x-layout title="Dashboard">
    <h1 class="fw-bold">DASHBOARD</h1>

    <div class="d-flex gap-4">
        <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-top">
                <div>
                    <h4 class="fw-bold">Keuntunganmu bulan ini</h4>
                    <h4 class="fw-bold" style="color: rgba(14, 70, 163, 1)">Rp. 100.000</h4>
                </div>

                <i class="bi bi-file-bar-graph-fill fs-1"></i>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-top">
                <div>
                    <h4 class="fw-bold">Kasmu bulan ini</h4>
                    <h4 class="fw-bold" style="color: rgba(14, 70, 163, 1)">Rp. 2.000.000</h4>
                </div>

                <i class="bi bi-cash fs-1"></i>
            </div>
        </div>
    </div>

    <div class="dashboard-trenkeuntungan">
        <h3 class="fw-bold">Tren Keuntungan-mu!</h3>
        {{-- <canvas id="myChart" style="width: 70vw; height: 40vh"></canvas> --}}
    </div>

    <div class="d-flex">
        <button type="button" class="btn btn-primary custom-modal-btn mr-2" data-toggle="modal" data-target="#modalityPemasukan">
            + Tambah Pemasukan
        </button>
        <button type="button" class="btn btn-primary custom-modal-btn" data-toggle="modal" data-target="#modalityPengeluaran">
            - Tambah Pengeluaran
        </button>
    </div>

    <!-- Modal Pemasukan -->
    <div class="modal fade" id="modalityPemasukan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered custom-modal-width" role="document">
            <div class="modal-content pl-3 pr-3">
                <div class="modal-header justify-content-center">
                    <p class="modal-title" id="exampleModalLabel">Tambah Transaksi</p>
                </div>
                <div class="modal-body">
                    <form id="formInput" action="{{ route('transaksi.store') }}" method="POST" class="mb-2">
                        @csrf
                        <input type="hidden" name="modalType" value="pemasukan">
                        <div class="form-group position-relative mb-2">
                            <label for="tanggal" class="col-form-label" id="inputModalLabel">Tanggal</label>
                            <input type="text" class="form-control border-style tanggal" name="tanggal" id="tanggal" value="" readonly>
                        </div>
                        <div class="form-group position-relative mb-2">
                            <label for="jenisTransaksi" class="col-form-label" id="inputModalLabel">Jenis Transaksi</label>
                            <input type="text" class="form-control border-style" id="jenisTransaksi" name="jenisTransaksi" value="Pemasukan" readonly>
                        </div>
                        <div class="form-group-select position-relative mb-2">
                            <label for="jenisBarang" class="col-form-label" id="inputModalLabel">Jenis Barang</label>
                            <select class="form-control border-style" id="jenisBarang" name="jenisBarang">
                                <option value="None">None</option>
                                @foreach($products as $product)
                                    @if($product->productStock > 0)
                                        <option value="{{ $product->id }}" data-stock="{{ $product->productStock }}" data-price="{{ $product->productPrice }}">{{ $product->productName }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group position-relative mb-2">
                            <label for="jumlahBarang" class="col-form-label" id="inputModalLabel">Jumlah Barang</label>
                            <div class="input-group input-group-outline border-style">
                                <button class="btn" type="button" id="decrement">
                                    <span class="iconify" data-icon="ph:minus-bold" data-width="24" data-height="24"></span>
                                </button>
                                <input type="text" class="form-control border-style text-center" name="jumlahBarang" id="jumlahBarang" value="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                <button class="btn" type="button" id="increment">
                                    <span class="iconify" data-icon="ic:round-plus" data-width="24" data-height="24"></span>
                                </button>
                            </div>
                        </div>
                        <div class="form-group position-relative mb-2">
                            <label for="nominal" class="col-form-label" id="inputModalLabel">Nominal</label>
                            <input type="text" class="form-control border-style" id="nominal" name="nominal" value="Rp. 0,-" readonly>
                        </div>
                        <div class="form-group-select position-relative mb-4">
                            <label for="metode" class="col-form-label" id="inputModalLabel">Metode</label>
                            <select class="form-control border-style" id="metode" name="metode">
                                <option value="Tunai">Tunai</option>
                                <option value="Non-Tunai">Non-Tunai</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary custom-btn mt-2">Tambah</button>
                        </div>
                    </form>
                </div>
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
                <div class="modal-body">
                    <form id="formInputPengeluaran" action="{{ route('transaksi.store') }}" method="POST" class="mb-2">
                        @csrf
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
                        <!-- Changing form group based on selected Deskripsi option -->
                        <input type="hidden" name="modalType1" value="tambahStok">
                        <div id="dynamicFields">
                            <div class="form-group-select position-relative mb-2" id="jenisBarangField">
                                <label for="jenisBarangPengeluaran" class="col-form-label" id="inputModalLabel">Jenis Barang</label>
                                <select class="form-control border-style" id="jenisBarangPengeluaran" name="jenisBarangPengeluaran">
                                    <option value="None">None</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->productPrice }}">{{ $product->productName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group position-relative mb-2" id="jumlahBarangField">
                                <label for="jumlahBarangPengeluaran" class="col-form-label" id="inputModalLabel">Jumlah Barang</label>
                                <div class="input-group input-group-outline border-style">
                                    <button class="btn" type="button" id="decrementPengeluaran">
                                        <span class="iconify" data-icon="ph:minus-bold" data-width="24" data-height="24"></span>
                                    </button>
                                    <input type="text" class="form-control border-style text-center" id="jumlahBarangPengeluaran" name="jumlahBarangPengeluaran" value="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    <button class="btn" type="button" id="incrementPengeluaran">
                                        <span class="iconify" data-icon="ic:round-plus" data-width="24" data-height="24"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group position-relative mb-2" id="nominalField">
                                <label for="nominalPengeluaran" class="col-form-label" id="inputModalLabel">Nominal</label>
                                <input type="text" class="form-control border-style" id="nominalPengeluaran" name="nominalPengeluaran" value="Rp. ">
                            </div>
                            <div class="form-group-select position-relative mb-4">
                                <label for="metode" class="col-form-label" id="inputModalLabel">Metode</label>
                                <select class="form-control border-style" id="metode" name="metode">
                                    <option value="Tunai">Tunai</option>
                                    <option value="Non-Tunai">Non-Tunai</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary custom-btn mt-2">Tambah</button>
                            </div>
                        </div>
                    </form>
                </div>
    {{-- <script type="module">
    const data = {
        labels: @json($data->map(fn ($data) => $data->date)),
        datasets: [{
            label: 'Registered users in the last 30 days',
            backgroundColor: 'red',
            borderColor: 'rgb(255, 99, 132)',
            data: @json($data->map(fn ($data) => $data->aggregate)),
        }]
    };

    console.log(data);

    const config = {
        type: 'bar',
        data: data
    };
    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
    </script> --}}

    <!-- jQuery, Popper.js, and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Iconify icon -->
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

    @if (session('success'))
        <script>
            alert('{{ session('success') }}');
        </script>
    @endif

    <script>
        // Select all forms on the page, including both modals
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function(event) {
                let nominalFields = form.querySelectorAll('#nominal, #nominalPengeluaran, #hargaJualSatuan');  // Select nominal and nominalPengeluaran within the current form

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

    <!-- Set current date -->
    <script>
        $(document).ready(function(){
            // Set current date to the 'tanggal' input field
            var today = new Date();
            var day = String(today.getDate()).padStart(2, '0');
            var month = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
            var year = today.getFullYear();

            today = year + '-' + month + '-' + day;
            $('.tanggal').val(today);
        });
    </script>

    <!-- Update Nominal for Pemasukan -->
    <script>
        $(document).ready(function(){
            var globalInputValue = 1;

            $('#jumlahBarang').on('keydown', preventDeletion);
            $('#jumlahBarang').on('input', limitInput);

            function updateNominal() {
                var jenisBarang = document.getElementById('jenisBarang');
                var selectedOption = jenisBarang.options[jenisBarang.selectedIndex];
                var pricePerItem = parseInt(selectedOption.getAttribute('data-price')) || 0;

                var jumlahBarang = parseInt(document.getElementById('jumlahBarang').value) || 1;
                var nominal = pricePerItem * jumlahBarang;

                var productStock = parseInt(selectedOption.getAttribute('data-stock')) || 1;

                document.getElementById('nominal').value = 'Rp. ' + nominal.toLocaleString('id-ID') + ',-';

                if (jumlahBarang > productStock) {
                    document.getElementById('jumlahBarang').value = productStock
                    globalInputValue = productStock
                }
            }

            function limitInput(event) {
                var input = event.target;
                var currVal = input.value;

                if (isNaN(currVal) || currVal.trim() === '') {
                    alert('Masukkan hanya angka!');
                    input.value = globalInputValue;
                    return;
                }

                var value = parseInt(input.value) || 0;
                var jenisBarang = document.getElementById('jenisBarang');
                var selectedOption = jenisBarang.options[jenisBarang.selectedIndex];
                var productStock = parseInt(selectedOption.getAttribute('data-stock')) || 1;

                // Ensure the value is not less than 1
                if (value < 1) {
                    alert('Jumlah tidak dapat kurang dari 1');
                    input.value = globalInputValue;
                    return;
                }

                // Limit the input value to not exceed productStock
                if (value > productStock) {
                    alert('Jumlah tidak boleh melebihi stok yang tersedia: ' + productStock);
                    input.value = globalInputValue;
                    return;
                }

                globalInputValue = input.value
            }

            function preventDeletion(event) {
                var jenisBarang = document.getElementById('jenisBarang');

                if (jenisBarang.options[jenisBarang.selectedIndex].value === 'None') {
                    alert('Silahkan pilih Jenis Barang terlebih dahulu!');
                    event.preventDefault();
                    return;
                }
            }

            $('#jenisBarang, #jumlahBarang').on('change input', function() {
                updateNominal();
            });

            $('#increment').on('click', function() {
                var jumlahBarang = $('#jumlahBarang');
                var jenisBarang = document.getElementById('jenisBarang');
                var selectedOption = jenisBarang.options[jenisBarang.selectedIndex];
                var productStock = parseInt(selectedOption.getAttribute('data-stock')) || 0;

                if (jenisBarang.options[jenisBarang.selectedIndex].value === 'None') {
                    alert('Silahkan pilih Jenis Barang terlebih dahulu!');
                    return;
                }

                if (parseInt(jumlahBarang.val()) < productStock) {
                    jumlahBarang.val(parseInt(jumlahBarang.val()) + 1);
                    globalInputValue = parseInt(jumlahBarang.val())
                } else {
                    alert('Stok tidak mencukupi! Stok tersedia: ' + productStock);
                    return;
                }
                updateNominal();
            });

            $('#decrement').on('click', function() {
                var jumlahBarang = $('#jumlahBarang');
                var jenisBarang = document.getElementById('jenisBarang');

                if (jenisBarang.options[jenisBarang.selectedIndex].value === 'None') {
                    alert('Silahkan pilih Jenis Barang terlebih dahulu!');
                    return;
                }

                if (parseInt(jumlahBarang.val()) > 1) {
                    jumlahBarang.val(parseInt(jumlahBarang.val()) - 1);
                    globalInputValue = parseInt(jumlahBarang.val())
                    updateNominal();
                }
            });
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
                if (form.find('#nominalPengeluaran').val() === '') {
                    e.preventDefault();
                    alert('Silahkan isi nominal terlebih dahulu!');
                    return;
                }
            } else {
                if (form.find('#jenisBarang').val() === 'None') {
                    e.preventDefault();
                    alert('Silahkan pilih Jenis Barang terlebih dahulu!');
                    return;
                }
            }
        });
    </script>

    <!-- Increment/Decrement for Pengeluaran -->
    <script>
        $(document).ready(function(){
            var globalInputValue = 1;

            // Initial bind for Pengeluaran modal
            rebindPengeluaranEvents();

            // Function to handle events for Pengeluaran modal dynamically
            function rebindPengeluaranEvents() {
                var deskripsiValue = $('#deskripsi').val();
                var jumlahBarang = $('#jumlahBarangPengeluaran');

                $('#incrementPengeluaran').on('click', function() {
                    if (deskripsiValue === 'Tambah Stok Baru') {
                        var jenisBarang = document.getElementById('stokBaru')

                        if (jenisBarang.value === '') {
                            alert('Silahkan masukkan nama stok barang terlebih dahulu!')
                            return;
                        }
                    } else {
                        var jenisBarang = document.getElementById('jenisBarangPengeluaran');

                        if (jenisBarang.options[jenisBarang.selectedIndex].value === 'None') {
                            alert('Silahkan pilih Jenis Barang terlebih dahulu!');
                            return;
                        }
                    }

                    jumlahBarang.val(parseInt(jumlahBarang.val()) + 1);
                    globalInputValue = parseInt(jumlahBarang.val())
                });

                $('#decrementPengeluaran').on('click', function() {
                    if (deskripsiValue === 'Tambah Stok Baru') {
                        var jenisBarang = document.getElementById('stokBaru')

                        if (jenisBarang.value === '') {
                            alert('Silahkan masukkan nama stok barang terlebih dahulu!')
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
                        globalInputValue = parseInt(jumlahBarang.val())
                    }
                });

                // Rebind custom input handling functions
                $('#nominalPengeluaran').on('keydown', preventBackspace);
                $('#nominalPengeluaran').on('input', enforceNumericInput);
                $('#nominalPengeluaran').on('blur', addCurrencySuffix);

                if (deskripsiValue != 'Lainnya') {
                    $('#jumlahBarangPengeluaran').on('keydown', preventDeletionPengeluaran);
                    $('#jumlahBarangPengeluaran').on('input', inputPengeluaranCustom);
                }

                if (deskripsiValue === 'Tambah Stok Baru') {
                    $('#hargaJualSatuan').on('keydown', preventBackspace);
                    $('#hargaJualSatuan').on('input', enforceNumericInput);
                    $('#hargaJualSatuan').on('blur', addCurrencySuffix);
                }
            }

            function inputPengeluaranCustom(event) {
                var input = event.target;
                var currVal = input.value;
                var value = parseInt(input.value) || 0;

                if (isNaN(currVal) || currVal.trim() === '') {
                    alert('Masukkan hanya angka!');
                    input.value = globalInputValue;
                    return;
                }

                if (value < 1) {
                    alert('Jumlah tidak dapat kurang dari 1');
                    input.value = globalInputValue;
                    return;
                }

                globalInputValue = input.value
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

            function enforceNumericInput(event) {
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

            function preventBackspace(event) {
                var input = event.target;
                if (input.selectionStart <= 4 && (event.key === 'Backspace' || event.key === 'Delete')) {
                    event.preventDefault();
                }
            }

            function addCurrencySuffix() {
                var input = event.target;
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
                            <label for="kategori" class="col-form-label" id="inputModalLabel">Kategori</label>
                            <select class="form-control border-style" id="kategori" name="kategori">
                                <option value="Operasional">Operasional</option>
                                <option value="Investasi">Investasi</option>
                            </select>
                        </div>
                        <div class="form-group position-relative mb-2">
                            <label for="nominalPengeluaran" class="col-form-label" id="inputModalLabel">Nominal</label>
                            <input type="text" class="form-control border-style" id="nominalPengeluaran" name="nominalPengeluaran" value="Rp. ">
                        </div>
                        <div class="form-group-select position-relative mb-4">
                            <label for="metode" class="col-form-label" id="inputModalLabel">Metode</label>
                            <select class="form-control border-style" id="metode" name="metode">
                                <option value="Tunai">Tunai</option>
                                <option value="Non-Tunai">Non-Tunai</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary custom-btn mt-2">Tambah</button>
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
                                        <option value="{{ $product->id }}" data-price="{{ $product->productPrice }}">{{ $product->productName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group position-relative mb-2" id="jumlahBarangField">
                                <label for="jumlahBarangPengeluaran" class="col-form-label" id="inputModalLabel">Jumlah Barang</label>
                                <div class="input-group input-group-outline border-style">
                                    <button class="btn" type="button" id="decrementPengeluaran">
                                        <span class="iconify" data-icon="ph:minus-bold" data-width="24" data-height="24"></span>
                                    </button>
                                    <input type="text" class="form-control border-style text-center" id="jumlahBarangPengeluaran" name="jumlahBarangPengeluaran" value="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    <button class="btn" type="button" id="incrementPengeluaran">
                                        <span class="iconify" data-icon="ic:round-plus" data-width="24" data-height="24"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group position-relative mb-2" id="nominalField">
                                <label for="nominalPengeluaran" class="col-form-label" id="inputModalLabel">Nominal</label>
                                <input type="text" class="form-control border-style" id="nominalPengeluaran" name="nominalPengeluaran" value="Rp. ">
                            </div>
                            <div class="form-group-select position-relative mb-4">
                                <label for="metode" class="col-form-label" id="inputModalLabel">Metode</label>
                                <select class="form-control border-style" id="metode" name="metode">
                                    <option value="Tunai">Tunai</option>
                                    <option value="Non-Tunai">Non-Tunai</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary custom-btn mt-2">Tambah</button>
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
                                    <input type="text" class="form-control border-style text-center" id="jumlahBarangPengeluaran" name="jumlahBarangPengeluaran" value="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    <button class="btn" type="button" id="incrementPengeluaran">
                                        <span class="iconify" data-icon="ic:round-plus" data-width="24" data-height="24"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group position-relative mb-2" id="nominalField">
                                <label for="nominalPengeluaran" class="col-form-label" id="inputModalLabel">Nominal</label>
                                <input type="text" class="form-control border-style" id="nominalPengeluaran" name="nominalPengeluaran" value="Rp. ">
                            </div>
                            <div class="form-group position-relative mb-2" id="nominalField2">
                                <label for="hargaJualSatuan" class="col-form-label" id="inputModalLabel">Harga Jual Satuan</label>
                                <input type="text" class="form-control border-style" id="hargaJualSatuan" name="hargaJualSatuan" value="Rp. ">
                            </div>
                            <div class="form-group-select position-relative mb-4">
                                <label for="metode" class="col-form-label" id="inputModalLabel">Metode</label>
                                <select class="form-control border-style" id="metode" name="metode">
                                    <option value="Tunai">Tunai</option>
                                    <option value="Non-Tunai">Non-Tunai</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary custom-btn mt-2">Tambah</button>
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
