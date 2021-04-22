<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Genders\Http\Controllers\GendersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::group(['prefix' => 'genders'], function(){
        Route::get('/', [GendersController::class, 'index'])->name('genders.index');
        Route::get('/{id}', [GendersController::class, 'show'])->name('genders.show');
        Route::post('/{id}/update', [GendersController::class, 'update'])->name('genders.update');
        Route::post('/store', [GendersController::class, 'store'])->name('genders.store');
        Route::post('/{id}/destroy', [GendersController::class, 'destroy'])->name('genders.destroy');
        Route::post('/{id}/restore', [GendersController::class, 'restore'])->name('genders.restore');
        Route::post('/{id}/force-destroy', [GendersController::class, 'forceDestroy'])->name('genders.forceDestroy');
        Route::post('/{id}/change-status', [GendersController::class, 'changeStatus'])->name('genders.changeStatus');
    });
});
