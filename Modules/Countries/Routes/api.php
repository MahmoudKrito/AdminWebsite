<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Countries\Http\Controllers\CountryController;

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
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'countries'], function () {
        Route::get('/', [CountryController::class, 'index'])->name('countries.index');
        Route::get('/{id}', [CountryController::class, 'show'])->name('countries.show');
        Route::post('/{id}/update', [CountryController::class, 'update'])->name('countries.update');
        Route::post('/store', [CountryController::class, 'store'])->name('countries.store');
        Route::post('/{id}/destroy', [CountryController::class, 'destroy'])->name('countries.destroy');
        Route::post('/{id}/restore', [CountryController::class, 'restore'])->name('countries.restore');
        Route::post('/{id}/force-destroy', [CountryController::class, 'forceDestroy'])->name('countries.forceDestroy');
        Route::post('/{id}/change-status', [CountryController::class, 'changeStatus'])->name('countries.changeStatus');
    });
});
