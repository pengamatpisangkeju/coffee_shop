<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->to('dashboard'));

Route::group([
    'middleware' => 'guest'
], function () {
    Route::get('/login', [AuthController::class,'index'])->name('login');
    Route::post('/login', [AuthController::class,'login'])->name('login');
});

Route::group([
    'middleware' => 'auth'
], function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::group([
        'prefix' => 'item',
    ], function() {
        Route::get('/', [ItemController::class, 'index'])->name('item.index');
        Route::get('/create', [ItemController::class, 'create'])->name('item.create');
        Route::post('/', [ItemController::class, 'store'])->name('item.store');
        Route::get('/{item}', [ItemController::class, 'edit'])->name('item.edit');
        Route::put('/{item}', [ItemController::class, 'update'])->name('item.update');
        Route::delete('/{item}', [ItemController::class, 'destroy'])->name('item.destroy');
    });
});