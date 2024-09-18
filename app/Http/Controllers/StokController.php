<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\StokModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $top_products = DB::table('products')
                        ->select('productName', 'productStock')
                        ->orderBy('productStock', 'desc')
                        ->limit(5)
                        ->get();

        $total_products_sold = DB::table('transaction_details')
                        ->join('transaksis', 'transaction_details.transactionID', '=', 'transaksis.id')
                        ->join('products', 'transaction_details.productID', '=', 'products.id')
                        ->sum('transaction_details.productQuantity');
                        
        return view('stok', ['top_products' => $top_products, 'total_products_sold' => $total_products_sold]);
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
