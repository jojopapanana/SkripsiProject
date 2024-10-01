<?php
namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class StokExport implements WithHeadings, FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function collection()
    {
        return DB::table('products')
            ->select(
                'products.id as stok_id',
                'products.productName as nama',
                'products.productPrice as nominal',
                'products.productStock as sisa',
                DB::raw("DATE_FORMAT(products.created_at, '%Y-%m') as created_month")
            )
            ->whereMonth('products.created_at', $this->month)
            ->whereYear('products.created_at', $this->year)
            ->get();
    }

    public function headings(): array
    {
        return [
            'Kode Stok',
            'Nama Produk',
            'Nominal',
            'Sisa Stok',
            'Bulan Dibuat',
        ];
    }
}