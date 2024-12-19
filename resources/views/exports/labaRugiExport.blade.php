<div class="card mt-5">
    <div class="card-body">
        <h3 class="fw-bold">Pemasukan</h3>
        @foreach($laba as $profits)
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="text-start fs-6 fw-normal mt-2">{{ $profits->description }}</div>
                <div class="text-end fs-6 fw-bold mt-2" style="color: rgba(13, 190, 0, 1);">
                    Rp. {{ number_format($profits->totalNominal, 0, ',', '.') }}
                </div>
            </div>
        @endforeach

        <hr class="my-2">

        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="text-start fs-6 fw-bold">Total Pemasukan</div>
            <div class="text-end fs-6 fw-bold">
                Rp. {{ number_format($total_laba, 0, ',', '.') }}
            </div>
        </div>

        <br>

        <h3 class="fw-bold mt-2">Pengeluaran</h3>
        @foreach($rugi as $loss)
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="text-start fs-6 fw-normal mt-2">{{ $loss->description }}</div>
                <div class="text-end fs-6 fw-bold mt-2" style="color: red;">
                    (Rp. {{ number_format($loss->nominal, 0, ',', '.') }})
                </div>
            </div>
        @endforeach

        <hr class="my-2">

        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="text-start fs-6 fw-bold">Total Pengeluaran</div>
            <div class="text-end fs-6 fw-bold">
                Rp. {{ number_format($total_rugi, 0, ',', '.') }}
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-2" style="margin-top: 20px">
            <div class="text-start fs-6 fw-bold">Total Laba/Rugi</div>
            @if($status == 'Untung')
                <div class="text-end fs-6 fw-bold" style="color: rgba(13, 190, 0, 1);">
                    Rp. {{ number_format($balance, 0, ',', '.') }}
                </div>
            @elseif($status == 'Rugi')
                <div class="text-end fs-6 fw-bold" style="color: red;">
                    Rp. {{ number_format($balance, 0, ',', '.') }}
                </div>
            @else
                <div class="text-end fs-6 fw-bold">
                    Rp. 0
                </div>
            @endif
        </div>
    </div>
</div>