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
    public function index()
    {
        // $pendapatan_operasional = DB::table('transaksis')->select('transaksis.nominal')
        //                                                 ->where([
        //                                                     ['transaksis.category', '=', 'Operasional'], 
        //                                                     ['transaksis.type', '=', 'Pemasukan'], 
        //                                                     ['transaksis.method', '=', 'Tunai']])
        //                                                 ->sum('transaksis.nominal');
        // $formatted_pendapatan_operasional = Number::format($pendapatan_operasional);
        return view('aruskas');
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
