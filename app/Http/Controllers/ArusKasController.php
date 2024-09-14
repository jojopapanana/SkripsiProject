<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use App\Models\Product;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;

class ArusKasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $selectedMonth = $request->get('month', date('n'));
        $pendapatan_operasional = DB::table('transaksis')->join('transaction_details', 'transaksis.id', '=', 'transaction_details.transactionID')
                                                        ->join('products', 'transaction_details.productID', '=', 'products.id')
                                                        ->where([
                                                            [DB::raw('month(transaksis.created_at)'), '=', $selectedMonth],
                                                            ['transaksis.category', '=', 'Operasional'], 
                                                            ['transaksis.type', '=', 'Pemasukan'], 
                                                            ['transaksis.method', '=', 'Tunai']])
                                                        ->select(DB::raw('month(transaksis.created_at) as transactionMonth'), DB::raw('SUM(transaction_details.productQuantity * products.productPrice) as totalPerMonth'))
                                                        ->groupBy('transactionMonth')
                                                        ->get();

        $pengeluaran_operasional = DB::table('transaksis')->where([
                                                            [DB::raw('month(transaksis.created_at)'), '=', $selectedMonth],
                                                            ['transaksis.category', '=', 'Operasional'], 
                                                            ['transaksis.type', '=', 'Pengeluaran'], 
                                                            ['transaksis.method', '=', 'Tunai']])
                                                        ->select(DB::raw('month(transaksis.created_at) as transactionMonth'), DB::raw('SUM(transaksis.nominal) as totalPerMonth'))
                                                        ->groupBy('transactionMonth')
                                                        ->get();

        $totalPendapatan = $pendapatan_operasional->isNotEmpty() ? $pendapatan_operasional->first()->totalPerMonth : 0;
        $totalPengeluaran = $pengeluaran_operasional->isNotEmpty() ? $pengeluaran_operasional->first()->totalPerMonth : 0;

        $total_arus_kas_operasional = $totalPendapatan - $totalPengeluaran;


        $pendapatan_investasi = DB::table('transaksis')->where([
                                                            [DB::raw('month(transaksis.created_at)'), '=', $selectedMonth],
                                                            ['transaksis.category', '=', 'Finansial'], 
                                                            ['transaksis.type', '=', 'Pemasukan'], 
                                                            ['transaksis.method', '=', 'Tunai']])
                                                        ->select(DB::raw('month(transaksis.created_at) as transactionMonth'), DB::raw('SUM(transaksis.nominal) as totalPerMonth'))
                                                        ->groupBy('transactionMonth')
                                                        ->get();

        $pengeluaran_investasi = DB::table('transaksis')->where([
                                                            [DB::raw('month(transaksis.created_at)'), '=', $selectedMonth],
                                                            ['transaksis.category', '=', 'Finansial'], 
                                                            ['transaksis.type', '=', 'Pengeluaran'], 
                                                            ['transaksis.method', '=', 'Tunai']])
                                                        ->select(DB::raw('month(transaksis.created_at) as transactionMonth'), DB::raw('SUM(transaksis.nominal) as totalPerMonth'))
                                                        ->groupBy('transactionMonth')
                                                        ->get();

        $totalPendapatanInvestasi = $pendapatan_investasi->isNotEmpty() ? $pendapatan_investasi->first()->totalPerMonth : 0;
        $totalPengeluaranInvestasi = $pengeluaran_investasi->isNotEmpty() ? $pengeluaran_investasi->first()->totalPerMonth : 0;

        $total_arus_kas_investasi = $totalPendapatanInvestasi - $totalPengeluaranInvestasi;

        $previousMonth = ($request->get('month', date('n')) - 1) ?: 12;

        $kenaikan_arus_kas = $total_arus_kas_operasional + $total_arus_kas_investasi;
        $saldo_awal_kas_pendapatan = DB::table('transaksis')->where([
                                                    [DB::raw('month(transaksis.created_at)'), '=', $previousMonth],
                                                    ['transaksis.type', '=', 'Pendapatan'], 
                                                    ['transaksis.method', '=', 'Tunai']])
                                                ->select(DB::raw('month(transaksis.created_at) as transactionMonth'), DB::raw('SUM(transaksis.nominal) as totalPerMonth'))
                                                ->groupBy('transactionMonth')
                                                ->get();
        $saldo_awal_kas_pengeluaran = DB::table('transaksis')->where([
                                                    [DB::raw('month(transaksis.created_at)'), '=', $previousMonth],
                                                    ['transaksis.type', '=', 'Pengeluaran'], 
                                                    ['transaksis.method', '=', 'Tunai']])
                                                ->select(DB::raw('month(transaksis.created_at) as transactionMonth'), DB::raw('SUM(transaksis.nominal) as totalPerMonth'))
                                                ->groupBy('transactionMonth')
                                                ->get();
        $totalPendapatanAwal = $saldo_awal_kas_pendapatan->isNotEmpty() ? $saldo_awal_kas_pendapatan->first()->totalPerMonth : 0;
        $totalPengeluaranAwal = $saldo_awal_kas_pengeluaran->isNotEmpty() ? $saldo_awal_kas_pengeluaran->first()->totalPerMonth : 0;
        $saldo_awal_kas = $totalPendapatanAwal - $totalPengeluaranAwal;
        $saldo_akhir_kas = $kenaikan_arus_kas + $saldo_awal_kas;

        return view('aruskas', [
            'pendapatan_operasional' => $pendapatan_operasional,
            'pengeluaran_operasional' => $pengeluaran_operasional,
            'total_arus_kas_operasional' => $total_arus_kas_operasional,
            'pendapatan_investasi' => $pendapatan_investasi,
            'pengeluaran_investasi' => $pengeluaran_investasi,
            'total_arus_kas_investasi' => $total_arus_kas_investasi,
            'kenaikan_arus_kas' => $kenaikan_arus_kas,
            'saldo_awal_kas' => $saldo_awal_kas,
            'saldo_akhir_kas' => $saldo_akhir_kas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
