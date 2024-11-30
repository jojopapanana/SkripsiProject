<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transaksis')->insert([
            [
                'userID' => 1,
                'created_at' => Carbon::now(),
                'nominal' => NULL,
                'type' => 'Pemasukan',
                'category' => 'Operasional',
                'method' => 'Tunai',
                'description' => 'Hasil penjualan'
            ],
            [
                'userID' => 1,
                'created_at' => Carbon::now(),
                'nominal' => NULL,
                'type' => 'Pemasukan',
                'category' => 'Operasional',
                'method' => 'Tunai',
                'description' => 'Hasil penjualan'
            ],
            [
                'userID' => 1,
                'created_at' => Carbon::now(),
                'nominal' => 100000,
                'type' => 'Pengeluaran',
                'category' => 'Operasional',
                'method' => 'Tunai',
                'description' => 'Uang makan'
            ],
            [
                'userID' => 1,
                'created_at' => Carbon::now(),
                'nominal' => NULL,
                'type' => 'Pemasukan',
                'category' => 'Operasional',
                'method' => 'Non-Tunai',
                'description' => 'Hasil penjualan'
            ],
            [
                'userID' => 1,
                'created_at' => Carbon::now(),
                'nominal' => NULL,
                'type' => 'Pemasukan',
                'category' => 'Operasional',
                'method' => 'Non-Tunai',
                'description' => 'Hasil penjualan'
            ],
            [
                'userID' => 1,
                'created_at' => Carbon::now(),
                'nominal' => 200000,
                'type' => 'Pengeluaran',
                'category' => 'Investasi',
                'method' => 'Non-Tunai',
                'description' => 'Pembayaran'
            ],
            [
                'userID' => 1,
                'created_at' => Carbon::now(),
                'nominal' => 150000,
                'type' => 'Pengeluaran',
                'category' => 'Operasional',
                'method' => 'Non-Tunai',
                'description' => 'Pembayaran gaji karyawan'
            ],
            [
                'userID' => 1,
                'created_at' => Carbon::now(),
                'nominal' => NULL,
                'type' => 'Pemasukan',
                'category' => 'Operasional',
                'method' => 'Tunai',
                'description' => 'Hasil penjualan'
            ],
            [
                'userID' => 1,
                'created_at' => Carbon::now(),
                'nominal' => NULL,
                'type' => 'Pemasukan',
                'category' => 'Operasional',
                'method' => 'Non-Tunai',
                'description' => 'Hasil penjualan'
            ],
            [
                'userID' => 1,
                'created_at' => Carbon::now(),
                'nominal' => 300000,
                'type' => 'Pengeluaran',
                'category' => 'Investasi',
                'method' => 'Tunai',
                'description' => 'Pembayaran investasi'
            ]
        ]);
    }
}
