<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\UtangPiutang;
use Carbon\Carbon;

class UtangPiutangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('utang_piutangs')->insert([
            [
                'deskripsi' => 'Piutang PT. makmur jaya',
                'batasWaktu' => Carbon::now()->format('Y-m-d'),
                'nominal' => 20000,
                'jenis' => 'Piutang'
            ],
            [
                'deskripsi' => 'Utang terhadap PT. Timah Sukabumi',
                'batasWaktu' => Carbon::now()->format('Y-m-d'),
                'nominal' => 20000,
                'jenis' => 'Utang'
            ],
        ]);
    }
}
