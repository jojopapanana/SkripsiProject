<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\StokModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;

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
                        
                        $stokData = DB::table('products')
                        ->leftJoin('transaction_details', 'products.id', '=', 'transaction_details.productID')
                        ->leftJoin('transaksis', 'transaction_details.transactionID', '=', 'transaksis.id')
                        ->select(
                            'products.id as stok_id',
                            'products.productName as nama',
                            'products.productPrice as nominal',
                            'products.productStock as sisa'
                        )
                        ->groupBy('products.id', 'products.productName', 'products.productPrice', 'products.productStock')
                        ->get();

        return view('stok', ['top_products' => $top_products, 'total_products_sold' => $total_products_sold, 'stokData' => $stokData]);
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
    public function delete(string $id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return redirect()->back()->with('success', 'SUCCESS : Berhasil Dihapus');
        }

        return redirect()->back()->with('error', 'ERROR : Stok Tidak Ditemukan');
    }
}
