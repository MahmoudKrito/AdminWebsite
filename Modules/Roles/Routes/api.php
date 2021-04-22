<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Roles\Http\Controllers\RolesController;

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
    Route::group(['prefix' => 'roles'], function(){
        Route::get('/', [RolesController::class, 'index'])->name('roles.index');
        Route::get('/{id}', [RolesController::class, 'show'])->name('roles.show');
        Route::post('/{id}/update', [RolesController::class, 'update'])->name('roles.update');
        Route::post('/store', [RolesController::class, 'store'])->name('roles.store');
        Route::post('/{id}/destroy', [RolesController::class, 'destroy'])->name('roles.destroy');
        Route::post('/{id}/restore', [RolesController::class, 'restore'])->name('roles.restore');
        Route::post('/{id}/force-destroy', [RolesController::class, 'forceDestroy'])->name('roles.forceDestroy');
        Route::post('/assign-user', [RolesController::class, 'assignUser'])->name('roles.assignUser');
        Route::post('/remove-user', [RolesController::class, 'removeUser'])->name('roles.removeUser');
    });
});
