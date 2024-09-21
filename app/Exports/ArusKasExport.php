<?php
namespace App\Exports;

use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ArusKasExport implements WithHeadings, FromCollection
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
        $query_data = DB::table('transaksis')->select('id', 'created_at as Tanggal Transaksi', 'nominal', 'type', 'category', 'method', 'description')->get();
        return $query_data;
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