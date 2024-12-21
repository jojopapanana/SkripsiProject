<div class="mb-5">
    <h3 class="fw-bold" style="font-size: 20px;">Penjualan Stok Terbanyak</h3>
    <div class="card mt-3 mb-3">
        <div class="card-body py-2">
            <table class="w-100">
                <thead>
                    <tr>
                        <th class="text-start" style="width: 20%;">Periode</th>
                        <th class="text-start" style="width: 30%;">Nama Produk</th>
                        <th class="text-start" style="width: 25%;">Jumlah Terjual</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @if($produkTerbanyak->isNotEmpty())
        @foreach($produkTerbanyak as $product)
            <div class="card mt-2">
                <div class="card-body py-2">
                    <table class="w-100">
                        <tbody>
                            <tr>
                                <td class="text-start" style="width: 20%;">
                                    @if($rangeWaktu == 'bulanan')
                                        {{ date('F', mktime(0, 0, 0, $product->bulan)) }}
                                    @elseif($rangeWaktu == 'mingguan')
                                        Minggu ke-{{ $product->minggu }}
                                    @elseif($rangeWaktu == 'tahunan')
                                        {{ $product->tahun }}
                                    @endif
                                </td>
                                <td class="text-start" style="width: 30%;">{{ $product->productName }}</td>
                                <td class="text-start" style="width: 25%;">{{ $product->total_terjual }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @else
        <div class="card mt-3">
            <div class="card-body py-2 m-3">
                <center>
                    <div class="mb-1"><img src="/assets/graph.png" alt="GRAPH" style="width:100px"></div>
                    <p class="fw-semibold mb-2" style="font-size: 20px">Belum ada data analisis nih!</p>
                </center>
            </div>
        </div>
    @endif
</div>

<div class="mb-5">
    <h3 class="fw-bold" style="font-size: 20px;">Penjualan Stok Terdikit</h3>
    <div class="card mt-3 mb-3">
        <div class="card-body py-2">
            <table class="w-100">
                <thead>
                    <tr>
                        <th class="text-start" style="width: 20%;">Periode</th>
                        <th class="text-start" style="width: 30%;">Nama Produk</th>
                        <th class="text-start" style="width: 25%;">Jumlah Terjual</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @if($produkTerdikit->isNotEmpty())
        @foreach($produkTerdikit as $product)
            <div class="card mt-2">
                <div class="card-body py-2">
                    <table class="w-100">
                        <tbody>
                            <tr>
                                <td class="text-start" style="width: 20%;">
                                    @if($rangeWaktu == 'bulanan')
                                        {{ date('F', mktime(0, 0, 0, $product->bulan)) }}
                                    @elseif($rangeWaktu == 'mingguan')
                                        Minggu ke-{{ $product->minggu }}
                                    @elseif($rangeWaktu == 'tahunan')
                                        {{ $product->tahun }}
                                    @endif
                                </td>
                                <td class="text-start" style="width: 30%;">{{ $product->productName }}</td>
                                <td class="text-start" style="width: 25%;">{{ $product->total_terjual }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @else
        <div class="card mt-3">
            <div class="card-body py-2 m-3">
                <center>
                    <div class="mb-1"><img src="/assets/graph.png" alt="GRAPH" style="width:100px"></div>
                    <p class="fw-semibold mb-2" style="font-size: 20px">Belum ada data analisis nih!</p>
                </center>
            </div>
        </div>
    @endif
</div>