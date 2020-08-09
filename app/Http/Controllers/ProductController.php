<?php

namespace App\Http\Controllers;

use App\Frigo;
use App\Product;
use App\Category;
use App\Recette;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return response()->json(['success' => $products], 200);
    }



    public function post()
    {
        $products_name = [] ;

            $recette = Recette::findOrFail(18) ;
          $recette_products =  $recette->products->all() ;
          for ($i = 0; $i < count( $recette_products); $i++) {
            $product_name = $recette_products[$i]->name;
            $product_quantity =  $recette_products[$i]->pivot->quantity ; 
            $product_type =  $recette_products[$i]->pivot->type ; 

            array_push($products_name , ['name' =>  $product_name,  'quantity' =>  $product_quantity , 'type' => $product_type]);
        }
            return $products_name  ;
            // $product_id = $request->get('product_id');
            // $product =  Product::find($product_id);
    
            // $frigo_id = $request->get('frigo_id');
            // $frigo = Frigo::find($frigo_id);
    
        //   dd( $frigo->products->find(2) ) ;
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
            $frigo->products()->attach($product->id, ['quantity' =>  $qty_request, 'type' => $type]);
        } else {

            $pivot = $frigo->products->find($product_id)->pivot;

            $pivot->quantity +=  $qty_request;

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
    public function storeProductsRecette(Request $request)
    {

        $product_id = $request->get('product_id');
        $product =  Product::find($product_id);

        $recette_id = $request->get('recette_id');
        $recette = Recette::find($recette_id);

        //  $stock =  $product->frigos()->first()->pivot->stock  ;

        $qty_request = $request->get('quantity');
        $type = $request->get('type');

        if (  $recette->products->find($product_id) == null) {
            $recette->products()->attach($product->id, ['quantity' =>  $qty_request, 'type' => $type]);
        } else {

            $pivot =   $recette->products->find($product_id)->pivot;

            $pivot->quantity +=  $qty_request;

            $pivot->save();
        }

        return response()->json(['success' => [$recette, $product]], 200);

    }



    public function update(Request $request, $id)
    {
        $recette = Product::findOrFail($id);
        $recette->update($request->all());

        return $recette;
    }


    
    public function destroy(Request $request, $id)
    {
        $recette_id = $request->get('recette_id');
        $product =  Product::find($id);
        $recette = Recette::findOrFail($recette_id);
        $recette->products()->detach($product->id);

        return 204;
    }

    // public function destroy($id)
    // {
    //     $recette = Product::findOrFail($id);
    //     $recette->delete();

    //     return 204;
    // }
}
