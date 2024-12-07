<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\LabaRugiController;
use App\Http\Controllers\ArusKasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\AnalisisTrendController;
use App\Http\Controllers\UtangPiutangController;


// Route to show the registration form
Route::get('/register', [SignUpController::class, 'showRegistrationForm'])->name('register');
Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');

// Route to handle the registration form submission
// Route::post('/register', [SignUpController::class, 'register']);
Route::get('/', [DashboardController::class, 'index'])->name('Dashboard');
Route::get('transaksi', [TransaksiController::class, 'index'])->name('transaksi');
Route::get('/transaksi/export/excel/{month}/{year}', [TransaksiController::class, 'export_excel'])->name('transaksi_export_excel');
Route::get('/transaksi_export_csv/{month}/{year}', [TransaksiController::class, 'export_csv'])->name('transaksi_export_csv');
Route::get('/transaksi_export_pdf/{month}/{year}', [TransaksiController::class, 'export_pdf'])->name('transaksi_export_pdf');
Route::delete('/transaksi/delete/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.delete');
Route::put('/transaksi/update/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
Route::get('stok', [StokController::class, 'index'])->name('stok');
Route::get('labarugi', [LabaRugiController::class, 'index'])->name('labarugi');
Route::get('aruskas', [ArusKasController::class, 'index'])->name('aruskas');
Route::get('/aruskas/export/{month}/{year}', [ArusKasController::class, 'export'])->name('aruskas_export');


Route::get('/analisis', [AnalisisTrendController::class, 'index'])->name('analisisTrend');
Route::delete('/stok/{id}/delete', [StokController::class, 'delete'])->name('stok.delete');
Route::post('/stok/update/{id}', [StokController::class, 'update'])->name('stok.update');

Route::get('utangPiutang', [UtangPiutangController::class, 'index'])->name('utangPiutang');
Route::delete('/utang/{id}/delete', [UtangPiutangController::class, 'delete'])->name('utang.delete');
Route::post('/utang/update/{id}', [UtangPiutangController::class, 'update'])->name('utang.update');
Route::post('/utang/store', [UtangPiutangController::class, 'store'])->name('utang.store');
