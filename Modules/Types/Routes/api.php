<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Types\Http\Controllers\TypesController;

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
    Route::group(['prefix' => 'types'], function(){
        Route::get('/', [TypesController::class, 'index'])->name('types.index');
        Route::get('/{id}', [TypesController::class, 'show'])->name('types.show');
        Route::post('/{id}/update', [TypesController::class, 'update'])->name('types.update');
        Route::post('/store', [TypesController::class, 'store'])->name('types.store');
        Route::post('/{id}/destroy', [TypesController::class, 'destroy'])->name('types.destroy');
        Route::post('/{id}/restore', [TypesController::class, 'restore'])->name('types.restore');
        Route::post('/{id}/force-destroy', [TypesController::class, 'forceDestroy'])->name('types.forceDestroy');
        Route::post('/{id}/change-status', [TypesController::class, 'changeStatus'])->name('types.changeStatus');
    });
});
