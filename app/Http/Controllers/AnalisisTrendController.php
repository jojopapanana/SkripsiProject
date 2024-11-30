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

class AnalisisTrendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userid = Auth::check() ? Auth::id() : null;
        $rangeWaktu = $request->input('rangeWaktu'); 

        $produkTerbanyak = collect();
        $produkTerdikit = collect();

        if ($rangeWaktu == 'bulanan') {
            $produkTerbanyak = DB::table('transaction_details')
                ->select(DB::raw('MONTH(transaksis.created_at) as bulan, products.productName, SUM(transaction_details.productQuantity) as total_terjual'))
                ->join('products', 'transaction_details.productID', '=', 'products.id')
                ->join('transaksis', 'transaction_details.transactionID', '=', 'transaksis.id')
                ->where('transaksis.userID', '=', $userid)
                ->groupBy('bulan', 'products.productName')
                ->orderBy('total_terjual', 'desc')
                ->get()
                ->groupBy('bulan');

            $produkTerdikit = DB::table('transaction_details')
                ->select(DB::raw('MONTH(transaksis.created_at) as bulan, products.productName, SUM(transaction_details.productQuantity) as total_terjual'))
                ->join('products', 'transaction_details.productID', '=', 'products.id')
                ->join('transaksis', 'transaction_details.transactionID', '=', 'transaksis.id')
                ->where('transaksis.userID', '=', $userid)
                ->groupBy('bulan', 'products.productName')
                ->orderBy('total_terjual', 'asc')
                ->get()
                ->groupBy('bulan');

        } elseif ($rangeWaktu == 'mingguan') {
            $produkTerbanyak = DB::table('transaction_details')
                ->select(DB::raw('WEEK(transaksis.created_at) as minggu, products.productName, SUM(transaction_details.productQuantity) as total_terjual'))
                ->join('products', 'transaction_details.productID', '=', 'products.id')
                ->join('transaksis', 'transaction_details.transactionID', '=', 'transaksis.id')
                ->where('transaksis.userID', '=', $userid)
                ->groupBy('minggu', 'products.productName')
                ->orderBy('total_terjual', 'desc')
                ->get()
                ->groupBy('minggu');

            $produkTerdikit = DB::table('transaction_details')
                ->select(DB::raw('WEEK(transaksis.created_at) as minggu, products.productName, SUM(transaction_details.productQuantity) as total_terjual'))
                ->join('products', 'transaction_details.productID', '=', 'products.id')
                ->join('transaksis', 'transaction_details.transactionID', '=', 'transaksis.id')
                ->where('transaksis.userID', '=', $userid)
                ->groupBy('minggu', 'products.productName')
                ->orderBy('total_terjual', 'asc')
                ->get()
                ->groupBy('minggu');

        } elseif ($rangeWaktu == 'tahunan') {
            $produkTerbanyak = DB::table('transaction_details')
                ->select(DB::raw('YEAR(transaksis.created_at) as tahun, products.productName, SUM(transaction_details.productQuantity) as total_terjual'))
                ->join('products', 'transaction_details.productID', '=', 'products.id')
                ->join('transaksis', 'transaction_details.transactionID', '=', 'transaksis.id')
                ->where('transaksis.userID', '=', $userid)
                ->groupBy('tahun', 'products.productName')
                ->orderBy('total_terjual', 'desc')
                ->get()
                ->groupBy('tahun');

            $produkTerdikit = DB::table('transaction_details')
                ->select(DB::raw('YEAR(transaksis.created_at) as tahun, products.productName, SUM(transaction_details.productQuantity) as total_terjual'))
                ->join('products', 'transaction_details.productID', '=', 'products.id')
                ->join('transaksis', 'transaction_details.transactionID', '=', 'transaksis.id')
                ->where('transaksis.userID', '=', $userid)
                ->groupBy('tahun', 'products.productName')
                ->orderBy('total_terjual', 'asc')
                ->get()
                ->groupBy('tahun');
        }

        $produkTerbanyak = $produkTerbanyak->map(function ($items) {
            return $items->first(); 
        });

        $produkTerdikit = $produkTerdikit->map(function ($items) {
            return $items->first();
        });

        $batasBulan = Carbon::now()->subMonths(6);
        $pendapatanBulanan = DB::table('transaksis')
            ->join('transaction_details', 'transaksis.id', '=', 'transaction_details.transactionID')
            ->join('products', 'transaction_details.productID', '=', 'products.id')
            ->select(DB::raw('DATE_FORMAT(transaksis.created_at, "%Y-%m") as month'), DB::raw('SUM(transaction_details.productQuantity * products.productPrice) as pendapatan'))
            ->where([['transaksis.type', 'Pemasukan'], ['transaksis.created_at', '>=', $batasBulan], ['transaksis.userID', '=', $userid]])
            ->groupBy('month')
            ->get()
            ->keyBy('month');

        $pengeluaranBulanan = DB::table('transaksis')
            ->select(DB::raw('DATE_FORMAT(transaksis.created_at, "%Y-%m") as month'), DB::raw('SUM(transaksis.nominal) as pengeluaran'))
            ->where([['transaksis.type', 'Pengeluaran'], ['transaksis.created_at', '>=', $batasBulan], ['transaksis.userID', '=', $userid]])
            ->groupBy('month')
            ->get()
            ->keyBy('month');

        // Mengambil data harian
        $batasHari = Carbon::now()->subDays(7);
        $pendapatanHarian = DB::table('transaksis')
            ->join('transaction_details', 'transaksis.id', '=', 'transaction_details.transactionID')
            ->join('products', 'transaction_details.productID', '=', 'products.id')
            ->select(DB::raw('DATE_FORMAT(transaksis.created_at, "%Y-%m-%d") as date'), DB::raw('SUM(transaction_details.productQuantity * products.productPrice) as pendapatan'))
            ->where([['transaksis.type', 'Pemasukan'], ['transaksis.created_at', '>=', $batasHari], ['transaksis.userID', '=', $userid]])
            ->groupBy('date')
            ->get()
            ->keyBy('date');

        $pengeluaranHarian = DB::table('transaksis')
            ->select(DB::raw('DATE_FORMAT(transaksis.created_at, "%Y-%m-%d") as date'), DB::raw('SUM(transaksis.nominal) as pengeluaran'))
            ->where([['transaksis.type', 'Pengeluaran'], ['transaksis.created_at', '>=', $batasHari], ['transaksis.userID', '=', $userid]])
            ->groupBy('date')
            ->get()
            ->keyBy('date');

        $finalCollection = collect();
        $enamBulanTerakhir = $pendapatanBulanan->keys()->merge($pengeluaranBulanan->keys())->unique()->sort();

        foreach ($enamBulanTerakhir as $month) {
            $totalPendapatan = $pendapatanBulanan->has($month) ? $pendapatanBulanan->get($month)->pendapatan : 0;
            $totalPengeluaran = $pengeluaranBulanan->has($month) ? $pengeluaranBulanan->get($month)->pengeluaran : 0;
            $total = $totalPendapatan - $totalPengeluaran;

            $finalCollection->push((object)[
                'month' => $month,
                'pendapatan' => $totalPendapatan,
                'pengeluaran' => $totalPengeluaran,
                'total' => $total,
            ]);
        }

        $finalDailyCollection = collect();
        $tujuhHariTerakhir = $pendapatanHarian->keys()->merge($pengeluaranHarian->keys())->unique()->sort();

        foreach ($tujuhHariTerakhir as $date) {
            $totalPendapatan = $pendapatanHarian->has($date) ? $pendapatanHarian->get($date)->pendapatan : 0;
            $totalPengeluaran = $pengeluaranHarian->has($date) ? $pengeluaranHarian->get($date)->pengeluaran : 0;
            $total = $totalPendapatan - $totalPengeluaran;

            $finalDailyCollection->push((object)[
                'date' => $date,
                'pendapatan' => $totalPendapatan,
                'pengeluaran' => $totalPengeluaran,
                'total' => $total,
            ]);
        }

        return view('analisisTrend', [
            'data' => $finalCollection,
            'dailyData' => $finalDailyCollection,
            'produkTerbanyak' => $produkTerbanyak, 
            'produkTerdikit' => $produkTerdikit, 
            'rangeWaktu' => $rangeWaktu
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
    public function show()
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
