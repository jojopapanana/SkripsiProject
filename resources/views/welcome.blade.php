
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
                    <form class="mb-2">
                        <div class="form-group position-relative mb-2">
                            <label for="tanggal" class="col-form-label" id="inputModalLabel">Tanggal</label>
                            <input type="text" class="form-control border-style tanggal" id="tanggal" value="" readonly>
                        </div>
                        <div class="form-group position-relative mb-2">
                            <label for="jenisTransaksi" class="col-form-label" id="inputModalLabel">Jenis Transaksi</label>
                            <input type="text" class="form-control border-style" id="jenisTransaksi" value="Pemasukan" readonly>
                        </div>
                        <div class="form-group-select position-relative mb-2">
                            <label for="jenisBarang" class="col-form-label" id="inputModalLabel">Jenis Barang</label>
                            <select class="form-control border-style" id="jenisBarang">
                                <option value="none">None</option>
                                <option value="none">None</option>
                                <option value="none">None</option>
                            </select>
                        </div>
                        <div class="form-group position-relative mb-2">
                            <label for="jumlahBarang" class="col-form-label" id="inputModalLabel">Jumlah Barang</label>
                            <div class="input-group input-group-outline border-style">
                                <button class="btn" type="button" id="decrement">
                                    <span class="iconify" data-icon="ph:minus-bold" data-width="24" data-height="24"></span>
                                </button>
                                <input type="text" class="form-control border-style text-center" id="jumlahBarang" value="0" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                <button class="btn" type="button" id="increment">
                                    <span class="iconify" data-icon="ic:round-plus" data-width="24" data-height="24"></span>
                                </button>
                            </div>
                        </div>
                        <div class="form-group position-relative mb-2">
                            <label for="nominal" class="col-form-label" id="inputModalLabel">Nominal</label>
                            <input type="text" class="form-control border-style" id="nominal" value="Rp. 0,-" readonly>
                        </div>
                        <div class="form-group-select position-relative mb-2">
                            <label for="metode" class="col-form-label" id="inputModalLabel">Metode</label>
                            <select class="form-control border-style" id="metode">
                                <option value="none">None</option>
                                <option value="none">None</option>
                                <option value="none">None</option>
                            </select>
                        </div>
                     </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary custom-btn mt-2 mb-2">Tambah</button>
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
                    <form class="mb-2">
                        <div class="form-group position-relative mb-2">
                            <label for="tanggal" class="col-form-label" id="inputModalLabel">Tanggal</label>
                            <input type="text" class="form-control border-style tanggal" id="tanggal" value="" readonly>
                        </div>
                        <div class="form-group position-relative mb-2">
                            <label for="jenisTransaksi" class="col-form-label" id="inputModalLabel">Jenis Transaksi</label>
                            <input type="text" class="form-control border-style" id="jenisTransaksi" value="Pengeluaran" readonly>
                        </div>
                        <div class="form-group-select position-relative mb-2">
                            <label for="deskripsi" class="col-form-label" id="inputModalLabel">Deskripsi</label>
                            <select class="form-control border-style" id="deskripsi">
                                <option value="none">None</option>
                                <option value="none">None</option>
                                <option value="none">None</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <!-- Changing form group based on selected Deskripsi option -->
                        <div id="dynamicFields">
                            <div class="form-group-select position-relative mb-2" id="jenisBarangField">
                                <label for="jenisBarang" class="col-form-label" id="inputModalLabel">Jenis Barang</label>
                                <select class="form-control border-style" id="jenisBarang">
                                    <option value="none">None</option>
                                    <option value="none">None</option>
                                    <option value="none">None</option>
                                </select>
                            </div>
                            <div class="form-group position-relative mb-2" id="jumlahBarangField">
                                <label for="jumlahBarangPengeluaran" class="col-form-label" id="inputModalLabel">Jumlah Barang</label>
                                <div class="input-group input-group-outline border-style">
                                    <button class="btn" type="button" id="decrementPengeluaran">
                                        <span class="iconify" data-icon="ph:minus-bold" data-width="24" data-height="24"></span>
                                    </button>
                                    <input type="text" class="form-control border-style text-center" id="jumlahBarangPengeluaran" value="0" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    <button class="btn" type="button" id="incrementPengeluaran">
                                        <span class="iconify" data-icon="ic:round-plus" data-width="24" data-height="24"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group position-relative mb-2" id="nominalField">
                                <label for="nominalPengeluaran" class="col-form-label" id="inputModalLabel">Nominal</label>
                                <input type="text" class="form-control border-style" id="nominalPengeluaran" value="Rp. " onkeydown="preventBackspace(event)" oninput="enforceNumericInput(event)" onblur="addCurrencySuffix()">
                            </div>
                        </div>
                     </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary custom-btn mt-2 mb-2">Tambah</button>
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
            function updateNominal() {
                var jenisBarang = document.getElementById('jenisBarang');
                var selectedOption = jenisBarang.options[jenisBarang.selectedIndex];
                var pricePerItem = parseInt(selectedOption.getAttribute('data-price'));

                var jumlahBarang = parseInt(document.getElementById('jumlahBarang').value);
                var nominal = pricePerItem * jumlahBarang;

                document.getElementById('nominal').value = 'Rp. ' + nominal.toLocaleString('id-ID') + ',-';
            }

            $('#jenisBarang, #jumlahBarang').on('change input', function() {
                updateNominal();
            });

            $('#increment').on('click', function() {
                var jumlahBarang = $('#jumlahBarang');
                jumlahBarang.val(parseInt(jumlahBarang.val()) + 1);
                updateNominal();
            });

            $('#decrement').on('click', function() {
                var jumlahBarang = $('#jumlahBarang');
                if (parseInt(jumlahBarang.val()) > 1) {
                    jumlahBarang.val(parseInt(jumlahBarang.val()) - 1);
                    updateNominal();
                }
            });
        });
    </script>

    <!-- Increment/Decrement for Pengeluaran -->
    <script>
        $(document).ready(function(){
            // Function to handle events for Pengeluaran modal dynamically
            function rebindPengeluaranEvents() {
                $('#incrementPengeluaran').on('click', function() {
                    var jumlahBarang = $('#jumlahBarangPengeluaran');
                    jumlahBarang.val(parseInt(jumlahBarang.val()) + 1);
                });

                $('#decrementPengeluaran').on('click', function() {
                    var jumlahBarang = $('#jumlahBarangPengeluaran');
                    if (parseInt(jumlahBarang.val()) > 1) {
                        jumlahBarang.val(parseInt(jumlahBarang.val()) - 1);
                    }
                });

                // Rebind custom input handling functions
                $('#nominalPengeluaran').on('keydown', preventBackspace);
                $('#nominalPengeluaran').on('input', enforceNumericInput);
                $('#nominalPengeluaran').on('blur', addCurrencySuffix);
            }

            function preventBackspace(event) {
                var input = document.getElementById('nominalPengeluaran');
                if (input.selectionStart <= 4 && (event.key === 'Backspace' || event.key === 'Delete')) {
                    event.preventDefault();
                }
            }

            function enforceNumericInput(event) {
                var input = document.getElementById('nominalPengeluaran');
                var value = input.value;

                // Remove any non-digit characters except the prefix
                var numberValue = value.slice(4).replace(/\D/g, '');

                // Format the number with dots as thousand separators
                var formattedValue = numberValue.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                // Update the input value with the formatted number
                input.value = 'Rp. ' + formattedValue;
            }

            function addCurrencySuffix() {
                var input = document.getElementById('nominalPengeluaran');
                var value = input.value;

                // Ensure the value ends with ",-"
                if (value.length > 4 && !value.endsWith(',-')) {
                    input.value = value + ',-';
                }
            }

            // Initial bind for Pengeluaran modal
            rebindPengeluaranEvents();

            // Handle 'Deskripsi' change event to switch between dynamic fields
            $('#deskripsi').on('change', function() {
                if ($(this).val() === 'lainnya') {
                    $('#dynamicFields').html(`
                        <div class="form-group position-relative mb-2">
                            <label for="deskripsiTransaksi" class="col-form-label" id="inputModalLabel">Deskripsi Transaksi</label>
                            <textarea class="form-control border-style" id="deskripsiTransaksi" placeholder="Masukkan deskripsi transaksi" rows="3"></textarea>
                        </div>
                        <div class="form-group-select position-relative mb-2">
                            <label for="kategori" class="col-form-label" id="inputModalLabel">Kategori</label>
                            <select class="form-control border-style" id="kategori">
                                <option value="none">None</option>
                                <option value="kategori1">Kategori 1</option>
                                <option value="kategori2">Kategori 2</option>
                                <option value="kategori3">Kategori 3</option>
                            </select>
                        </div>
                        <div class="form-group position-relative mb-2">
                            <label for="nominalPengeluaran" class="col-form-label" id="inputModalLabel">Nominal</label>
                            <input type="text" class="form-control border-style" id="nominalPengeluaran" value="Rp. ">
                        </div>
                    `);
                } else {
                    $('#dynamicFields').html(`
                        <div class="form-group-select position-relative mb-2" id="jenisBarangField">
                            <label for="jenisBarang" class="col-form-label" id="inputModalLabel">Jenis Barang</label>
                            <select class="form-control border-style" id="jenisBarang">
                                <option value="none">None</option>
                                <option value="none">None</option>
                                <option value="none">None</option>
                            </select>
                        </div>
                        <div class="form-group position-relative mb-2" id="jumlahBarangField">
                            <label for="jumlahBarangPengeluaran" class="col-form-label" id="inputModalLabel">Jumlah Barang</label>
                            <div class="input-group input-group-outline border-style">
                                <button class="btn" type="button" id="decrementPengeluaran">
                                    <span class="iconify" data-icon="ph:minus-bold" data-width="24" data-height="24"></span>
                                </button>
                                <input type="text" class="form-control border-style text-center" id="jumlahBarangPengeluaran" value="0" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                <button class="btn" type="button" id="incrementPengeluaran">
                                    <span class="iconify" data-icon="ic:round-plus" data-width="24" data-height="24"></span>
                                </button>
                            </div>
                        </div>
                        <div class="form-group position-relative mb-2" id="nominalField">
                            <label for="nominalPengeluaran" class="col-form-label" id="inputModalLabel">Nominal</label>
                            <input type="text" class="form-control border-style" id="nominalPengeluaran" value="Rp. ">
                        </div>
                    `);
                }

                // Rebind events for the newly created elements
                rebindPengeluaranEvents();
            });
        });
    </script>
</x-layout>
