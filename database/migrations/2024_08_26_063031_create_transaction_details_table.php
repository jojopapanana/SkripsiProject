<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('transactionID');
            $table->foreign('transactionID')->references('id')->on('transaksis')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('productID');
            $table->foreign('productID')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('productQuantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};
