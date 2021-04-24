<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Zones\Http\Controllers\ZonesController;

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

Route::group(['middleware' => ['auth:sanctum', 'Locale']], function(){
    Route::group(['prefix' => 'zones'], function(){
        Route::get('/', [ZonesController::class, 'index'])->name('zones.index');
        Route::get('/{id}', [ZonesController::class, 'show'])->name('zones.show');
        Route::post('/{id}/update', [ZonesController::class, 'update'])->name('zones.update');
        Route::post('/store', [ZonesController::class, 'store'])->name('zones.store');
        Route::post('/{id}/destroy', [ZonesController::class, 'destroy'])->name('zones.destroy');
        Route::post('/{id}/restore', [ZonesController::class, 'restore'])->name('zones.restore');
        Route::post('/{id}/force-destroy', [ZonesController::class, 'forceDestroy'])->name('zones.forceDestroy');
        Route::post('/{id}/change-status', [ZonesController::class, 'changeStatus'])->name('zones.changeStatus');
    });
});
