<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;


Route::get('/', function () {

    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('auth/login');
    
})->name('home');

Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'index'])->name('login.form'); 
    Route::post('/login', [LoginController::class, 'store'])->name('login');

});

Route::get('/dashboard', function () {

    return view('pages.dashboard/dashboard');

})->middleware(['auth', 'verified', 'prevent-back-history'])->name('dashboard');

Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    Route::get('/logout', [LogoutController::class, 'Logout'])->name('page.logout');

});