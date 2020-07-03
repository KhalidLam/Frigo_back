<?php

use Illuminate\Http\Request;
// use Symfony\Component\Routing\Route;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/user', function(Request $request) {
    return Auth::user();
})->middleware('auth:api') ;

 
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('details', 'API\UserController@details');
   

});
//get tt les produit et les poster
Route::get('product', 'ProductController@index');

Route::post('product', 'ProductController@storeProductsFrigo');



//tst
Route::get('get', 'ProductController@get');

// les produits du frigo 
Route::get('frigo', 'FrigoController@index');

Route::post('frigo/photo' , 'FrigoController@storeImage');
Route::get('frigo/photo' , 'FrigoController@getImage');

Route::delete('frigo' , 'FrigoController@destroy');



Route::post('recette/photo','UploadController@uploadPhoto');

// Route::post('recette/photo','UploadController@uploadPhoto');



Route::get('recettes', 'RecettesController@index');
Route::get('recette/{id}', 'RecettesController@show');

Route::post('recette','RecettesController@store');
Route::put('recette/{id}', 'RecettesController@update');
Route::delete('recette/{id}', 'RecettesController@destroy');



// Route::get('products', 'ProductController@index');

// Route::post('product','ProduitController@store');

// Route::put('produit/{id}', 'ProduitController@update');
// Route::delete('produit/{id}', 'ProduitController@destroy');


