<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LabaRugiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function export(Request $request){
        $month = $request->input('month');
        $year = $request->input('year');
        $userid = Auth::check() ? Auth::id() : null;

        $labaTemp = DB::table('transaksis')->join('transaction_details', 'transaksis.id', '=', 'transaction_details.transactionID')
                                                ->join('products', 'transaction_details.productID', '=', 'products.id')
                                                ->select('transaksis.id as id', DB::raw('SUM(transaction_details.productQuantity * products.productPrice) as totalNominal'), 'transaksis.description')
                                                ->whereNull('transaksis.nominal')
                                                ->where('transaksis.userID', '=', $userid)
                                                ->groupBy('transaksis.id', 'transaksis.description');
        
        $rugiTemp = DB::table('transaksis')
            ->select('description', 'nominal')
            ->where([['type', 'Pengeluaran'], ['userID', '=', $userid]])
            ->whereNotNull('nominal');

        if ($month) {
            $labaTemp
                    ->whereMonth('transaksis.created_at', $month)
                    ->whereYear('transaksis.created_at', $year);

            $rugiTemp
                    ->whereMonth('transaksis.created_at', $month)
                    ->whereYear('transaksis.created_at', $year);;
        }

        $laba = $labaTemp->get();
        $total_laba = $laba->sum('totalNominal');

        $rugi = $rugiTemp->get();
        $total_rugi = $rugiTemp->sum('nominal');

        $balance = $total_laba - $total_rugi;
        $status = $balance > 0 ? 'Untung' : ($balance < 0 ? 'Rugi' : 'Seimbang');

        $data = [
            'laba' => $laba,
            'total_laba' => $total_laba,
            'rugi' => $rugi,
            'total_rugi' => $total_rugi,
            'balance' => $balance,
            'status' => $status
        ];

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('labarugi', $data);

        return $pdf->download('labarugi.pdf');
    }

    public function index(Request $request)
    {
        $userid = Auth::check() ? Auth::id() : null;
        $month = $request->get('month', date('n'));
        $year = $request->get('year', date('Y'));

        $labaTemp = DB::table('transaksis')->join('transaction_details', 'transaksis.id', '=', 'transaction_details.transactionID')
                                                ->join('products', 'transaction_details.productID', '=', 'products.id')
                                                ->select('transaksis.id as id', DB::raw('SUM(transaction_details.productQuantity * products.productPrice) as totalNominal'), 'transaksis.description')
                                                ->whereNull('transaksis.nominal')
                                                ->where('transaksis.userID', '=', $userid)
                                                ->groupBy('transaksis.id', 'transaksis.description');
        
        $rugiTemp = DB::table('transaksis')
            ->select('description', 'nominal')
            ->where([['type', 'Pengeluaran'], ['userID', '=', $userid]])
            ->whereNotNull('nominal');

        if ($month) {
            $labaTemp
                    ->whereMonth('transaksis.created_at', $month)
                    ->whereYear('transaksis.created_at', $year);

            $rugiTemp
                    ->whereMonth('transaksis.created_at', $month)
                    ->whereYear('transaksis.created_at', $year);;
        }

        $laba = $labaTemp->get();
        $total_laba = $laba->sum('totalNominal');

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