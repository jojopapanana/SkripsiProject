<?php

namespace App\Http\Controllers;

use App\Exports\TransaksiExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{

    public function export_excel(Request $request){
        $month = $request->input('month');
        $year = $request->input('year');
        return Excel::download(new TransaksiExport($month, $year), 'transaksi.xlsx');
    }

    public function export_csv(Request $request){
        $month = $request->input('month');
        $year = $request->input('year');
        return Excel::download(new TransaksiExport($month, $year), 'transaksi.csv');
    }

    public function export_pdf(Request $request){
        $month = $request->input('month');
        $year = $request->input('year');
        return Excel::download(new TransaksiExport($month, $year), 'transaksi.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userid = Auth::check() ? Auth::id() : null;
        $selectedMonth = $request->get('month', date('n'));
        $selectedYear = $request->get('year', date('Y'));
        $transactions = DB::table('transaksis')->join('payment_methods', 'transaksis.methodID', '=', 'payment_methods.id')
                                                    ->select(
                                                        'transaksis.*',
                                                        'payment_methods.name as methodName'
                                                    )
                                                    ->where([[DB::raw('month(transaksis.created_at)'), '=', $selectedMonth], [DB::raw('year(transaksis.created_at)'), '=', $selectedYear], ['userID', '=', $userid]])
                                                    ->orderBy('id')
                                                    ->get();
        $income_totals = DB::table('transaksis')->join('transaction_details', 'transaksis.id', '=', 'transaction_details.transactionID')
                                        ->join('products', 'transaction_details.productID', '=', 'products.id')
                                        ->select('transaksis.id as id', DB::raw('SUM(transaction_details.productQuantity * products.productPrice) as totalNominal'))
                                        ->where([[DB::raw('month(transaksis.created_at)'), '=', $selectedMonth], [DB::raw('year(transaksis.created_at)'), '=', $selectedYear], ['transaksis.userID', '=', $userid]])
                                        ->whereNull('transaksis.nominal')
                                        ->groupBy('transaksis.id');

        $expense_total = DB::table('transaksis')->select('transaksis.id as id', 'transaksis.nominal as totalNominal')
                                                ->where([[DB::raw('month(transaksis.created_at)'), '=', $selectedMonth], [DB::raw('year(transaksis.created_at)'), '=', $selectedYear], ['transaksis.userID', '=', $userid]])
                                                ->whereNotNull('transaksis.nominal')
                                                ->union($income_totals)
                                                ->orderBy('id')
                                                ->get();
        $totals = $expense_total;

        $payment_methods = PaymentMethod::all();

        return view('transaksi', [
            'transactions' => $transactions,
            'totals' => $totals,
            'payment_methods' => $payment_methods
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    private function getMethodIdByName(string $methodName): int
    {
        return DB::table('payment_methods')
            ->where('name', $methodName)
            ->value('id');
    }    

    private function tambahPemasukan(Request $request) {
        $userid = Auth::check() ? Auth::id() : null;

        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'jenisTransaksi' => 'required|string',
            'nominal' => 'required|numeric',
            'metode' => 'required|exists:payment_methods,name',
            'jenisBarang' => 'required|array',
            'jenisBarang.*' => 'required|integer|exists:products,id',
            'jumlahBarang' => 'required|array',
            'jumlahBarang.*' => 'required|integer|min:1',
        ]);

        $transactionID = DB::table('transaksis')->insertGetId([
            'created_at' => $validatedData['tanggal'],
            'userID' => $userid,
            'type' => $validatedData['jenisTransaksi'],
            'category' => 'Operasional',
            'methodID' => $this->getMethodIdByName($validatedData['metode']),
            'description' => 'Hasil penjualan'
        ]);

        foreach ($validatedData['jenisBarang'] as $index => $productID) {
            DB::table('products')
                ->where('id', $productID)
                ->decrement('productStock', $validatedData['jumlahBarang'][$index]);

            TransactionDetail::insert([
                'transactionID' => $transactionID,
                'productID' => $productID,
                'productQuantity' => $validatedData['jumlahBarang'][$index]
            ]);
        }
    }

    private function tambahStokPengeluaran(Request $request) {
        $userid = Auth::check() ? Auth::id() : null;

        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'jenisTransaksi' => 'required|string',
            'deskripsi' => 'required|string',
            'jenisBarangPengeluaran' => 'required|string',
            'metode' => 'required|exists:payment_methods,name',
            'jumlahBarangPengeluaran' => 'required|integer',
            'nominalPengeluaran' => 'required|numeric'
        ]);

        DB::table('products')
            ->where('id', $validatedData['jenisBarangPengeluaran'])
            ->increment('productStock', $validatedData['jumlahBarangPengeluaran']);

        Transaksi::insert([
            [
                'created_at' => $validatedData['tanggal'],
                'userID' => $userid,
                'nominal' => $validatedData['nominalPengeluaran'],
                'type' => $validatedData['jenisTransaksi'],
                'category' => 'Operasional',
                'methodID' => $this->getMethodIdByName($validatedData['metode']),
                'description' => $validatedData['deskripsi']
            ]
        ]);
    }

    private function tambahLainnyaPengeluaran(Request $request) {
        $userid = Auth::check() ? Auth::id() : null;

        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'jenisTransaksi' => 'required|string',
            'deskripsiTransaksi' => 'required|string',
            'metode' => 'required|exists:payment_methods,name',
            'kategori' => 'required|string',
            'nominalPengeluaran' => 'required|numeric'
        ]);

        Transaksi::insert([
            [
                'created_at' => $validatedData['tanggal'],
                'userID' => $userid,
                'nominal' => $validatedData['nominalPengeluaran'],
                'type' => $validatedData['jenisTransaksi'],
                'category' => $validatedData['kategori'],
                'methodID' => $this->getMethodIdByName($validatedData['metode']),
                'description' => $validatedData['deskripsiTransaksi']
            ]
        ]);
    }

    private function tambahStokBaruPengeluaran(Request $request) {
        $userid = Auth::check() ? Auth::id() : null;

        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'jenisTransaksi' => 'required|string',
            'deskripsi' => 'required|string',
            'stokBaru' => 'required|string',
            'metode' => 'required|exists:payment_methods,name',
            'hargaJualSatuan' => 'required|numeric',
            'jumlahBarangPengeluaran' => 'required|integer',
            'nominalPengeluaran' => 'required|numeric'
        ]);

        Product::insert([
            'userID' => $userid,
            'productName' => $validatedData['stokBaru'],
            'productStock' => $validatedData['jumlahBarangPengeluaran'],
            'productPrice' => $validatedData['hargaJualSatuan']
        ]);

        Transaksi::insert([
            'created_at' => $validatedData['tanggal'],
            'userID' => $userid,
            'nominal' => $validatedData['nominalPengeluaran'],
            'type' => $validatedData['jenisTransaksi'],
            'category' => 'Operasional',
            'methodID' => $this->getMethodIdByName($validatedData['metode']),
            'description' => $validatedData['deskripsi']
        ]);
    }

    private function tambahStokBaruOnboarding(Request $request) {
        $userid = Auth::check() ? Auth::id() : null;

        $validatedData = $request->validate([
            'namaBarangOnboarding' => 'required|array',
            'namaBarangOnboarding.*' => 'required|string',
            'jumlahBarangOnboarding' => 'required|array',
            'jumlahBarangOnboarding.*' => 'required|integer|min:1',
            'nominalHargaBarangOnboarding' => 'required|array',
            'nominalHargaBarangOnboarding.*' => 'required|integer|min:1',
        ]);

        foreach ($validatedData['namaBarangOnboarding'] as $index => $productName) {
            $productStock = $validatedData['jumlahBarangOnboarding'][$index];
            $productPrice = $validatedData['nominalHargaBarangOnboarding'][$index];

            Product::insert([
                'userID' => $userid,
                'productName' => $productName,
                'productStock' => $productStock,
                'productPrice' => $productPrice,
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userid = Auth::check() ? Auth::id() : null;
        if ($request->input('modalType') === 'onboarding') {
            $this->tambahStokBaruOnboarding($request);
            DB::table('users')
            ->where('id', '=', $userid)
            ->update(['isOnboarded' => 1]);
        } else if ($request->input('modalType') === 'pemasukan') {
            $this->tambahPemasukan($request);
        } else if ($request->input('modalType') === 'pengeluaran') {
            if ($request->input('modalType1') === 'tambahStok') {
                $this->tambahStokPengeluaran($request);
            } else if ($request->input('modalType1') === 'tambahLainnya') {
                $this->tambahLainnyaPengeluaran($request);
            } else if ($request->input('modalType1') === 'tambahStokBaru') {
                $this->tambahStokBaruPengeluaran($request);
            }
        }

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
        $transaction = Transaksi::find($id);

        $transaction->update([
            'nominal' => $request->nominalTransaksi,
            'type' => $request->jenisTransaksi,
            'category' => $request->kategoriTransaksi,
            'methodID' => $this->getMethodIdByName($request->metodeTransaksi),
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

        return redirect()->route('transaksi')->with([
            'transactions' => $transactions,
            'totals' => $totals,
            'success' => 'Detail transaksi berhasil diperbarui!'
        ]);
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

        return redirect()->route('transaksi')->with([
            'transactions' => $transactions,
            'totals' => $totals,
            'success' => 'Transaksi berhasil di hapus!'
        ]);
    }
}
