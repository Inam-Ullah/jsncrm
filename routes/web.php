<?php

use App\Http\Controllers\{
    HomeController,     GlobalController,   AreaController,
    ProfileController
};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route(auth()->check() ? 'home' : 'login');
});


Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

    Route::prefix('global')->group(function (){
        Route::post('/change-password', [GlobalController::class, 'changePassword'])->name('password');
        Route::post('/change-photo', [GlobalController::class, 'changePhoto'])->name('photo');
        Route::post('/add-note', [GlobalController::class, 'addNote'])->name('note');
        Route::post('/add-document', [GlobalController::class, 'addDocument'])->name('document');
        Route::post('/document/{document}', [GlobalController::class, 'deleteDocument'])->name('document.delete');
        Route::post('/check-username', [GlobalController::class, 'checkUsername'])->name('check.username');
    });

    Route::prefix('area')->group(function (){
        Route::get('/', [AreaController::class, 'index'])->name('area');
        Route::post('/insert', [AreaController::class, 'insert'])->name('area.insert');
        Route::get('/edit/{id}', [AreaController::class, 'edit'])->name('area.edit');
        Route::get('/delete/{id}', [AreaController::class, 'delete'])->name('area.delete');
        Route::post('/getAreas', [AreaController::class, 'getAreas'])->name('area.getAreas');
        Route::post('/getAreaByAjax', [AreaController::class, 'getAreaByAjax'])->name('area.getAreaByAjax');
        Route::post('/getSubAreaByAjax', [AreaController::class, 'getSubAreaByAjax'])->name('area.getSubAreaByAjax');
        Route::post('/update', [AreaController::class, 'update'])->name('area.update');
    });

    Route::post('/admin_portal/user/user/getAreaByAjax', [AreaController::class, 'getAreaByAjax']);
    Route::post('/admin_portal/user/user/getSubAreaByAjax', [AreaController::class, 'getSubAreaByAjax']);
});

require __DIR__.'/auth.php';
