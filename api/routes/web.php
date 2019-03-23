<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


use Illuminate\Support\Facades\Route;


Route::post('auth/login', 'AuthController@authenticate');

Route::group(
    [
        'middleware' => 'jwt.auth',
        'prefix' => env('API_VERSION_ONE', '/v2'),
    ],
    function() use ($router) {
        Route::get('/phones', 'PhonesController@index');
        Route::get('/phones/{phoneId}', 'PhonesController@show');
        Route::post('/phones', 'PhonesController@store');
        Route::patch('/phones/{phoneId}', 'PhonesController@update');
        Route::delete('/phones/{phoneId}', 'PhonesController@destroy');
    }
);


