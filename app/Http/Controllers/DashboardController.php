<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $selectedMonth = Carbon::now()->format('m');
        $pendapatan_kotor = DB::table('transaksis')->join('transaction_details', 'transaksis.id', '=', 'transaction_details.transactionID')
                                            ->join('products', 'transaction_details.productID', '=', 'products.id')
                                            ->select('transaksis.created_at as date', DB::raw('SUM(transaction_details.productQuantity * products.productPrice) as pendapatan'))
                                            ->where([['transaksis.type', '=', 'Pemasukan'], [DB::raw('month(transaksis.created_at)'), '=', $selectedMonth]])
                                            ->groupBy('date')
                                            ->get()
                                            ->keyBy('date');

        $pengeluaran = DB::table('transaksis')
                                            ->select('transaksis.created_at as date', DB::raw('SUM(transaksis.nominal) as pengeluaran'))
                                            ->where([['transaksis.type', '=', 'Pengeluaran'], [DB::raw('month(transaksis.created_at)'), '=', $selectedMonth]])
                                            ->groupBy('date')
                                            ->get()
                                            ->keyBy('date');

        $finalCollection = collect();

        $allDates = $pendapatan_kotor->keys()->merge($pengeluaran->keys())->unique();
                                            
        foreach ($allDates as $date) {
            $pendapatan = $pendapatan_kotor->has($date) ? $pendapatan_kotor->get($date)->pendapatan : 0;
            $nominalPengeluaran = $pengeluaran->has($date) ? $pengeluaran->get($date)->pengeluaran : 0;
                                            
            $total = $pendapatan - $nominalPengeluaran;
                                            
            $finalCollection->push((object)[
                'date' => $date,
                'total' => $total,
            ]);
        }

        $data = $finalCollection->map(function($item) {
            return (object) $item;
        });

        $products = Product::all();
        return view('welcome', compact('products'), [
            'data' => $data
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
