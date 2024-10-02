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
    public function index(Request $request)
    {
        // $month = $request->input('month');
        // $year = $request->input('year');
        $month = $request->get('month', date('n'));
        // $year = $request->get('year', date('n'));

        $labaTemp = DB::table('transaksis')
            ->select('description', 'nominal')
            ->where('type', 'Pemasukan')
            ->whereNotNull('nominal');
        
        $rugiTemp = DB::table('transaksis')
            ->select('description', 'nominal')
            ->where('type', 'Pengeluaran')
            ->whereNotNull('nominal');

        if ($month) {
            $labaTemp
                    ->whereMonth('transaksis.created_at', $month);

            $rugiTemp
                    ->whereMonth('transaksis.created_at', $month);
        }

        $laba = $labaTemp->get();
        $total_laba = $labaTemp->sum('nominal');

        $rugi = $rugiTemp->get();
        $total_rugi = $rugiTemp->sum('nominal');

        $balance = $total_laba - $total_rugi;
        $status = $balance > 0 ? 'Untung' : ($balance < 0 ? 'Rugi' : 'Seimbang');

        return view('labarugi', [
            'laba' => $laba,
            'total_laba' => $total_laba,
            'rugi' => $rugi,
            'total_rugi' => $total_rugi,
            'balance' => $balance,
            'status' => $status,
            'month' => $month,
            // 'year' => $year,
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