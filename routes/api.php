<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group(['namespace' => 'Api'], function () {

    Route::post('/login', [AuthController::class, 'login'])->name('admin.login');

    Route::post('/register', [AuthController::class, 'store'])->name('admin.register');

    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

        Route::post('/{id}/change-status', [AuthController::class, 'changeStatus'])->name('admin.changeStatus');

        Route::group(['prefix' => 'profile'], function () {
            Route::get('/show', [AuthController::class, 'showProfile'])->name('admin.profile.show');
            Route::post('/update', [AuthController::class, 'updateProfile'])->name('admin.profile.update');
        });
    });
});


