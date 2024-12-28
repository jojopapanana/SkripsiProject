<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userid = Auth::check() ? Auth::id() : null;
        $stokDataTemp = DB::table('products')
            ->select(
                'products.id as stok_id',
                'products.productName as nama',
                'products.productPrice as nominal',
                'products.productStock as sisa',
            );

        $stokData = $stokDataTemp->where('userID', '=', $userid)->get();

        return view('stok', [
            'stokData' => $stokData,
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
        $userid = Auth::check() ? Auth::id() : null;

        $validator = \Validator::make($request->all(), [
            'namaBarangOnboarding' => 'required|array',
            'namaBarangOnboarding.*' => 'required|string|max:255',
            'jumlahBarangOnboarding' => 'required|array',
            'jumlahBarangOnboarding.*' => 'required|integer|min:1',
            'nominalHargaBarangOnboarding' => 'required|array',
            'nominalHargaBarangOnboarding.*' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'error' => 'Input tidak valid! Harap periksa kembali.',
                'errorDataInput' => $request->all()
            ]);
        }

        foreach ($request['namaBarangOnboarding'] as $index => $productName) {
            $productStock = $request['jumlahBarangOnboarding'][$index];
            $productPrice = $request['nominalHargaBarangOnboarding'][$index];

            Product::insert([
                'userID' => $userid,
                'productName' => $productName,
                'productStock' => $productStock,
                'productPrice' => $productPrice,
            ]);
        }

        User::where('id', $userid)->update(['isOnboarded' => 1]);

        return redirect()->back()->with('success', 'Stok barang berhasil ditambahkan!');
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
    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nominal' => 'required|numeric',
            'sisa' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'error' => 'Input tidak valid! Harap periksa kembali.',
                'errorDataUpdate' => array_merge($request->all(), ['id' => $id])
            ]);
        }

        $product = Product::find($id);
        $product->update([
            'productName' => $request->nama,
            'productPrice' => $request->nominal,
            'productStock' => $request->sisa
        ]);

        return redirect()->back()->with('success', 'Stok barang berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::find($id)->delete();

        return redirect()->back()->with('success', 'Stok barang berhasil di hapus!');
    }
}
