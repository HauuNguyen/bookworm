<?php

use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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


Route::get('books/discount/','BookController@getTopDiscount');
Route::get('books/{id}/reviews/{book_id?}','BookController@review');
Route::get('books/finalprice','BookController@getBooksFinalPrice');
Route::get('book/{book_id}/rating','BookController@getAverageRating');
Route::get('books/onsale',[BookController::class,'sortBySale']);
Route::get('books/onpopular','BookController@sortByPopular');
Route::get('books/pricedecrease','BookController@sortPriceLTH');
Route::get('books/priceincrease','BookController@sortPriceHTL');
Route::get('book/{id?}',[BookController::class,'index']);

Route::get('categories/','BookController@getCategories');
Route::get('category/{category_id}/books','BookController@getBooksOfCategory');


Route::get('authors/','BookController@getAuthors');
Route::get('author/{author_id}/books','BookController@getBooksOfAuthor');


Route::get('recommend/books','BookController@getRecommend');
Route::get('popular/books','BookController@topMostPopular');
Route::get('listrating/{num_star}','BookController@getListOfRating');

Route::get('filter',[BookController::class,'filterBook']);
Route::get('filtering',[BookController::class,'getFiltering']);

//Route::get('books','BookController@index');
Route::group([
    'prefix' => 'auth'
], function() {
    Route::post('login',[AuthController::class,'login']);
    Route::post('register',[AuthController::class,'register']);
    Route::get('me',[AuthController::class,'me']);
    Route::post('logout',[AuthController::class,'logout']);
});
Route::middleware('auth:sanctum')->get('user', function (Request $request) {
    return $request->user();
});
