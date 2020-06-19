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
Route::post('details', 'API\UserController@details');
});


Route::get('recettes', 'RecettesController@index');
Route::get('recette/{id}', 'RecettesController@show');

Route::post('recette','RecettesController@store');
Route::put('recette/{id}', 'RecettesController@update');
Route::delete('recette/{id}', 'RecettesController@destroy');



Route::get('produits', 'ProduitController@index');

Route::post('produit','ProduitController@store');
Route::put('produit/{id}', 'ProduitController@update');
Route::delete('produit/{id}', 'ProduitController@destroy');


