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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/pet', 'PetController@store');
Route::put('/pet', 'PetController@update');

Route::get('/pet/{petId}', 'PetController@show')->where('petId', '[0-9]+');
Route::delete('/pet/{petId}', 'PetController@destroy')->where('petId', '[0-9]+');

Route::get('/pet/findByTags', 'PetController@showAllByTag');


