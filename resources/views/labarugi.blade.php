<x-layout title="Transaksi">
    <div class="d-flex justify-content-center" style="width: 70vw">
        <h1 class="fw-bold">LAPORAN LABA RUGI</h1>
    </div>
    <div class="d-flex justify-content-center gap-3 mt-3" style="width: 70vw">
      <div class="dropdown">
          <button class="dropdown-toggle px-5 py-2 fs-5 fw-bold" id="dropdown-bulan-transaksi" data-bs-toggle="dropdown" aria-expanded="true" style="border: 1.5px solid rgba(30, 3, 66, 1); border-radius: 10px; background-color: white;">
              BULAN
          </button>
          <ul class="dropdown-menu" style="width: 100%;">
              <li><a class="dropdown-item" href="#">Januari</a></li>
              <li><a class="dropdown-item" href="#">Februari</a></li>
              <li><a class="dropdown-item" href="#">Maret</a></li>
              <li><a class="dropdown-item" href="#">April</a></li>
              <li><a class="dropdown-item" href="#">Mei</a></li>
              <li><a class="dropdown-item" href="#">Juni</a></li>
              <li><a class="dropdown-item" href="#">Juli</a></li>
              <li><a class="dropdown-item" href="#">Agustus</a></li>
              <li><a class="dropdown-item" href="#">September</a></li>
              <li><a class="dropdown-item" href="#">Oktober</a></li>
              <li><a class="dropdown-item" href="#">November</a></li>
              <li><a class="dropdown-item" href="#">Desember</a></li>
          </ul>
      </div>

      <div class="dropdown" id="dropdown-tahun-transaksi">
          <button class="dropdown-toggle px-5 py-2 fs-5 fw-bold" type="button" data-bs-toggle="dropdown" aria-expanded="true" style="border: 1.5px solid rgba(30, 3, 66, 1); border-radius: 10px; background-color: white;">
              TAHUN
          </button>
          <ul class="dropdown-menu" style="width: 100%;">
              <li><a class="dropdown-item" href="#">2024</a></li>
              <li><a class="dropdown-item" href="#">2025</a></li>
              <li><a class="dropdown-item" href="#">2026</a></li>
          </ul>
      </div>
  </div>
    <div class="card mt-4">
        <div class="card-body">
            <h6 class="fw-bold">Pemasukan</h6>
            <div class="row">
                <div class="col">
                    @forEach($laba as $profits)
                        <div class="justify-content-start">
                            <h3 class="text-start fs-6 fw-normal mt-2">{{ $profits->description }}</h3>
                        </div>
                    @endforeach
                </div>
                <div class="col">
                    @forEach($laba as $profits)
                            <div class="justify-content-end">
                            <h3 class="text-end fs-6 fw-bold text-success">Rp. {{ number_format($profits->nominal, 0, ',', '.') }}</h3>
                        </div>
                    @endforeach
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <div class="justify-content-start">
                        <h5 class="text-start fs-6 fw-bold">Total Pemasukan</h4>
                    </div>
                </div>
                <div class="col">
                    <div class="justify-content-end">
                        <h3 class="text-end fs-6 fw-bold">Rp. {{ number_format($total_laba, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <br>
            <h6 class="fw-bold">Pengeluaran</h6>
            <div class="row">
                <div class="col">
                    @forEach($rugi as $loss)
                        <div class="justify-content-start">
                            <h3 class="text-start fs-6 fw-normal mt-2">{{ $loss->description }}</h3>
                        </div>
                    @endforeach
                </div>
                <div class="col">
                    @forEach($rugi as $loss)
                            <div class="justify-content-end">
                            <h3 class="text-end fs-6 fw-bold text-danger">- Rp. {{ number_format($loss->nominal, 0, ',', '.') }}</h3>
                        </div>
                    @endforeach
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <div class="justify-content-start">
                        <h5 class="text-start fs-6 fw-bold">Total Pengeluaran</h4>
                    </div>
                </div>
                <div class="col">
                    <div class="justify-content-end">
                        <h3 class="text-end fs-6 fw-bold">Rp. {{ number_format($total_rugi, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="justify-content-start">
                        <h5 class="text-start fs-6 fw-bold">Total Laba/Rugi</h4>
                    </div>
                </div>
                <div class="col">
                    @if($status == 'Untung')
                        <div class="justify-content-end">
                            <h3 class="text-end fs-6 fw-bold text-success">Rp. {{ number_format($balance, 0, ',', '.') }}</h3>
                        </div>
                    @elseif($status == 'Rugi')
                        <div class="justify-content-end">
                            <h3 class="text-end fs-6 fw-bold text-danger">- Rp. {{ number_format($balance, 0, ',', '.') }}</h3>
                        </div>
                    @else
                        <div class="justify-content-end">
                            <h3 class="text-end fs-6 fw-bold text-success">Rp. 0</h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout>