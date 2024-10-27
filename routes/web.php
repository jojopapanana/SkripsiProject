<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\LabaRugiController;
use App\Http\Controllers\ArusKasController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AnalisisTrendController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('login', [LoginController::class, 'showUserLoginForm'])->name('login');
Route::post('login/auth', [LoginController::class, 'userLogin'])->name('login.auth');

Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::get('/', [DashboardController::class, 'index'])->name('Dashboard')->middleware('auth');
Route::get('transaksi', [TransaksiController::class, 'index'])->name('transaksi');
Route::get('/transaksi/export/excel', [TransaksiController::class, 'export_excel'])->name('transaksi_export_excel');
Route::get('/transaksi/export/csv', [TransaksiController::class, 'export_csv'])->name('transaksi_export_csv');
Route::get('/transaksi/export/pdf', [TransaksiController::class, 'export_pdf'])->name('transaksi_export_pdf');
Route::delete('/transaksi/delete/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.delete');
Route::put('/transaksi/update/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
Route::get('stok', [StokController::class, 'index'])->name('stok');
Route::get('labarugi', [LabaRugiController::class, 'index'])->name('labarugi');
Route::get('/labarugi/export', [LabaRugiController::class, 'export'])->name('labarugi_export');
Route::get('aruskas', [ArusKasController::class, 'index'])->name('aruskas');
Route::get('/aruskas/export', [ArusKasController::class, 'export'])->name('aruskas_export');


Route::get('/analisis', [AnalisisTrendController::class, 'index'])->name('analisisTrend');
Route::delete('/stok/{id}/delete', [StokController::class, 'delete'])->name('stok.delete');
Route::post('/stok/update/{id}', [StokController::class, 'update'])->name('stok.update');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
