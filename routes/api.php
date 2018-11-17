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

// v1/genres
Route::get('v1/genres', 'GenreController@index');
Route::get('v1/genres/{id}', 'GenreController@show');
Route::post('v1/genres', 'GenreController@store');
Route::patch('v1/genres/{id}', 'GenreController@update');
Route::delete('v1/genres/{id}', 'GenreController@delete');
// v1/books
Route::get('v1/books', 'BookController@index');
Route::get('v1/books/{id}', 'BookController@show');
Route::post('v1/books', 'BookController@store');
Route::patch('v1/books/{id}', 'BookController@update');
Route::delete('v1/books/{id}', 'BookController@delete');
// v1/shops
Route::get('v1/shops', 'ShopController@index');
Route::get('v1/shops/{id}', 'ShopController@show');
Route::post('v1/shops', 'ShopController@store');
Route::patch('v1/shops/{id}', 'ShopController@update');
Route::delete('v1/shops/{id}', 'ShopController@delete');
