<?php

use Illuminate\Http\Request;
// use Illuminate\Routing\Route;

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

// list the articles
Route::get('articles', 'ArticleController@index');

// list the single articles
Route::get('article/{id}', 'ArticleController@show');

// create new article
Route::post('article', 'ArticleController@store');

// update the article
Route::put('article', 'ArticleController@store');

// delete the article
Route::delete('article/{id}', 'ArticleController@destroy');