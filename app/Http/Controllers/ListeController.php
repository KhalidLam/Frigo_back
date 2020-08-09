<?php

namespace App\Http\Controllers;

use App\Frigo;
use App\Liste;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListeController extends Controller
{

    public function index($user_id)
    {
        $liste  = Liste::where('user_id',  $user_id)->get();
        $Products = [];
        foreach ($liste  as $item) {
            $product_id = $item->product_id;
            $Product = Product::find($product_id);
            $product_name = $Product->name;
            $quantity = $item->quantity;
            $type = $item->type;

            array_push($Products, ['product_id' =>   $product_id, 'product_name' => $product_name, 'quantity' => $quantity, 'type' => $type]);
        }
        return response()->json($Products, 200);
    }

    public function storeListeToFrigo(Request $request)
    {     
        $frigo_id = $request->get('frigo_id');
        $frigo = Frigo::find($frigo_id);
        $Liste= $request->get('product_id');
        // return   $Liste ;
        foreach ($Liste as $item) {
            $product_id = $item['id'] ;
            $product =  Product::find($product_id);
             if ($frigo->products->find($product_id) == null) {
                $frigo->products()->attach($product->id, ['quantity' => $item['quantity'], 'type' =>  $item['type']]);
            } else {
            $pivot = $frigo->products->find($item['id'])->pivot;

            $pivot->quantity += $item['quantity'];

            $pivot->save();
            }
            Liste::where('product_id', $item['id'])->delete();
         }


         return response()->json(['success' => [$frigo ]], 200);
    }
    
    public function store(Request $request)
    {
        $product_id = $request->get('product_id');
        $listes  = Liste::where('user_id', Auth::user()->id)->get();
        // return ($product_id );
        if ($listes == '[]') {
            foreach ($product_id as $item1) {
                $liste =   Liste::create([
                    'product_id' => $item1['id'],
                    'user_id' =>  Auth::user()->id,
                    'quantity' =>  $item1['quantity'],
                    'type' =>  $item1['type']
                ]);
            }
            return $listes;
        } else { 
            foreach ($product_id as $item1) {
                $count = 0;
                foreach ($listes as $item2) {
                    if ($item1['id'] == $item2['product_id']) {
                        $NewQuantity = $item2['quantity']  + $item1['quantity'];
                        $liste  = Liste::where('product_id', $item1['id'])->delete();
                        $liste =   Liste::create([
                            'product_id' => $item1['id'],
                            'user_id' =>  Auth::user()->id,
                            'quantity' => $NewQuantity,
                            'type' =>  $item1['type']
                        ]);
                    } else {
                        $count++;
                    }
                }
                if (count($listes) ==  $count) {
                    $liste =   Liste::create([
                        'product_id' => $item1['id'],
                        'user_id' =>  Auth::user()->id,
                        'quantity' => $item1['quantity'],
                        'type' =>  $item1['type']
                    ]);
                }
            }
        }
        return  $listes;
    }


  
}


        // // return (count($product_id));
        // // $product_id =  ["id:16","id:8","id:16","id:8","id:16","id:8"];
        // // return(explode(',', $product_id));
        // $array = implode('', array_unique(explode(',', $product_id)));
        // // return response()->json(['product_id'=>$array],200);
        // $string  =  str_replace(['["', '"', ']', ' '], '', $array);

        // // return ($string) ;
        // $quantity = $request->get('quantity');
        // $type = $request->get('type');
        // $Posistion = [];
        // $lastPos = 0;
        // while (($lastPos = strpos($string, 'id:', $lastPos)) !== false) {
        //     $Posistion[] = $lastPos;
        //     $lastPos = $lastPos + strlen('id:');
        //     // dd($lastPos ) ;
        // }

        // // $Id = substr($product_id, $Posistion[0] + 4, $Posistion[1] -  $Posistion[0] - 4);
        // $ProductId = [];

        // $j = 1;
        // for ($i = 0; $i < count($Posistion); $i++) {
        //     if (isset($Posistion[$i]) && isset($Posistion[$i + $j])) {
        //         $Id = substr($string, $Posistion[$i] + strlen('id:'), $Posistion[$i + $j] -  $Posistion[$i] - strlen('id:'));
        //     } elseif (isset($Posistion[$i])) {
        //         $Id = substr($string, $Posistion[$i] + strlen('id:'));
        //     }
        //     array_push($ProductId, $Id);
        //     // $j++; 
        // }
        // foreach ($ProductId as $product_id) {
        //     $liste =   Liste::create([
        //         'product_id' => $product_id,
        //         'user_id' =>  $user_id,
        //         'quantity' =>  $quantity,
        //         'type' =>   $type
        //     ]);
        // }
        // // return [$product_id];
        // // dd($Posistion) ;
        // return [$liste];
