<div class="card mt-5">
    <div class="card-body">
        <h3 class="fw-bold fs-4">Arus Kas Operasional</h3>

        <div class="d-flex justify-content-between">
            <div class="text-start fs-6 fw-normal">Penerimaan Kas Penjualan</div>
            <div class="text-end fs-6 fw-bold" style="color: rgba(13, 190, 0, 1)">
                @foreach ($pendapatan_operasional as $p)
                    Rp. {{ number_format($p->totalPerMonth, 0, ',', '.') }}
                @endforeach
            </div>
        </div>

        <div class="d-flex justify-content-between">
            @foreach ($semua_pengeluaran_operasional as $p)
                <div class="text-start fs-6 fw-normal">{{ $p->deskripsi }}</div>
                <div class="text-end fs-6 fw-bold" style="color: red">
                    (Rp. {{ number_format($p->nominal, 0, ',', '.') }})
                </div>
            @endforeach
        </div>

        <hr class="my-2">

        <div class="d-flex justify-content-between">
            <div class="text-start fs-6 fw-bold">Total Arus Kas Operasional</div>
            <div class="text-end fs-6 fw-bold">
                Rp. {{ number_format($total_arus_kas_operasional, 0, ',', '.') }}
            </div>
        </div>

        <h3 class="fw-bold mt-4">Arus Kas Investasi</h3>

        <div class="d-flex justify-content-between">
            <div class="text-start fs-6 fw-normal">Biaya Investasi Usaha</div>
            <div class="text-end fs-6 fw-bold" style="color: red">
                @foreach ($pengeluaran_investasi as $p)
                    (Rp. {{ number_format($p->totalPerMonth, 0, ',', '.') }})
                @endforeach
            </div>
        </div>
        <hr class="my-2">
        <div class="d-flex justify-content-between">
            <div class="text-start fs-6 fw-bold">Total Arus Kas Investasi</div>
            <div class="text-end fs-6 fw-bold">
                Rp. {{ number_format($total_pengeluaran_investasi, 0, ',', '.') }}
            </div>
        </div>

        <h3 class="fw-bold mt-4">Rangkuman</h3>

        <div class="d-flex justify-content-between">
            <div class="text-start fs-6 fw-bold">Kenaikan/Penurunan Kas</div>
                @if($status == 'Untung')
                    <div class="text-end fs-6 fw-bold" style="color: rgba(13, 190, 0, 1)">
                        Rp. {{ number_format($kenaikan_arus_kas, 0, ',', '.') }}
                    </div>
                @elseif($status == 'Rugi')
                    <div class="text-end fs-6 fw-bold" style="color: red">
                        Rp. {{ number_format($kenaikan_arus_kas, 0, ',', '.') }}
                    </div>
                @else
                    <div class="text-end fs-6 fw-bold">
                        Rp. {{ number_format($kenaikan_arus_kas, 0, ',', '.') }}
                    </div>
                @endif
        </div>
        <div class="d-flex justify-content-between">
            <div class="text-start fs-6 fw-bold">Saldo Kas Awal</div>
            <div class="text-end fs-6 fw-bold">
                Rp. {{ number_format($saldo_awal_kas, 0, ',', '.') }}
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <div class="text-start fs-6 fw-bold">Saldo Kas Akhir</div>
            <div class="text-end fs-6 fw-bold">
                Rp. {{ number_format($saldo_akhir_kas, 0, ',', '.') }}
            </div>
        </div>
    </div>
</div>
