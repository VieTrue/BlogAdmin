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


Route::get('fei', 'FeiController@index');

Route::post('article/getlist', 'ArticleController@getList');
Route::post('article/getinfo', 'ArticleController@getInfo');
Route::post('article/spotlikes', 'ArticleController@spotLikes');
Route::post('article/gettaglist', 'ArticleController@getTagList');
Route::post('article/search', 'ArticleController@getSearchList');

Route::post('comment/setcomment', 'CommentController@setComment');
Route::post('comment/getlist', 'CommentController@getCommentList');

Route::post('category/getlist', 'CategoryController@getList');


Route::post('user/getinfo', 'UserController@getInfo');