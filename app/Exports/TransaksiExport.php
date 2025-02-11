<?php
namespace App\Exports;

use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class TransaksiExport implements WithHeadings, FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $month;
    protected $year;
    protected $userid;

    public function __construct($month, $year, $userid)
    {
        $this->month = $month;
        $this->year = $year;
        $this->userid = $userid;
    }

    public function collection()
    {
        $income_totals = DB::table('payment_methods')->join('transaksis', 'payment_methods.id', '=', 'transaksis.methodID')
                                        ->join('transaction_details', 'transaksis.id', '=', 'transaction_details.transactionID')
                                        ->join('products', 'transaction_details.productID', '=', 'products.id')
                                        ->select('transaksis.created_at', DB::raw('SUM(transaction_details.productQuantity * products.productPrice)'), 'type', 'category', 'payment_methods.name', 'description')
                                        ->where([[DB::raw('month(transaksis.created_at)'), '=', $this->month], [DB::raw('year(transaksis.created_at)'), '=', $this->year], ['transaksis.userID', '=', $this->userid]])
                                        ->whereNull('transaksis.nominal')
                                        ->groupBy('transaksis.id', 'transaksis.created_at', 'transaksis.type', 'transaksis.category', 'transaksis.description', 'payment_methods.name');

        $query_data = DB::table('transaksis')->join('payment_methods', 'transaksis.methodID', '=', 'payment_methods.id')
                                        ->select('transaksis.created_at as date', 'transaksis.nominal', 'type', 'category', 'payment_methods.name', 'description')
                                        ->where([[DB::raw('month(transaksis.created_at)'), '=', $this->month], [DB::raw('year(transaksis.created_at)'), '=', $this->year], ['transaksis.userID', '=', $this->userid]])
                                        ->whereNotNull('transaksis.nominal')
                                        ->union($income_totals)
                                        ->groupBy('transaksis.created_at', 'transaksis.id', 'transaksis.nominal', 'transaksis.type', 'transaksis.category', 'transaksis.description', 'payment_methods.name')
                                        ->orderBy('date')
                                        ->get();
                                        
        $query_data = $this->assignSequentialIds($query_data);
        
        return $query_data;
    }
    
    private function assignSequentialIds($query_data) {
        $row_number = 1;
        $modified_data = [];
    
        foreach ($query_data as $transaction) {
            $transaction->custom_id = $row_number;
            
            $modified_data[] = (object)[
                'custom_id' => $transaction->custom_id,
                'created_at' => $transaction->date,
                'nominal' => $transaction->nominal,
                'type' => $transaction->type,
                'category' => $transaction->category,
                'name' => $transaction->name,
                'description' => $transaction->description,
            ];

            $row_number++;
        }
    
        return collect($modified_data);
    }

    public function headings(): array
    {
        return[
            'id',
            'Tanggal',
            'Nominal',
            'Kategori',
            'Jenis',
            'Metode',
            'Deskripsi'
        ];
    }
}