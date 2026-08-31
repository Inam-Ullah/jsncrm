<?php

use App\Http\Controllers\{
    HomeController,
    AreaController,
    ProfileController
};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route(auth()->check() ? 'home' : 'login');
});


Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

    Route::prefix('area')->group(function (){
        Route::get('/', [AreaController::class, 'index'])->name('area');
        Route::post('/insert', [AreaController::class, 'insert'])->name('area.insert');
        Route::get('/edit/{id}', [AreaController::class, 'edit'])->name('area.edit');
        Route::get('/delete/{id}', [AreaController::class, 'delete'])->name('area.delete');
        Route::post('/getAreas', [AreaController::class, 'getAreas'])->name('area.getAreas');
        Route::post('/update', [AreaController::class, 'update'])->name('area.update');
    });
});

require __DIR__.'/auth.php';
