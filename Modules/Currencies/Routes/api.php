<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Currencies\Http\Controllers\CurrenciesController;

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
Route::group(['middleware' => ['auth:sanctum', 'Locale']], function () {
    Route::group(['prefix' => 'currencies'], function () {
        Route::get('/', [CurrenciesController::class, 'index'])->name('currencies.index');
        Route::get('/{id}', [CurrenciesController::class, 'show'])->name('currencies.show');
        Route::post('/{id}/update', [CurrenciesController::class, 'update'])->name('currencies.update');
        Route::post('/store', [CurrenciesController::class, 'store'])->name('currencies.store');
        Route::post('/{id}/destroy', [CurrenciesController::class, 'destroy'])->name('currencies.destroy');
        Route::post('/{id}/restore', [CurrenciesController::class, 'restore'])->name('currencies.restore');
        Route::post('/{id}/force-destroy', [CurrenciesController::class, 'forceDestroy'])->name('currencies.forceDestroy');
        Route::post('/{id}/change-status', [CurrenciesController::class, 'changeStatus'])->name('currencies.changeStatus');
    });
});
