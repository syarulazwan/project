<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestEmailController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Project\ChatController;

use App\Http\Controllers\Project\DocumentController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\ForgotPasswordController;

Route::get('/', function () {

    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('auth/login');
    
})->name('home');

Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'index'])->name('login.form'); 
    Route::post('/login', [LoginController::class, 'store'])->name('login');

    Route::get('/register', [RegistrationController::class, 'index'])->name('sign-up.form'); 
    Route::post('/register', [RegistrationController::class, 'store'])->name('register'); 

    Route::get('/forgot', [ForgotPasswordController::class, 'index'])->name('forgot.form'); 
    Route::post('/forgot', [ForgotPasswordController::class, 'store'])->name('forgot'); 

});

Route::get('/dashboard', function () {

    return view('pages.dashboard/dashboard');

})->middleware(['auth', 'verified', 'prevent-back-history'])->name('dashboard');

Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    Route::get('/logout', [LogoutController::class, 'Logout'])->name('page.logout');

});

Route::prefix('zara')->group(function () {

    Route::controller(ChatController::class)->group(function () {
        Route::get('/', 'index')->name('zara.chat.index');
        Route::post('/ask', 'ask')->name('zara.chat.ask');
    });

    Route::prefix('pdf')->controller(DocumentController::class)->group(function () {
        Route::get('/', 'index')->name('zara.pdf.index');
        Route::post('/upload', 'upload')->name('zara.pdf.upload');
    });

});

Route::get('/documents/list', function () {
    return \App\Models\Document::select('id', 'title')->get();
})->name('documents.list');


Route::get('/test-email', [TestEmailController::class, 'send']);