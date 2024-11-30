<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userid = Auth::check() ? Auth::id() : null;
        $selectedMonth = Carbon::now()->format('m');
        $pendapatan_kotor_harian = DB::table('transaksis')->join('transaction_details', 'transaksis.id', '=', 'transaction_details.transactionID')
                                            ->join('products', 'transaction_details.productID', '=', 'products.id')
                                            ->select('transaksis.created_at as date', DB::raw('SUM(transaction_details.productQuantity * products.productPrice) as pendapatan'))
                                            ->where([['transaksis.type', '=', 'Pemasukan'], [DB::raw('month(transaksis.created_at)'), '=', $selectedMonth], ['transaksis.userID', '=', $userid]])
                                            ->groupBy('date')
                                            ->get()
                                            ->keyBy('date');

        $pengeluaran_harian = DB::table('transaksis')
                                            ->select('transaksis.created_at as date', DB::raw('SUM(transaksis.nominal) as pengeluaran'))
                                            ->where([['transaksis.type', '=', 'Pengeluaran'], [DB::raw('month(transaksis.created_at)'), '=', $selectedMonth], ['transaksis.userID', '=', $userid]])
                                            ->groupBy('date')
                                            ->get()
                                            ->keyBy('date');

        $finalCollection = collect();

        $allDates = $pendapatan_kotor_harian->keys()->merge($pengeluaran_harian->keys())->unique();
                                            
        foreach ($allDates as $date) {
            $pendapatan = $pendapatan_kotor_harian->has($date) ? $pendapatan_kotor_harian->get($date)->pendapatan : 0;
            $nominalPengeluaran = $pengeluaran_harian->has($date) ? $pengeluaran_harian->get($date)->pengeluaran : 0;
                                            
            $total = $pendapatan - $nominalPengeluaran;
                                            
            $finalCollection->push((object)[
                'date' => $date,
                'total' => $total,
            ]);
        }

        $data = $finalCollection->map(function($item) {
            return (object) $item;
        });


        $pendapatan_kotor = DB::table('transaksis')->join('transaction_details', 'transaksis.id', '=', 'transaction_details.transactionID')
                                            ->join('products', 'transaction_details.productID', '=', 'products.id')
                                            ->select(DB::raw('month(transaksis.created_at) as transactionMonth'), DB::raw('SUM(transaction_details.productQuantity * products.productPrice) as pendapatan'))
                                            ->where([['transaksis.type', '=', 'Pemasukan'], [DB::raw('month(transaksis.created_at)'), '=', $selectedMonth], ['transaksis.userID', '=', $userid]])
                                            ->groupBy('transactionMonth')
                                            ->get();

        $pengeluaran = DB::table('transaksis')
                                            ->select(DB::raw('month(transaksis.created_at) as transactionMonth'), DB::raw('SUM(transaksis.nominal) as pengeluaran'))
                                            ->where([['transaksis.type', '=', 'Pengeluaran'], [DB::raw('month(transaksis.created_at)'), '=', $selectedMonth], ['transaksis.userID', '=', $userid]])
                                            ->groupBy('transactionMonth')
                                            ->get();

        $pendapatan_kotor_bulanan = $pendapatan_kotor->isNotEmpty() ? $pendapatan_kotor->first()->pendapatan : 0;
        $pengeluaran_kotor_bulanan = $pengeluaran->isNotEmpty() ? $pengeluaran->first()->pengeluaran : 0;

        $pendapatan_bersih_bulanan = $pendapatan_kotor_bulanan - $pengeluaran_kotor_bulanan;

        $pendapatan_operasional = DB::table('transaksis')->join('transaction_details', 'transaksis.id', '=', 'transaction_details.transactionID')
                                                        ->join('products', 'transaction_details.productID', '=', 'products.id')
                                                        ->where([
                                                            [DB::raw('month(transaksis.created_at)'), '=', $selectedMonth],
                                                            ['transaksis.category', '=', 'Operasional'], 
                                                            ['transaksis.type', '=', 'Pemasukan'], 
                                                            ['transaksis.method', '=', 'Tunai'], ['transaksis.userID', '=', $userid]])
                                                        ->select(DB::raw('month(transaksis.created_at) as transactionMonth'), DB::raw('SUM(transaction_details.productQuantity * products.productPrice) as totalPerMonth'))
                                                        ->groupBy('transactionMonth')
                                                        ->get();

        $pengeluaran_operasional = DB::table('transaksis')->where([
                                                            [DB::raw('month(transaksis.created_at)'), '=', $selectedMonth],
                                                            ['transaksis.category', '=', 'Operasional'], 
                                                            ['transaksis.type', '=', 'Pengeluaran'], 
                                                            ['transaksis.method', '=', 'Tunai'], ['transaksis.userID', '=', $userid]])
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
                                                            ['transaksis.method', '=', 'Tunai'], ['transaksis.userID', '=', $userid]])
                                                        ->select(DB::raw('month(transaksis.created_at) as transactionMonth'), DB::raw('SUM(transaksis.nominal) as totalPerMonth'))
                                                        ->groupBy('transactionMonth')
                                                        ->get();

        $pengeluaran_investasi = DB::table('transaksis')->where([
                                                            [DB::raw('month(transaksis.created_at)'), '=', $selectedMonth],
                                                            ['transaksis.category', '=', 'Finansial'], 
                                                            ['transaksis.type', '=', 'Pengeluaran'], 
                                                            ['transaksis.method', '=', 'Tunai'], ['transaksis.userID', '=', $userid]])
                                                        ->select(DB::raw('month(transaksis.created_at) as transactionMonth'), DB::raw('SUM(transaksis.nominal) as totalPerMonth'))
                                                        ->groupBy('transactionMonth')
                                                        ->get();

        $totalPendapatanInvestasi = $pendapatan_investasi->isNotEmpty() ? $pendapatan_investasi->first()->totalPerMonth : 0;
        $totalPengeluaranInvestasi = $pengeluaran_investasi->isNotEmpty() ? $pengeluaran_investasi->first()->totalPerMonth : 0;

        $total_arus_kas_investasi = $totalPendapatanInvestasi - $totalPengeluaranInvestasi;
        $kas_bulanan = $total_arus_kas_operasional + $total_arus_kas_investasi;

        $products = DB::table('products')->select('*')->where('userID', '=', $userid)->get();
        
        return view('welcome', compact('products'), [
            'data' => $data,
            'pendapatan_bersih_bulanan' => $pendapatan_bersih_bulanan,
            'kas_bulanan' => $kas_bulanan
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
