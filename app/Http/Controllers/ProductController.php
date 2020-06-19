<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all() ;
    }

    public function store(Request $request)
    {
         return Product::create($request->all()) ;
    }



    public function update(Request $request, $id)
    {
        $recette = Product::findOrFail($id) ;
        $recette->update($request->all()) ;

        return $recette ;
        
    }

    
    public function destroy($id)
    {
        $recette = Product::findOrFail($id) ;
        $recette->delete() ;

        return 204  ;
    }

}
