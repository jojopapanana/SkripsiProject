<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transaksis')->insert([
            [
                'type' => 'Pemasukan',
                'category' => 'Operasional',
                'method' => 'Tunai',
                'description' => 'Hasil penjualan'
            ],
            [
                'type' => 'Pemasukan',
                'category' => 'Operasional',
                'method' => 'Tunai',
                'description' => 'Hasil penjualan'
            ],
            [
                'type' => 'Pengeluaran',
                'category' => 'Operasional',
                'method' => 'Tunai',
                'description' => 'Uang makan'
            ],
            [
                'type' => 'Pemasukan',
                'category' => 'Operasional',
                'method' => 'Non-Tunai',
                'description' => 'Hasil penjualan'
            ],
            [
                'type' => 'Pemasukan',
                'category' => 'Operasional',
                'method' => 'Non-Tunai',
                'description' => 'Hasil penjualan'
            ],
            [
                'type' => 'Pengeluaran',
                'category' => 'Finansial',
                'method' => 'Non-Tunai',
                'description' => 'Pembayaran'
            ],
            [
                'type' => 'Pengeluaran',
                'category' => 'Operasional',
                'method' => 'Non-Tunai',
                'description' => 'Pembayaran gaji karyawan'
            ],
            [
                'type' => 'Pemasukan',
                'category' => 'Operasional',
                'method' => 'Tunai',
                'description' => 'Hasil penjualan'
            ],
            [
                'type' => 'Pemasukan',
                'category' => 'Operasional',
                'method' => 'Non-Tunai',
                'description' => 'Hasil penjualan'
            ],
            [
                'type' => 'Pengeluaran',
                'category' => 'Finansial',
                'method' => 'Tunai',
                'description' => 'Pembayaran investasi'
            ]
        ]);
    }
}
