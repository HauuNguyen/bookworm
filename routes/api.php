<?php

use App\Http\Controllers\BookController;
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


Route::get('books/discount/','BookController@getTopDiscount');
Route::get('books/{id}/reviews/{book_id?}','BookController@review');
Route::get('book/{book_id}/rating','BookController@getAverageRating');
Route::get('books/onsale',[BookController::class,'sortBySale']);
Route::get('books/onpopular','BookController@sortByPopular');
Route::get('books/pricedecrease','BookController@sortPriceLTH');
Route::get('books/priceincrease','BookController@sortPriceHTL');
Route::get('books/{id?}',[BookController::class,'index']);

Route::get('categories/','BookController@getCategories');
Route::get('category/{category_id}/books','BookController@getBooksOfCategory');


Route::get('authors/','BookController@getAuthors');
Route::get('author/{author_id}/books','BookController@getBooksOfAuthor');

Route::get('books/finalprice','BookController@getBooksFinalPrice');
Route::get('recommend/books','BookController@getRecommend');
Route::get('popular/books','BookController@topMostReview');
Route::get('listrating/{num_star}','BookController@getListOfRating');

Route::get('filter',[BookController::class,'filterBook']);

//Route::get('books','BookController@index');
