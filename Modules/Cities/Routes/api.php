<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Cities\Http\Controllers\CitiesController;

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
    Route::group(['prefix' => 'cities'], function(){
        Route::get('/', [CitiesController::class, 'index'])->name('cities.index');
        Route::get('/{id}', [CitiesController::class, 'show'])->name('cities.show');
        Route::post('/{id}/update', [CitiesController::class, 'update'])->name('cities.update');
        Route::post('/store', [CitiesController::class, 'store'])->name('cities.store');
        Route::post('/{id}/destroy', [CitiesController::class, 'destroy'])->name('cities.destroy');
        Route::post('/{id}/restore', [CitiesController::class, 'restore'])->name('cities.restore');
        Route::post('/{id}/force-destroy', [CitiesController::class, 'forceDestroy'])->name('cities.forceDestroy');
        Route::post('/{id}/change-status', [CitiesController::class, 'changeStatus'])->name('cities.changeStatus');
    });
});
