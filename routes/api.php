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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// auth routes
Route::post('/auth/register', 'AuthController@register');
Route::post('/auth/login', 'AuthController@login');
//routes
Route::group(['middleware'=>'auth:api'], function() {
    Route::post('/stations/create', 'StationsController@create');
    Route::post('/stations/update', 'StationsController@update');
    Route::post('/stations/delete', 'StationsController@delete');
    Route::post('/buses/create', 'BusesController@create');
    Route::post('/trips/create', 'TripsController@create');
});
