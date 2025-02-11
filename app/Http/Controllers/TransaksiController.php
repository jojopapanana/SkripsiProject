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
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{

    public function export_excel(Request $request){
        $month = $request->input('month');
        $year = $request->input('year');
        $userid = Auth::check() ? Auth::id() : null;
        return Excel::download(new TransaksiExport($month, $year, $userid), 'transaksi.xlsx');
    }

    public function export_csv(Request $request){
        $month = $request->input('month');
        $year = $request->input('year');
        $userid = Auth::check() ? Auth::id() : null;
        return Excel::download(new TransaksiExport($month, $year, $userid), 'transaksi.csv');
    }

    public function export_pdf(Request $request){
        $month = $request->input('month');
        $year = $request->input('year');
        $userid = Auth::check() ? Auth::id() : null;
        return Excel::download(new TransaksiExport($month, $year, $userid), 'transaksi.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
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

        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'jenisTransaksi' => 'required|string',
            'nominal' => 'required|numeric',
            'metode' => 'required|exists:payment_methods,name',
            'jenisBarang' => 'required|array',
            'jenisBarang.*' => 'required|integer|exists:products,id',
            'jumlahBarang' => 'required|array',
            'jumlahBarang.*' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'error' => 'Input tidak valid! Harap periksa kembali.',
                'errorDataPemasukan' => $request->all()
            ]);
        }

        $transactionID = DB::table('transaksis')->insertGetId([
            'created_at' => $request->tanggal,
            'userID' => $userid,
            'type' => $request->jenisTransaksi,
            'category' => 'Operasional',
            'methodID' => $this->getMethodIdByName($request->metode),
            'description' => 'Hasil penjualan'
        ]);

        foreach ($request['jenisBarang'] as $index => $productID) {
            DB::table('products')
                ->where('id', $productID)
                ->decrement('productStock', $request['jumlahBarang'][$index]);

            TransactionDetail::create([
                'transactionID' => $transactionID,
                'productID' => $productID,
                'productQuantity' => $request['jumlahBarang'][$index]
            ]);
        }
    }

    private function tambahStokPengeluaran(Request $request) {
        $userid = Auth::check() ? Auth::id() : null;

        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'jenisTransaksi' => 'required|string',
            'deskripsi' => 'required|string',
            'jenisBarangPengeluaran' => 'required|string',
            'metode' => 'required|exists:payment_methods,name',
            'jumlahBarangPengeluaran' => 'required|integer',
            'nominalPengeluaran' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'error' => 'Input tidak valid! Harap periksa kembali.',
                'errorDataTambahStok' => $request->all()
            ]);
        }

        DB::table('products')
            ->where('id', $request->jenisBarangPengeluaran)
            ->increment('productStock', $request->jumlahBarangPengeluaran);

        Transaksi::create([
            [
                'created_at' => $request->tanggal,
                'userID' => $userid,
                'nominal' => $request->nominalPengeluaran,
                'type' => $request->jenisTransaksi,
                'category' => 'Operasional',
                'methodID' => $this->getMethodIdByName($request->metode),
                'description' => $request->deskripsi
            ]
        ]);
    }

    private function tambahLainnyaPengeluaran(Request $request) {
        $userid = Auth::check() ? Auth::id() : null;

        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'jenisTransaksi' => 'required|string',
            'deskripsiTransaksi' => 'required|string|max:255',
            'metode' => 'required|exists:payment_methods,name',
            'kategori' => 'required|string',
            'nominalPengeluaran' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'error' => 'Input tidak valid! Harap periksa kembali.',
                'errorDataTambahLainnya' => $request->all()
            ]);
        }

        Transaksi::create([
            [
                'created_at' => $request->tanggal,
                'userID' => $userid,
                'nominal' => $request->nominalPengeluaran,
                'type' => $request->jenisTransaksi,
                'category' => $request->kategori,
                'methodID' => $this->getMethodIdByName($request->metode),
                'description' => $request->deskripsiTransaksi
            ]
        ]);
    }

    private function tambahStokBaruPengeluaran(Request $request) {
        $userid = Auth::check() ? Auth::id() : null;

        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'jenisTransaksi' => 'required|string',
            'deskripsi' => 'required|string',
            'stokBaru' => 'required|string|max:255',
            'metode' => 'required|exists:payment_methods,name',
            'hargaJualSatuan' => 'required|numeric',
            'jumlahBarangPengeluaran' => 'required|integer',
            'nominalPengeluaran' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'error' => 'Input tidak valid! Harap periksa kembali.',
                'errorDataTambahStokBaru' => $request->all()
            ]);
        }

        Product::create([
            'userID' => $userid,
            'productName' => $request->stokBaru,
            'productStock' => $request->jumlahBarangPengeluaran,
            'productPrice' => $request->hargaJualSatuan
        ]);

        Transaksi::create([
            'created_at' => $request->tanggal,
            'userID' => $userid,
            'nominal' => $request->nominalPengeluaran,
            'type' => $request->jenisTransaksi,
            'category' => 'Operasional',
            'methodID' => $this->getMethodIdByName($request->metode),
            'description' => $request->deskripsi
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->input('modalType') === 'pemasukan') {
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
        $validator = Validator::make($request->all(), [
            'nominalTransaksi' => 'required|numeric',
            'kategoriTransaksi' => 'required|string|max:255',
            'metodeTransaksi' => 'required|string|exists:payment_methods,name',
            'deskripsiTransaksi' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'error' => 'Input tidak valid! Harap periksa kembali.',
                'errorDataUpdate' => array_merge($request->all(), ['id' => $id])
            ]);
        }

        $transaksi = Transaksi::find($id);
        $transaksi->update([
            'nominal' => $request->nominalTransaksi,
            'category' => $request->kategoriTransaksi,
            'methodID' => $this->getMethodIdByName($request->metodeTransaksi),
            'description' => $request->deskripsiTransaksi
        ]);

        return redirect()->route('transaksi')->with('success', 'Detail transaksi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id, Request $request)
    {
        Transaksi::find($id)->delete();

        return redirect()->route('transaksi')->with('success', 'Transaksi berhasil di hapus!');
    }
}