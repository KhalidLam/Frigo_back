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



    public function get( )
    {
        $product = Product::findOrFail(2) ;

        $frigo = Frigo::findOrFail(2);

      dd( $frigo->products->find(2) ) ;
        // $product->frigos->find(5)->pivot->stock 
        // $frigo->products->first()->name ; /// tomate
       
        // $arr = [];
        // $i = 0;
        // foreach ($products as $product) {
        //  $arr= $product->name ;
        //     echo '  '. $product->name  ;
        // };
        // $category = Product::with('categories') ;
        
        // return response()->json(['success' => $products], 200)  ;
        // $frigo = Frigo::find(2);
        // dd($frigo->products->find(3));
        // $frigo->products()->first()->name ; /// tomate

    }



    public function storeProductsFrigo(Request $request)
    {

        $product_id = $request->get('product_id');
        $product =  Product::find($product_id);

        $frigo_id = $request->get('frigo_id');
        $frigo = Frigo::find($frigo_id);

        //  $stock =  $product->frigos()->first()->pivot->stock  ;

        $qty_request = $request->get('quantity');
        $type = $request->get('type');

        if ($frigo->products->find($product_id) == null) {
         $frigo->products()->attach($product->id, ['quantity' =>  $qty_request , 'type' => $type]);

        } else {

            $pivot = $frigo->products->find($product_id)->pivot;

            $pivot->quantity +=  $qty_request ;

            $pivot->save();
        }

        return response()->json(['success' => [$frigo, $product]], 200);
    }




    // $frigo = Frigo::create($request->all()) ;
    // $frigo = new Frigo() ;
    // $frigo->products()->attach($request);
    // auth()->user()->frigos()->create([
    //     // 'name' => $request 
    // ]) ;
    // $frigo->save();
    // return ($frigo);
    // }



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
