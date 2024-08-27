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
                'nominal' => '1000000',
                'type' => 'Pemasukan',
                'category' => 'Operasional',
                'method' => 'Tunai',
                'description' => 'Hasil penjualan'
            ],
            [
                'nominal' => '55000',
                'type' => 'Pemasukan',
                'category' => 'Operasional',
                'method' => 'Tunai',
                'description' => 'Hasil penjualan'
            ],
            [
                'nominal' => '200000',
                'type' => 'Pengeluaran',
                'category' => 'Operasional',
                'method' => 'Tunai',
                'description' => 'Uang makan'
            ],
            [
                'nominal' => '30000',
                'type' => 'Pemasukan',
                'category' => 'Operasional',
                'method' => 'Non-Tunai',
                'description' => 'Hasil penjualan'
            ],
            [
                'nominal' => '27500',
                'type' => 'Pemasukan',
                'category' => 'Operasional',
                'method' => 'Non-Tunai',
                'description' => 'Hasil penjualan'
            ],
            [
                'nominal' => '350000',
                'type' => 'Pengeluaran',
                'category' => 'Finansial',
                'method' => 'Non-Tunai',
                'description' => 'Pembayaran'
            ],
            [
                'nominal' => '200000',
                'type' => 'Pengeluaran',
                'category' => 'Operasional',
                'method' => 'Non-Tunai',
                'description' => 'Pembayaran gaji karyawan'
            ],
            [
                'nominal' => '35000',
                'type' => 'Pemasukan',
                'category' => 'Operasional',
                'method' => 'Tunai',
                'description' => 'Hasil penjualan'
            ],
            [
                'nominal' => '200000',
                'type' => 'Pemasukan',
                'category' => 'Operasional',
                'method' => 'Non-Tunai',
                'description' => 'Hasil penjualan'
            ],
            [
                'nominal' => '155000',
                'type' => 'Pengeluaran',
                'category' => 'Finansial',
                'method' => 'Tunai',
                'description' => 'Pembayaran investasi'
            ]
        ]);
    }
}
