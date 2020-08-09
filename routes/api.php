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

Route::get('/user', function (Request $request) {
    return Auth::user();
})->middleware('auth:api');


Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

    Route::group(['middleware' => 'auth:api'], function () {
    Route::get('details', 'API\UserController@details');
    Route::post('profile', 'API\UserController@update');
    Route::post('User/{id}', 'API\UserController@profile');
   
    //liste 
    Route::post('liste', 'ListeController@store');
    Route::get('liste/{user_id}', 'ListeController@index');
    Route::post('liste/frigo', 'ListeController@storeListeToFrigo');
    //comments
    Route::get('comment/{id}', 'CommentController@index');
    Route::post('comment/{id}', 'CommentController@store');
    Route::get('comment/edit/{id}', 'CommentController@edit');
    Route::put('comment/{id}', 'CommentController@update');
    Route::delete('comment/{id}', 'CommentController@destroy');
//recette
    Route::get('recettes', 'RecettesController@index');
    Route::get('mesrecettes/{user_id}', 'RecettesController@myRecipes');

    Route::post('recette', 'RecettesController@store');
    Route::delete('recette/product/{id}', 'ProductController@destroy');

});
//get tt les produit et les poster
Route::get('product', 'ProductController@index');

Route::post('frigo/product', 'ProductController@storeProductsFrigo');
Route::post('recette/product', 'ProductController@storeProductsRecette');




//tst
Route::get('post', 'ProductController@post');

// les produits du frigo 
Route::get('frigo', 'FrigoController@index');

Route::post('frigo/photo', 'FrigoController@storeImage');
Route::get('frigo/photo', 'FrigoController@getImage');

Route::delete('frigo', 'FrigoController@destroy');



Route::post('recette/photo', 'UploadController@uploadPhoto');

// Route::post('recette/photo','UploadController@uploadPhoto');

Route::get('categoryRecette', 'RecettesController@getCat');


Route::get('recettesHome/{frigo_id}', 'RecettesController@FilterRecette');

// Route::get('recette/{id}', 'RecettesController@show');

Route::get('recette/{id}', 'RecettesController@show');
Route::put('recette/{id}', 'RecettesController@update');
// Route::delete('recette/{id}', 'RecettesController@destroy');

 
// Route::get('products', 'ProductController@index');

// Route::post('product','ProduitController@store');

// Route::put('produit/{id}', 'ProduitController@update');
// Route::delete('produit/{id}', 'ProduitController@destroy');
//search
Route::get('search', 'RecettesController@search');

//favoris
Route::get('favoris', 'FavorisController@index');
