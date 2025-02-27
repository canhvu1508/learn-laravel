<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'actionRegister']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'actionLogin']);
Route::get('/get-districts', [\App\Http\Controllers\AuthController::class, 'getDisTricts']);
Route::get('/get-category', [\App\Http\Controllers\AuthController::class, 'getCategory']);
Route::get('/get-wards/{id}', [\App\Http\Controllers\AuthController::class, 'getWards']);
Route::group(['middleware' => 'jwt'], function ($router) {
    Route::get('/me', [\App\Http\Controllers\AuthController::class, 'getDataUser']);
    Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'actionLogout']);

    Route::group(['prefix' => '/admin'], function () {
        Route::group(['prefix' => '/user'], function () {
            Route::post('/get-data', [\App\Http\Controllers\Admin\UserController::class, 'getData']);
            Route::get('/update-status/{id}', [\App\Http\Controllers\Admin\UserController::class, 'updateStatus']);
            Route::get('/destroy/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy']);
        });

        Route::group(['prefix' => '/owner'], function () {
            Route::post('/create', [\App\Http\Controllers\Admin\OwnerController::class, 'createOwner']);
            Route::post('/get-data', [\App\Http\Controllers\Admin\OwnerController::class, 'getData']);
            Route::get('/update-status/{id}', [\App\Http\Controllers\Admin\OwnerController::class, 'updateStatus']);
            Route::get('/destroy/{id}', [\App\Http\Controllers\Admin\OwnerController::class, 'destroy']);
        });
    });

    Route::group(['prefix' => '/owner'], function () {
        Route::post('/update-my-information', [\App\Http\Controllers\AuthController::class, 'updateInfor']);

        Route::post('/get-schedule-in-month', [\App\Http\Controllers\Owner\FootballPitchController::class, 'getScheduleInMonth']);
        Route::post('/get-schedule-in-date', [\App\Http\Controllers\Owner\FootballPitchController::class, 'getScheduleInDate']);

        Route::get('/get-total-money', [\App\Http\Controllers\Owner\FootballPitchController::class, 'getTotalMoney']);

        Route::group(['prefix' => '/football-pitch'], function () {
            Route::post('/create', [\App\Http\Controllers\Owner\FootballPitchController::class, 'store']);
            Route::get('/get-data', [\App\Http\Controllers\Owner\FootballPitchController::class, 'getData']);
            Route::get('/get-data/{id}', [\App\Http\Controllers\Owner\FootballPitchController::class, 'getDataById']);
            Route::post('/update', [\App\Http\Controllers\Owner\FootballPitchController::class, 'update']);
            Route::get('/update-status/{id}', [\App\Http\Controllers\Owner\FootballPitchController::class, 'updateStatus']);
            Route::get('/destroy/{id}', [\App\Http\Controllers\Owner\FootballPitchController::class, 'destroy']);
        });
    });
});
