<?php

namespace App\Http\Controllers;

use App\Frigo;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json(['success' => $products], 200);
    }
    
    public function store(Request $request)
    {
        
        $product_id = $request->get('product_id');
        $product =  Product::find($product_id);
        // Product::find(3);
        // dd($product) ;
        $frigo_id = $request->get('frigo_id');
        // dd($product_id) ;
        $frigo = Frigo::find($frigo_id);
        $stock = $request->get('stock');
        $frigo->products()->attach($product->id , [ 'stock' => $stock]);
        // $product->name ='fgossa' ;
        // $product->category_id =1 ;
        // $product->frigos()->attach($frigo->id);


        if ($product) {
        if ($frigo) {
        
               
                return response()->json(['success' => [$product , $frigo]], 200);
            } else {
                // dd($product_id) ;
                return response()->json(['error' => [$frigo, $product]], 401);
            }
        }




        // $frigo = Frigo::create($request->all()) ;
        // $frigo = new Frigo() ;
        // $frigo->products()->attach($request);
        // auth()->user()->frigos()->create([
        //     // 'name' => $request 
        // ]) ;
        // $frigo->save();
        // return ($frigo);
    }



    public function update(Request $request, $id)
    {
        $recette = Product::findOrFail($id);
        $recette->update($request->all());

        return $recette;
    }


    public function destroy($id)
    {
        $recette = Product::findOrFail($id);
        $recette->delete();

        return 204;
    }
}
