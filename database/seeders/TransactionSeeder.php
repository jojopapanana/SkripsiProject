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
                'methodID' => 1,
                'description' => 'Hasil penjualan'
            ],
            [
                'userID' => 1,
                'created_at' => Carbon::now(),
                'nominal' => NULL,
                'type' => 'Pemasukan',
                'category' => 'Operasional',
                'methodID' => 2,
                'description' => 'Hasil penjualan'
            ],
            [
                'userID' => 1,
                'created_at' => Carbon::now(),
                'nominal' => 100000,
                'type' => 'Pengeluaran',
                'category' => 'Operasional',
                'methodID' => 2,
                'description' => 'Uang makan'
            ],
            [
                'userID' => 1,
                'created_at' => Carbon::now(),
                'nominal' => NULL,
                'type' => 'Pemasukan',
                'category' => 'Operasional',
                'methodID' => 2,
                'description' => 'Hasil penjualan'
            ],
            [
                'userID' => 1,
                'created_at' => Carbon::now(),
                'nominal' => NULL,
                'type' => 'Pemasukan',
                'category' => 'Operasional',
                'methodID' => 1,
                'description' => 'Hasil penjualan'
            ],
            [
                'userID' => 1,
                'created_at' => Carbon::now(),
                'nominal' => 200000,
                'type' => 'Pengeluaran',
                'category' => 'Investasi',
                'methodID' => 2,
                'description' => 'Pembayaran'
            ],
            [
                'userID' => 1,
                'created_at' => Carbon::now(),
                'nominal' => 150000,
                'type' => 'Pengeluaran',
                'category' => 'Operasional',
                'methodID' => 2,
                'description' => 'Pembayaran gaji karyawan'
            ],
            [
                'userID' => 1,
                'created_at' => Carbon::now(),
                'nominal' => NULL,
                'type' => 'Pemasukan',
                'category' => 'Operasional',
                'methodID' => 3,
                'description' => 'Hasil penjualan'
            ],
            [
                'userID' => 1,
                'created_at' => Carbon::now(),
                'nominal' => NULL,
                'type' => 'Pemasukan',
                'category' => 'Operasional',
                'methodID' => 1,
                'description' => 'Hasil penjualan'
            ],
            [
                'userID' => 1,
                'created_at' => Carbon::now(),
                'nominal' => 300000,
                'type' => 'Pengeluaran',
                'category' => 'Investasi',
                'methodID' => 1,
                'description' => 'Pembayaran investasi'
            ]
        ]);
    }
}
