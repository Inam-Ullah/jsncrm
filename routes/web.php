<?php

use App\Http\Controllers\{
    HomeController,
    ProfileController
};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route(auth()->check() ? 'home' : 'login');
});


Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
});

require __DIR__.'/auth.php';
