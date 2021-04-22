<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Layouts\Http\Controllers\LayoutsController;

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
    Route::group(['prefix' => 'layouts'], function(){
        Route::get('/', [LayoutsController::class, 'index'])->name('layouts.index');
        Route::get('/{id}', [LayoutsController::class, 'show'])->name('layouts.show');
        Route::post('/{id}/update', [LayoutsController::class, 'update'])->name('layouts.update');
        Route::post('/store', [LayoutsController::class, 'store'])->name('layouts.store');
        Route::post('/{id}/destroy', [LayoutsController::class, 'destroy'])->name('layouts.destroy');
        Route::post('/{id}/restore', [LayoutsController::class, 'restore'])->name('layouts.restore');
        Route::post('/{id}/force-destroy', [LayoutsController::class, 'forceDestroy'])->name('layouts.forceDestroy');
        Route::post('/{id}/change-status', [LayoutsController::class, 'changeStatus'])->name('layouts.changeStatus');
    });
});
