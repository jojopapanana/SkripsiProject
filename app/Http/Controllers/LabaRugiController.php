<?php

namespace App\Http\Controllers;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LabaRugiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $laba = DB::table('transaksis')
            ->select('description', 'nominal')
            ->where('type', 'pemasukan')
            ->whereNotNull('nominal')
            ->get();

            $total_laba = DB::table('transaksis')
                ->where('type', 'pemasukan')
                ->whereNotNull('nominal')
                ->sum('nominal');

            $rugi = DB::table('transaksis')
                ->select('description', 'nominal')
                ->where('type', 'pengeluaran')
                ->whereNotNull('nominal')
                ->get();

            $total_rugi = DB::table('transaksis')
                ->where('type', 'pengeluaran')
                ->whereNotNull('nominal')
                ->sum('nominal');

            $balance = $total_laba - $total_rugi;
            $status = $balance > 0 ? 'Untung' : ($balance < 0 ? 'Rugi' : 'Seimbang');

            return view('labarugi', [
                'laba' => $laba,
                'total_laba' => $total_laba,
                'rugi' => $rugi,
                'total_rugi' => $total_rugi,
                'balance' => $balance,
                'status' => $status
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