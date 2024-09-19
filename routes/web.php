<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\LabaRugiController;
use App\Http\Controllers\ArusKasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SignUpController;


// Route to show the registration form
Route::get('/register', [SignUpController::class, 'showRegistrationForm'])->name('register');
Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');

// Route to handle the registration form submission
// Route::post('/register', [SignUpController::class, 'register']);
Route::get('/', [DashboardController::class, 'index'])->name('Dashboard');
Route::get('transaksi', [TransaksiController::class, 'index'])->name('transaksi');
Route::get('/transaksi/export/excel/{month}/{year}', [TransaksiController::class, 'export_excel'])->name('transaksi_export_excel');
Route::get('/transaksi_export_csv', [TransaksiController::class, 'export_csv'])->name('transaksi_export_csv');
Route::get('/transaksi_export_pdf', [TransaksiController::class, 'export_pdf'])->name('transaksi_export_pdf');
Route::get('stok', [StokController::class, 'index'])->name('stok');
Route::get('labarugi', [LabaRugiController::class, 'index'])->name('labarugi');
Route::get('aruskas', [ArusKasController::class, 'index'])->name('aruskas');

