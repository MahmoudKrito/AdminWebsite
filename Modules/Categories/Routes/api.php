<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Categories\Http\Controllers\CategoriesController;

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
    Route::group(['prefix' => 'categories'], function(){
        Route::get('/', [CategoriesController::class, 'index'])->name('categories.index');
        Route::get('/{id}', [CategoriesController::class, 'show'])->name('categories.show');
        Route::post('/{id}/update', [CategoriesController::class, 'update'])->name('categories.update');
        Route::post('/store', [CategoriesController::class, 'store'])->name('categories.store');
        Route::post('/{id}/destroy', [CategoriesController::class, 'destroy'])->name('categories.destroy');
        Route::post('/{id}/restore', [CategoriesController::class, 'restore'])->name('categories.restore');
        Route::post('/{id}/force-destroy', [CategoriesController::class, 'forceDestroy'])->name('categories.forceDestroy');
        Route::post('/{id}/change-status', [CategoriesController::class, 'changeStatus'])->name('categories.changeStatus');
    });
});
