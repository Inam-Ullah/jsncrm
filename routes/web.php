<?php

use App\Http\Controllers\{
    HomeController,     GlobalController,   AreaController,
    ProfileController,  IspController,      UserController
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
        Route::post('/getCitiesByAjax', [AreaController::class, 'getCitiesByAjax'])->name('area.getCitiesByAjax');
        Route::post('/getAreaByAjax', [AreaController::class, 'getAreaByAjax'])->name('area.getAreaByAjax');
        Route::post('/getSubAreaByAjax', [AreaController::class, 'getSubAreaByAjax'])->name('area.getSubAreaByAjax');
        Route::post('/update', [AreaController::class, 'update'])->name('area.update');
    });

    Route::prefix('isp')->group(function (){
        Route::get('/', [IspController::class, 'index'])->name('isp');
        Route::post('/insert', [IspController::class, 'insert'])->name('isp.insert');
        Route::get('/edit/{id}', [IspController::class, 'edit'])->name('isp.edit');
        Route::post('/update', [IspController::class, 'update'])->name('isp.update');
        Route::get('/delete/{id}', [IspController::class, 'delete'])->name('isp.delete');
    });

    Route::prefix('team')->group(function (){
        Route::get('/{roleName}', [UserController::class, 'index'])->name('team');
        Route::post('/insert/{roleName}', [UserController::class, 'insert'])->name('team.insert');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('team.edit');
        Route::post('/update', [UserController::class, 'update'])->name('team.update');
        Route::get('/delete/{id}', [UserController::class, 'delete'])->name('team.delete');
    });

});

require __DIR__.'/auth.php';
