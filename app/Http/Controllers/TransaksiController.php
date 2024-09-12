<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\TransactionDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaksi::all();
        $income_totals = DB::table('transaksis')->join('transaction_details', 'transaksis.id', '=', 'transaction_details.transactionID')
                                        ->join('products', 'transaction_details.productID', '=', 'products.id')
                                        ->select('transaksis.id as id', DB::raw('SUM(transaction_details.productQuantity * products.productPrice) as totalNominal'))
                                        ->whereNull('transaksis.nominal')
                                        ->groupBy('transaksis.id');

        $expense_total = DB::table('transaksis')->select('transaksis.id as id', 'transaksis.nominal as totalNominal')
                                                ->whereNotNull('transaksis.nominal')
                                                ->union($income_totals)
                                                ->orderBy('id')
                                                ->get();

        $totals = $expense_total;
        return view('transaksi', ['transactions' => $transactions], ['totals' => $totals]);
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
        // Handle Pemasukan
        if ($request->input('modalType') === 'pemasukan') {
            $validatedData = $request->validate([ //ini buat nanti
                'tanggal' => 'required|date',
                'jenisTransaksi' => 'required|string',
                'nominal' => 'required|numeric',
                'metode' => 'required|string',
                'jenisBarang' => 'required|string',
                'jumlahBarang' => 'required|integer',
            ]);

            // Update product stock
            DB::table('products')
                ->where('id', $validatedData['jenisBarang'])
                ->decrement('productStock', $validatedData['jumlahBarang']);

            // Insert into 'transaksis' and get the transaction ID
            $transactionID = DB::table('transaksis')->insertGetId([
                'created_at' => $validatedData['tanggal'],
                'type' => $validatedData['jenisTransaksi'],
                'category' => 'Operasional',
                'method' => $validatedData['metode'],
                'description' => 'Hasil penjualan'
            ]);

            // Insert into 'transaction_details' using the retrieved transaction ID
            DB::table('transaction_details')->insert([
                [
                    'transactionID' => $transactionID,
                    'productID' => $validatedData['jenisBarang'],
                    'productQuantity' => $validatedData['jumlahBarang']
                ]
            ]);

        // Handle Pengeluaran
        } elseif ($request->input('modalType') === 'pengeluaran') {
            if ($request->input('modalType1') === 'tambahStok') {
                // dd('Just printing something');
                $validatedData = $request->validate([
                    'tanggal' => 'required|date',
                    'jenisTransaksi' => 'required|string',
                    'deskripsi' => 'required|string',
                    'jenisBarang' => 'required|string',
                    'metode' => 'required|string',
                    'jumlahBarangPengeluaran' => 'required|integer',
                    'nominalPengeluaran' => 'required|numeric'
                ]);

                // Update product stock
                DB::table('products')
                    ->where('id', $validatedData['jenisBarang'])
                    ->increment('productStock', $validatedData['jumlahBarangPengeluaran']);

                DB::table('transaksis')->insert([
                    [
                        'created_at' => $validatedData['tanggal'],
                        'nominal' => $validatedData['nominalPengeluaran'],
                        'type' => $validatedData['jenisTransaksi'],
                        'category' => 'Operasional',
                        'method' => $validatedData['metode'],
                        'description' => $validatedData['deskripsi']
                    ]
                ]);
            } else {
                $validatedData = $request->validate([
                    'tanggal' => 'required|date',
                    'jenisTransaksi' => 'required|string',
                    'deskripsiTransaksi' => 'required|string',
                    'metode' => 'required|string',
                    'kategori' => 'required|string',
                    'nominalPengeluaran' => 'required|numeric'
                ]);

                DB::table('transaksis')->insert([
                    [
                        'created_at' => $validatedData['tanggal'],
                        'nominal' => $validatedData['nominalPengeluaran'],
                        'type' => $validatedData['jenisTransaksi'],
                        'category' => $validatedData['kategori'],
                        'method' => $validatedData['metode'],
                        'description' => $validatedData['deskripsiTransaksi']
                    ]
                ]);
            }
        }

        // Redirect or return response
        return redirect()->back()->with('success', 'Transaksi berhasil ditambahkan!');
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
