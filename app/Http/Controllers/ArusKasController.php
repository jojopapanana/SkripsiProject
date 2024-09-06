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

        $pengeluaran_operasional = DB::table('transaksis')->join('transaction_details', 'transaksis.id', '=', 'transaction_details.transactionID')
                                                        ->join('products', 'transaction_details.productID', '=', 'products.id')
                                                        ->where([
                                                            [DB::raw('month(transaksis.created_at)'), '=', $selectedMonth],
                                                            ['transaksis.category', '=', 'Operasional'], 
                                                            ['transaksis.type', '=', 'Pengeluaran'], 
                                                            ['transaksis.method', '=', 'Tunai']])
                                                        ->select(DB::raw('month(transaksis.created_at) as transactionMonth'), DB::raw('SUM(transaction_details.productQuantity * products.productPrice) as totalPerMonth'))
                                                        ->groupBy('transactionMonth')
                                                        ->get();
        return view('aruskas', ['pendapatan_operasional' => $pendapatan_operasional], ['pengeluaran_operasional' => $pengeluaran_operasional]);
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
