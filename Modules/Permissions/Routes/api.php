<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Permissions\Http\Controllers\PermissionsController;

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
    Route::group(['prefix' => 'permissions'], function(){
        Route::get('/', [PermissionsController::class, 'index'])->name('permissions.index');
        Route::get('/{id}', [PermissionsController::class, 'show'])->name('permissions.show');
        Route::post('/{id}/update', [PermissionsController::class, 'update'])->name('permissions.update');
        Route::post('/store', [PermissionsController::class, 'store'])->name('permissions.store');
        Route::post('/{id}/destroy', [PermissionsController::class, 'destroy'])->name('permissions.destroy');
        Route::post('/{id}/restore', [PermissionsController::class, 'restore'])->name('permissions.restore');
        Route::post('/{id}/force-destroy', [PermissionsController::class, 'forceDestroy'])->name('permissions.forceDestroy');
        Route::post('/assign-user', [PermissionsController::class, 'assignUser'])->name('permissions.assignUser');
        Route::post('/remove-user', [PermissionsController::class, 'removeUser'])->name('permissions.removeUser');
    });
});
