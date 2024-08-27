<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionDetail;

class TransactionDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transaction_details')->insert([
            [
                'transactionID' => 3,
                'productID' => 5,
                'productQuantity' => 7
            ],
            [
                'transactionID' => 1,
                'productID' => 2,
                'productQuantity' => 10
            ],
            [
                'transactionID' => 7,
                'productID' => 3,
                'productQuantity' => 6
            ],
            [
                'transactionID' => 5,
                'productID' => 8,
                'productQuantity' => 2
            ],
            [
                'transactionID' => 9,
                'productID' => 4,
                'productQuantity' => 4
            ],
            [
                'transactionID' => 2,
                'productID' => 7,
                'productQuantity' => 8
            ],
            [
                'transactionID' => 8,
                'productID' => 1,
                'productQuantity' => 9
            ],
            [
                'transactionID' => 6,
                'productID' => 9,
                'productQuantity' => 1
            ],
            [
                'transactionID' => 4,
                'productID' => 10,
                'productQuantity' => 3
            ],
            [
                'transactionID' => 10,
                'productID' => 6,
                'productQuantity' => 5
            ],
            [
                'transactionID' => 4,
                'productID' => 2,
                'productQuantity' => 7
            ],
            [
                'transactionID' => 9,
                'productID' => 5,
                'productQuantity' => 3
            ],
            [
                'transactionID' => 1,
                'productID' => 7,
                'productQuantity' => 9
            ],
            [
                'transactionID' => 6,
                'productID' => 4,
                'productQuantity' => 8
            ],
            [
                'transactionID' => 3,
                'productID' => 10,
                'productQuantity' => 2
            ]
        ]);
    }
}
