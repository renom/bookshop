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
Route::get('v1/genres', 'GenresController@index');
Route::get('v1/genres/{id}', 'GenresController@show');
Route::post('v1/genres', 'GenresController@store');
Route::patch('v1/genres/{id}', 'GenresController@update');
Route::delete('v1/genres/{id}', 'GenresController@delete');
// v1/books
Route::get('v1/books', 'BooksController@index');
Route::get('v1/books/{id}', 'BooksController@show');
Route::post('v1/books', 'BooksController@store');
Route::patch('v1/books/{id}', 'BooksController@update');
Route::delete('v1/books/{id}', 'BooksController@delete');
// v1/shops
Route::get('v1/shops', 'ShopsController@index');
Route::get('v1/shops/{id}', 'ShopsController@show');
Route::post('v1/shops', 'ShopsController@store');
Route::patch('v1/shops/{id}', 'ShopsController@update');
Route::delete('v1/shops/{id}', 'ShopsController@delete');
// v1/shops/{shopId}/books
Route::get('v1/shops/{shopId}/books', 'ShopBooksController@index');
Route::get('v1/shops/{shopId}/books/{id}', 'ShopBooksController@show');
Route::post('v1/shops/{shopId}/books/{id}', 'ShopBooksController@link');
Route::delete('v1/shops/{shopId}/books/{id}', 'ShopBooksController@unlink');
// v1/shops/{shopId}/genres/{genreId}/books
Route::get('v1/shops/{shopId}/genres/{genreId}/books', 'ShopGenreBooksController@index');
Route::get('v1/shops/{shopId}/genres/{genreId}/books/{id}', 'ShopGenreBooksController@show');
