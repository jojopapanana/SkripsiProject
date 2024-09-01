<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'productName' => 'Cheesecake',
                'productStock' => 20,
                'productPrice' => 20000
            ],
            [
                'productName' => 'Cookies',
                'productStock' => 25,
                'productPrice' => 15000
            ],
            [
                'productName' => 'Shortcake',
                'productStock' => 30,
                'productPrice' => 25000
            ],
            [
                'productName' => 'Tiramisu',
                'productStock' => 10,
                'productPrice' => 35000
            ],
            [
                'productName' => 'Lava Cake',
                'productStock' => 20,
                'productPrice' => 20000
            ],
            [
                'productName' => 'Egg Tart',
                'productStock' => 40,
                'productPrice' => 10000
            ],
            [
                'productName' => 'Muffin',
                'productStock' => 25,
                'productPrice' => 10000
            ],
            [
                'productName' => 'Cupcake',
                'productStock' => 30,
                'productPrice' => 15000
            ],
            [
                'productName' => 'Ice Cream Cake',
                'productStock' => 30,
                'productPrice' => 30000
            ],
            [
                'productName' => 'Mug Cake',
                'productStock' => 40,
                'productPrice' => 10000
            ]
        ]);
    }
}
