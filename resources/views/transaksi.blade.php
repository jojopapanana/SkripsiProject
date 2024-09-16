<x-layout title="Transaksi">
    <div class="d-flex justify-content-center" style="width: 70vw">
        <h1 class="fw-bold">LAPORAN TRANSAKSI</h1>
    </div>
    
    <div class="d-flex justify-content-center gap-3 mt-3" style="width: 70vw">
      <div class="dropdown">
          <button class="btn dropdown-toggle fw-bold" type="button" id="monthDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
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
          <button class="btn dropdown-toggle fw-bold" type="button" id="yearDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
              TAHUN
          </button>
          <ul class="dropdown-menu" id="year-dropdown-menu" aria-labelledby="yearDropdownButton">
              <li><a class="dropdown-item" href="#" data-value="2022">2022</a></li>
              <li><a class="dropdown-item" href="#" data-value="2023">2023</a></li>
              <li><a class="dropdown-item" href="#" data-value="2024">2024</a></li>
          </ul>
      </div>
  </div>

    <div class="table-container mt-4" style="overflow: hidden; border-radius: 10px">
      <table class="table" style="border: none">
        <thead>
          <tr>
            <th scope="col">Kode Transaksi</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Nominal</th>
            <th scope="col">Kategori</th>
            <th scope="col">Jenis</th>
            <th scope="col">Metode</th>
            <th scope="col"></th>
          </tr>
        </thead>
  
        <tbody class="mt-3">
          @forEach($transactions as $transaction)
          <tr>
            <td scope="row">{{ $transaction->id }}</td>
            <td>{{ $transaction->created_at }}</td>
            @forEach($totals as $total)
              @if ($transaction->id == $total->id)
                <td>Rp. {{ $total->totalNominal }}</td>
              @endif
            @endforeach
            <td>{{ $transaction->type }}</td>
            <td>{{ $transaction->category }}</td>
            <td>{{ $transaction->method }}</td>
            <td>
              <div class="d-flex gap-4">
                <button type="button" class="btn p-0" style="border: none" data-bs-toggle="modal" data-bs-target="#editModal">
                  <i class="bi bi-pencil-fill"></i>
                </button>

                <button type="button" class="btn p-0" style="color: red; border: none" data-bs-toggle="modal" data-bs-target="#deleteModal">
                  <i class="bi bi-trash3-fill"></i>
                </button>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

      {{-- <a href="{{ route('transaksi_export') }}" class="btn btn-primary">Export Data</a> --}}
      
      <div class="d-flex justify-content-end">
        <div class="dropdown">
          <button class="btn dropdown-toggle fw-semibold" type="button" id="exportDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
              Ekspor
          </button>
          <ul class="dropdown-menu" id="export-dropdown-menu" aria-labelledby="exportDropdownButton">
              <li><a class="dropdown-item" href="{{ route('transaksi_export_excel', ['month' => request('month', date('m')), 'year' => request('year', date('Y'))]) }}">xlsx</a></li>
              <li><a class="dropdown-item" href="{{ route('transaksi_export_csv') }}">csv</a></li>
              <li><a class="dropdown-item" href="{{ route('transaksi_export_pdf') }}">pdf</a></li>
          </ul>
        </div>
      </div>
      
    </div>
    
  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 text-center fw-bold" id="editModalLabel">Detail Transaksi</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="kodeTransaksi" class="form-label">Kode Transaksi</label>
              <input type="text" class="form-control" id="kodeTransaksi" disabled>
            </div>
            <div class="mb-3">
              <label for="tanggalTransaksi" class="form-label">Tanggal Transaksi</label>
              <input type="date" class="form-control disabled" id="tanggalTransaksi" disabled>
            </div>
            <div class="mb-3">
              <label for="nominalTransaksi" class="form-label">Nominal</label>
              <input type="text" class="form-control" id="nominalTransaksi">
            </div>
            <div class="mb-3">
              <label for="jenisTransaksi" class="form-label">Jenis Transaksi</label>
              <select class="form-select" id="jenisTransaksi">
                <option value="">Pemasukan</option>
                <option value="">Pengeluaran</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="kategoriTransaksi" class="form-label">Kategori</label>
              <select class="form-select" id="kategoriTransaksi">
                <option value="">Operasional</option>
                <option value="">Finanasial</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="metodeTransaksi" class="form-label">Metode</label>
              <select class="form-select" id="metodeTransaksi">
                <option value="">Tunai</option>
                <option value="">Non-Tunai</option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn fw-semibold" style="border: 2px solid rgba(30, 3, 66, 1)" data-bs-dismiss="modal">Tutup</button>
          <button type="button" class="btn fw-semibold" style="background-color: rgba(30, 3, 66, 1); color: white">Simpan</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <center>
            <i class="bi bi-exclamation-triangle-fill" style="font-size: 5rem; color: red"></i>
          </center>

          <h4 class="fw-bold text-center">Apakah kamu yakin ingin menghapus transaksi ini?</h4>

          <div class="d-flex justify-content-center gap-4 mt-4">
            <button type="button" class="btn fw-semibold" style="background-color: rgba(210, 0, 0, 1); width: 5vw; color: white">Ya</button>
            <button type="button" class="btn fw-semibold" style="border: 2px solid black; width: 5vw" data-bs-dismiss="modal">Tidak</button>
          </div>
        </div>
      </div>
    </div>
  </div>

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
</script>

</x-layout>