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

Route::get('/hello', function (){
   return 'Hello Restful Api';
});

Route::get('/users', function (){
    return factory(\App\User::class,10)->make();
});

Route::get('/categories/custom1', 'Api\CategoriesController@custom1');
Route::get('/products/custom1', 'Api\ProductController@custom1');
Route::get('/products/custom2', 'Api\ProductController@custom2');
Route::get('/categories/report1', 'Api\CategoriesController@report1');
Route::get('/users/custom1', 'Api\UserController@custom1');
Route::get('/products/custom3', 'Api\ProductController@custom3');
Route::get('/products/listwithcategories', 'Api\ProductController@listwithCategories');



Route::apiResource('/products', 'Api\ProductController');
Route::apiResource('/users', 'Api\UserController');
Route::apiResource('/categories', 'Api\CategoriesController');
