<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SignUpController;

Route::get('/', function () {
    return view('welcome');
});

// Route to show the registration form
Route::get('/register', [SignUpController::class, 'showRegistrationForm'])->name('register');

// Route to handle the registration form submission
// Route::post('/register', [SignUpController::class, 'register']);
