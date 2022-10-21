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

Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'app/Http/Controllers/AuthController@login');
    Route::post('logout', 'app/Http/Controllers/AuthController@logout');
    Route::post('refresh', 'app/Http/Controllers/AuthController@refresh');
    Route::post('me', 'app/Http/Controllers/AuthController@me');
    Route::post('register', 'app/Http/Controllers/AuthController@register');

});
