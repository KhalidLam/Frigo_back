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


Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');


Route::group(['middleware' => 'auth:api'], function(){
    Route::get('details', 'API\UserController@details');
    // Route::apiresource('products','ProductController');
 
});

// Route::get('products', 'ProductController@index');
Route::post('product', 'ProductController@store');


Route::get('recettes', 'RecettesController@index');
Route::get('recette/{id}', 'RecettesController@show');

Route::post('recette','RecettesController@store');
Route::put('recette/{id}', 'RecettesController@update');
Route::delete('recette/{id}', 'RecettesController@destroy');



// Route::get('products', 'ProductController@index');

// Route::post('product','ProduitController@store');

// Route::put('produit/{id}', 'ProduitController@update');
// Route::delete('produit/{id}', 'ProduitController@destroy');


