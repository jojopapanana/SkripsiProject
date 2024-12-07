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
        Schema::create('utang_piutangs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('deskripsi');
            $table->date('batasWaktu');
            $table->integer('nominal');
            $table->string('jenis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utang_piutangs');
    }
};
