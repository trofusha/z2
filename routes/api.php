<?php

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JWTController;

Route::middleware(['auth:jwt'])->group(function () {
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::apiResource('users', UserController::class)->only(['index']);
    });
});

Route::prefix('auth')->controller(JWTController::class)->group(function () {
    Route::post('/login', 'login')->name('jwt.login')->withoutMiddleware('throttle:60|300,1')->middleware('throttle:100,1440,login:');
    Route::post('/logout', 'logout')->name('jwt.logout');
    Route::post('/refresh', 'refresh')->name('jwt.refresh');
    Route::post('/me', 'me')->name('jwt.me');
});
