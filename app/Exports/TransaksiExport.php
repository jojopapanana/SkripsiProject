<?php
namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class TransaksiExport implements WithHeadings, FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Transaksi::all();
    }

    public function headings(): array
    {
        return[
            'id',
            'Tanggal',
            'Nominal',
            'Kategori',
            'Jenis',
            'Metode'
        ];
    }
}