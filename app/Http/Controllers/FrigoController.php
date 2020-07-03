<?php

namespace App\Http\Controllers;
Use Faker ;
use App\Frigo;
use App\Product;
use App\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class FrigoController extends Controller
{
    



public function index(Request $request){

        // $frigo->products->first()->name ; /// tomate

    $frigo_id = $request->get('frigo_id') ;

    $frigo = Frigo::findOrFail($frigo_id) ;

    $frigo_products =  $frigo->products->all() ;

    $categories = Category::all() ;
    
    // $product_id = $request->get('product_id') ;
    // $product= Product::findOrFail($product_id) ;

    // $pivot = $frigo->products->find($product_id)->pivot ;

// dd(    $pivot);

    return response()->json(['success' => [$frigo_products, $frigo->image , $categories]], 200)  ;
}






   public function storeImage(Request $request){

    $file = $request->file('photo');
    $ext = $file->extension();

    $fileName = Carbon::now()->format('d-m-Y') . '-' . Str::random(10) . '.' . $ext;

    $request->file('photo')->move(public_path("/img/"), $fileName ) ;

    $frigo_id = $request->get('frigo_id');
    $frigo = Frigo::find($frigo_id);
    // dd($frigo->user_id);

   $frigo->image = 'img/'.$fileName ;
   $frigo->save() ;
    return response()->json(['url'=>  'xxxx' ],200) ;

}

public function destroy(Request $request)
{
    $frigo_id = $request->get('frigo_id');
    $frigo =Frigo::findOrFail($frigo_id) ;

     $product_id = $request->get('product_id') ;
     $product =  Product::find($product_id);

     $frigo->products()->detach($product->id );

    return 204  ;
}


}
