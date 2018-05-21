<?php

use Illuminate\Http\Request;

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

Route::post('login', 'API\PassportController@login');
Route::post('register', 'API\PassportController@register');

Route::middleware('auth:api')->group( function () {

	Route::get('/', function () {
        return response()->json(['message' => 'Eventos API', 'status' => 'Connected']);;
    });

    Route::resource('eventos', 'API\EventosController');
    Route::post('eventos/search', 'API\EventosController@search');
    Route::resource('locais', 'API\LocaisController');
});