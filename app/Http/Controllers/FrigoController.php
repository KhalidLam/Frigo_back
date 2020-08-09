<?php

namespace App\Http\Controllers;

use Faker;
use App\Frigo;
use App\Product;
use App\Category;
use App\Recette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FrigoController extends Controller
{




    public function index(Request $request)
    {
        function unique_multidim_array($array, $key)
        {
            $temp_array = array();
            $i = 0;
            $key_array = array();

            foreach ($array as $val) {
                if (!in_array($val[$key], $key_array)) {
                    $key_array[$i] = $val[$key];
                    $temp_array[$i] = $val;
                }
                $i++;
            }
            return $temp_array;
        }

        $frigo_id = $request->get('frigo_id');

        $frigo = Frigo::findOrFail($frigo_id);

        $frigo_products =  $frigo->products->all();
        $Categories_id = [];

        for ($i = 0; $i < count($frigo_products); $i++) {

            $category_id = $frigo_products[$i]->category_id;
            $category_name = Category::find( $category_id)->name;

            array_push($Categories_id, ['category_id' =>  $category_id,  'category_name' => $category_name]);
        }
          $Categories_id  = unique_multidim_array($Categories_id, 'category_id');
        // dd(    $pivot);
        //  return $Category ;
        $CategoryProducts = [];

        $i = 0;
        // for ($i=0; $i < count($Category) ; $i++) { 
        foreach ($Categories_id  as $Category) {
            $category_id = $Category['category_id'];
            $category_name =  $Category['category_name'];

            $frigo_products =  $frigo->products->where('category_id', $category_id);

            switch ($category_id) {
                case 3:
                    $image = 'http://localhost:1000/CategoryImage/Spices_Herbs.jpg';
                    break;
                case 6:
                    $image = 'http://localhost:1000/CategoryImage/Breads_cereals.png';
                    break;
                case 24:
                    $image = 'http://localhost:1000/CategoryImage/Oils.jpg';
                    break;
                case 5:
                    $image = 'http://localhost:1000/CategoryImage/Meat_Poultry_Fish_Eggs.jpg';
                    break;
                case 1:
                    $image = 'http://localhost:1000/CategoryImage/Fruit_vegetables.jpg';
                    break;
                case 2:
                    $image = 'http://localhost:1000/CategoryImage/Dairy_products.jpg';
                    break;
            };

            array_push($CategoryProducts, ['category_id' =>  $category_id, 'category_name' => $category_name, 'category_image' => $image, 'products' =>  $frigo_products]);

            $i++;
        }

        // return  $frigo_products ;
        return response()->json(['success' => $CategoryProducts, 'frigo_image' =>$frigo->image], 200);
    }





    public function storeImage(Request $request)
    {

        $file = $request->file('photo');
        $ext = $file->extension();

        $fileName = Carbon::now()->format('d-m-Y') . '-' . Str::random(10) . '.' . $ext;

        $request->file('photo')->move(public_path("/img/"), $fileName);

        $frigo_id = $request->get('frigo_id');

        $frigo = Frigo::find($frigo_id);
        // dd($frigo->user_id);

        $frigo->image = 'img/' . $fileName;
        
        $frigo->save();

        return response()->json(['url' =>  'xxxx'], 200);
    }

  
    
    public function destroy(Request $request)
    {
        $frigo_id = $request->get('frigo_id');
  
        $frigo = Frigo::findOrFail($frigo_id);

        $product_id = $request->get('product_id');
        $product =  Product::find($product_id);

        $frigo->products()->detach($product->id);

        return 204;
    }
}
