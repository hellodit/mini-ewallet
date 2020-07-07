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

Route::group(['prefix' => 'account'], function () {
    Route::post('/register', 'Api\AuthController@register');
    Route::post('/login', 'Api\AuthController@login');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/profile','Api\UserController@profile');
        Route::get('/histories','Api\UserController@history');
        Route::post('/logout', 'Api\AuthController@logout');
    });
});

Route::group(['prefix' => 'transaction','middleware' => 'auth:api'], function () {
    Route::post('/topup','Api\BalanceController@topup');
    Route::post('/transfer','Api\BalanceController@transfer');
});

