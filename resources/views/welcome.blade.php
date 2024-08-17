<x-layout title="Hello">
    <p>helo world</p>
    <p>ini project skripsi</p>

    <div class="d-flex">
        <button type="button" class="btn btn-primary custom-modal-btn mr-2" data-toggle="modal" data-target="#exampleModal">
            + Tambah Pemasukan
        </button>
        <button type="button" class="btn btn-primary custom-modal-btn" data-toggle="modal" data-target="#exampleModal">
            - Tambah Pengeluaran
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered custom-modal-width" role="document">
            <div class="modal-content pl-3 pr-3">
                <div class="modal-header justify-content-center">
                    <p class="modal-title" id="exampleModalLabel">Tambah Transaksi</p>
                </div>
                <div class="modal-body">
                    <form class="mb-2">
                        <div class="form-group position-relative mb-2">
                            <label for="tanggal" class="col-form-label" id="inputModalLabel">Tanggal</label>
                            <span class="input-group-text border-style" id="basic-addon1">2024-08-08</span>
                        </div>
                        <div class="form-group position-relative mb-2">
                            <label for="jenisTransaksi" class="col-form-label" id="inputModalLabel">Jenis Transaksi</label>
                            <span class="input-group-text border-style" id="basic-addon1">Pengeluaran</span>
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
                                <input type="text" class="form-control border-style text-center" id="jumlahBarang" value="0">
                                <button class="btn" type="button" id="increment">
                                    <span class="iconify" data-icon="ic:round-plus" data-width="24" data-height="24"></span>
                                </button>
                            </div>
                        </div>
                        <div class="form-group position-relative mb-2">
                            <label for="nominal" class="col-form-label" id="inputModalLabel">Nominal</label>
                            <input type="text" class="form-control border-style" id="nominal" value="Rp. " onkeydown="preventBackspace(event)" oninput="enforceNumericInput(event)" onblur="addCurrencySuffix()">
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

    <!-- jQuery, Popper.js, and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Iconify icon -->
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

    <script>
        $(document).ready(function(){
            $('#exampleModal').on('shown.bs.modal', function () {
                $('#myInput').trigger('focus');
            });
        });
    </script>

    <script>
        document.getElementById('increment').addEventListener('click', function() {
            var jumlahBarang = document.getElementById('jumlahBarang');
            jumlahBarang.value = parseInt(jumlahBarang.value) + 1;
        });

        document.getElementById('decrement').addEventListener('click', function() {
            var jumlahBarang = document.getElementById('jumlahBarang');
            if (parseInt(jumlahBarang.value) > 1) { // Prevent going below 1
                jumlahBarang.value = parseInt(jumlahBarang.value) - 1;
            }
        });
    </script>

    <script>
        function preventBackspace(event) {
            var input = document.getElementById('nominal');
            if (input.selectionStart <= 4 && (event.key === 'Backspace' || event.key === 'Delete')) {
                event.preventDefault();
            }
        }

        function enforceNumericInput(event) {
            var input = document.getElementById('nominal');
            var value = input.value;

            // Remove any non-digit characters except the prefix
            var numberValue = value.slice(4).replace(/\D/g, '');

            // Format the number with dots as thousand separators
            var formattedValue = numberValue.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

            // Update the input value with the formatted number
            input.value = 'Rp. ' + formattedValue;
        }

        function addCurrencySuffix() {
            var input = document.getElementById('nominal');
            var value = input.value;

            // Ensure the value ends with ",-"
            if (value.length > 4 && !value.endsWith(',-')) {
                input.value = value + ',-';
            }
        }
    </script>
</x-layout>
