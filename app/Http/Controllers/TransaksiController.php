<?php

namespace App\Http\Controllers;

use App\Exports\TransaksiExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\TransactionDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;
use Maatwebsite\Excel\Facades\Excel;

class TransaksiController extends Controller
{

    public function export_excel($month, $year){
        return Excel::download(new TransaksiExport($month, $year), 'transaksi.xlsx');
    }

    public function export_csv($month, $year){
        return Excel::download(new TransaksiExport($month, $year), 'transaksi.csv');
    }

    public function export_pdf($month, $year){
        return Excel::download(new TransaksiExport($month, $year), 'transaksi.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $selectedMonth = $request->get('month', date('n'));
        $selectedYear = $request->get('year', date('Y'));
        $transactions = DB::table('transaksis')->select('*')
                                                    ->where([[DB::raw('month(transaksis.created_at)'), '=', $selectedMonth], [DB::raw('year(transaksis.created_at)'), '=', $selectedYear]])
                                                    ->orderBy('id')
                                                    ->get();
        $income_totals = DB::table('transaksis')->join('transaction_details', 'transaksis.id', '=', 'transaction_details.transactionID')
                                        ->join('products', 'transaction_details.productID', '=', 'products.id')
                                        ->select('transaksis.id as id', DB::raw('SUM(transaction_details.productQuantity * products.productPrice) as totalNominal'))
                                        ->where([[DB::raw('month(transaksis.created_at)'), '=', $selectedMonth], [DB::raw('year(transaksis.created_at)'), '=', $selectedYear]])
                                        ->whereNull('transaksis.nominal')
                                        ->groupBy('transaksis.id');

        $expense_total = DB::table('transaksis')->select('transaksis.id as id', 'transaksis.nominal as totalNominal')
                                                ->where([[DB::raw('month(transaksis.created_at)'), '=', $selectedMonth], [DB::raw('year(transaksis.created_at)'), '=', $selectedYear]])
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

    private function tambahPemasukan(Request $request) {
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'jenisTransaksi' => 'required|string',
            'nominal' => 'required|numeric',
            'metode' => 'required|string',
            'jenisBarang' => 'required|array',
            'jenisBarang.*' => 'required|integer|exists:products,id',
            'jumlahBarang' => 'required|array',
            'jumlahBarang.*' => 'required|integer|min:1',
        ]);

        // Insert into 'transaksis' and get the transaction ID
        $transactionID = DB::table('transaksis')->insertGetId([
            'created_at' => $validatedData['tanggal'],
            'type' => $validatedData['jenisTransaksi'],
            'category' => 'Operasional',
            'method' => $validatedData['metode'],
            'description' => 'Hasil penjualan'
        ]);

        // Loop over each product and update stock and transaction details
        foreach ($validatedData['jenisBarang'] as $index => $productID) {
            // Update product stock
            DB::table('products')
                ->where('id', $productID)
                ->decrement('productStock', $validatedData['jumlahBarang'][$index]);

            // Insert into 'transaction_details'
            DB::table('transaction_details')->insert([
                'transactionID' => $transactionID,
                'productID' => $productID,
                'productQuantity' => $validatedData['jumlahBarang'][$index]
            ]);
        }
    }

    private function tambahStokPengeluaran(Request $request) {
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'jenisTransaksi' => 'required|string',
            'deskripsi' => 'required|string',
            'jenisBarangPengeluaran' => 'required|string',
            'metode' => 'required|string',
            'jumlahBarangPengeluaran' => 'required|integer',
            'nominalPengeluaran' => 'required|numeric'
        ]);

        DB::table('products')
            ->where('id', $validatedData['jenisBarangPengeluaran'])
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
    }

    private function tambahLainnyaPengeluaran(Request $request) {
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

    private function tambahStokBaruPengeluaran(Request $request) {
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'jenisTransaksi' => 'required|string',
            'deskripsi' => 'required|string',
            'stokBaru' => 'required|string',
            'metode' => 'required|string',
            'hargaJualSatuan' => 'required|numeric',
            'jumlahBarangPengeluaran' => 'required|integer',
            'nominalPengeluaran' => 'required|numeric'
        ]);

        DB::table('products')->insert([
            'productName' => $validatedData['stokBaru'],
            'productStock' => $validatedData['jumlahBarangPengeluaran'],
            'productPrice' => $validatedData['hargaJualSatuan']
        ]);

        DB::table('transaksis')->insert([
            'created_at' => $validatedData['tanggal'],
            'nominal' => $validatedData['nominalPengeluaran'],
            'type' => $validatedData['jenisTransaksi'],
            'category' => 'Operasional',
            'method' => $validatedData['metode'],
            'description' => $validatedData['deskripsi']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Handle Pemasukan
        if ($request->input('modalType') === 'pemasukan') {
            $this->tambahPemasukan($request);

        // Handle Pengeluaran
        } else if ($request->input('modalType') === 'pengeluaran') {
            if ($request->input('modalType1') === 'tambahStok') {
                $this->tambahStokPengeluaran($request);
            } else if ($request->input('modalType1') === 'tambahLainnya') {
                $this->tambahLainnyaPengeluaran($request);
            } else if ($request->input('modalType1') === 'tambahStokBaru') {
                $this->tambahStokBaruPengeluaran($request);
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
    public function update(Request $request, int $id)
    {
        // dd($request->nominalTransaksi);

        // $request->validate([
        //     'nominalTransaksi' => 'nullable|integer',
        //     'jenisTransaksi' => 'required|string',
        //     'kategoriTransaksi' => 'required|string',
        //     'metodeTransaksi' => 'required|string',
        //     'deskripsiTransaksi' => 'required|string'
        // ]);

        // dd($id);

        $transaction = Transaksi::find($id);



        $transaction->update([
            'nominal' => $request->nominalTransaksi,
            'type' => $request->jenisTransaksi,
            'category' => $request->kategoriTransaksi,
            'method' => $request->metodeTransaksi,
            'description' => $request->deskripsiTransaksi
        ]);

        $selectedMonth = $request->get('month', date('n'));
        $transactions = DB::table('transaksis')->select('*')
                                                    ->where(DB::raw('month(transaksis.created_at)'), '=', $selectedMonth)
                                                    ->orderBy('id')
                                                    ->get();
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
        return redirect()->route('transaksi', ['transactions' => $transactions, 'totals' => $totals]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id, Request $request)
    {
        $transaksi = Transaksi::find(id: $id);
        $transaksi->delete();

        $selectedMonth = $request->get('month', date('n'));
        $transactions = DB::table('transaksis')->select('*')
                                                    ->where(DB::raw('month(transaksis.created_at)'), '=', $selectedMonth)
                                                    ->orderBy('id')
                                                    ->get();
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
        return redirect()->route('transaksi', ['transactions' => $transactions, 'totals' => $totals]);
    }
}
