<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Areas\Http\Controllers\AreasController;

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
    Route::group(['prefix' => 'areas'], function(){
        Route::get('/', [AreasController::class, 'index'])->name('areas.index');
        Route::get('/{id}', [AreasController::class, 'show'])->name('areas.show');
        Route::post('/{id}/update', [AreasController::class, 'update'])->name('areas.update');
        Route::post('/store', [AreasController::class, 'store'])->name('areas.store');
        Route::post('/{id}/destroy', [AreasController::class, 'destroy'])->name('areas.destroy');
        Route::post('/{id}/restore', [AreasController::class, 'restore'])->name('areas.restore');
        Route::post('/{id}/force-destroy', [AreasController::class, 'forceDestroy'])->name('areas.forceDestroy');
        Route::post('/{id}/change-status', [AreasController::class, 'changeStatus'])->name('areas.changeStatus');
    });
});
