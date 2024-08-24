<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\LabaRugiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index']);

Route::get('transaksi', [TransaksiController::class, 'index'])->name('transaksi');

Route::get('stok', [StokController::class, 'index'])->name('stok');

Route::get('labarugi', [LabaRugiController::class, 'index'])->name('labarugi');