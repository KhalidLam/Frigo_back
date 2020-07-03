<?php

namespace App\Http\Controllers;

use App\Frigo;
use App\Product;
use App\Recette;
use Illuminate\Http\Request;

class RecettesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Recettes = Recette::all();
        $TableRecettes = [];

        foreach ($Recettes as $Recette) {
            // $Recette= Recette::first() ;
            $AllProductRecette = $Recette->products->all();
            $ProductIdRecette = [];
            foreach ($AllProductRecette as $product) {

                array_push($ProductIdRecette,   $product->pivot->product_id);
                // => $product->name]);
            }
            //  print_r ( $ProductIdRecette ) ;

            array_push($TableRecettes, ['recette_id' => $Recette->id, 'products_id' => $ProductIdRecette]);
        }
        // return response()->json( $ProductIdRecette );
        $frigo_id = $request->get('frigo_id');
        $frigo = Frigo::findOrFail($frigo_id);
        $AllProductFrigo =    $frigo->products->all();
        $ProductIdFrigo = [];
        foreach ($AllProductFrigo as $product) {
            array_push($ProductIdFrigo, $product->pivot->product_id);
            // => $product->name ]);
        }
        // return     $ProductIdFrigo;
        // var_dump($ProductIdFrigo);
        $ProductExist =  [];
        $ProductDontExist =  [];
        $FilterRecette = [];
        for ($i = 0; $i < count($TableRecettes); $i++) {
            for ($j =  0; $j < count($TableRecettes[$i]['products_id']); $j++) {

                $key = array_search($TableRecettes[$i]['products_id'][$j], $ProductIdFrigo);
                if ($key !== false) {
                    array_push($ProductExist, $TableRecettes[$i]['products_id'][$j]);
                    // array_push(  $FilterRecette['ProductExist'],  $TableRecettes[$i]['products_id'][$j]   );
                } else {
                    array_push($ProductDontExist, $TableRecettes[$i]['products_id'][$j]);
                    // array_push(  $FilterRecette['ProductDontExist'],  $TableRecettes[$i]['products_id'][$j]   );
                    // array_push($table,  $key);
                }
            }
            array_push(
                $FilterRecette,
                [
                    'recette_id' => $TableRecettes[$i]['recette_id'],
                    'ProductExist' => $ProductExist,
                    'ProductDontExist' =>  $ProductDontExist,
                ]
            );
            $ProductExist = [];
            $ProductDontExist = [];
        }
        // return  $FilterRecette[1]['ProductExist'];
        $RecettesId = [];
        $ProductName = [];
        for ($i = 0; $i < count($FilterRecette); $i++) {

            $ProductDontExist = $FilterRecette[$i]['ProductDontExist'];
            $Recette_id = $FilterRecette[$i]['recette_id'];

            if (count($ProductDontExist) <= 5) {
                for ($j = 0; $j < count($ProductDontExist); $j++) {

                    $product_id = $ProductDontExist[$j];
                    $product_name = Product::find($product_id)->name;
                    array_push($ProductName,  $product_name);
                    // return $RecettesId[$i]['ProductDontExist'] ;
                }

                array_push($RecettesId, [
                    'recette_id' => $Recette_id,
                    'ProductDontExist' =>   $ProductDontExist,
                    'ProductNameDontExist' => $ProductName,
                ]);
                $ProductName = [];
            }
        }

        return response()->json(['success' =>  $RecettesId], 200);
    }


    public function store(Request $request)
    {
        return Recette::create($request->all());
    }

    public function show($id)
    {
        return Recette::find($id);
    }



    public function update(Request $request, $id)
    {
        $recette = Recette::findOrFail($id);
        $recette->update($request->all());

        return $recette;
    }


    public function destroy($id)
    {
        $recette = Recette::findOrFail($id);
        $recette->delete();

        return 204;
    }
}











        // for ($i=0; $i <2 ; $i++) { 

        //     // array_push($ProductExist , $TableRecettes[i]);
        //    echo '$TableRecettes[i]'  ;

        // }

        // foreach ($TableRecettes as $TableRecette) {

        //     foreach ( $TableRecette as $RecetteProduct_id) {
        //         // return $RecetteProduct_id  ;
        //         foreach ($ProductIdFrigo  as $FrigoProduct_id) {

        //             if ($FrigoProduct_id == $RecetteProduct_id) {

        //                 array_push($ProductExist,[ $RecetteProduct_id]);

        //             } else   if ($FrigoProduct_id !== $RecetteProduct_id) {
        //                 array_push($ProductDontExist, $RecetteProduct_id);
        //             }
        //         }

        //     }
        //     return [$ProductExist, $ProductDontExist];
        // }

        //  for ($i =0, $j=0 , $k = 0 ; $i < count($TableRecettes),$j < count($RecetteProduct_id), $k < count($ProductIdFrigo); $k++ ,$j++, $i++) {






     //    if( count($ProductDontExist) <= 5){

        //     array_push( $FilterRecette, [
        //          [ 'recette_id' => $TableRecettes[$i]['recette_id'] ,
        //          'ProductDontExist'=>  $ProductDontExist ,
        //         'ProductExist'=> $ProductExist 
        //         ] 

        //          ] );

        //    }else if ( count($ProductDontExist) > 5){

        //     // array_push( $FilterRecette, $TableRecettes[$i]['recette_id']);

        //     array_push( $FilterRecette, [ 'recette_id' => $TableRecettes[$i]['recette_id'] ,'ProductExist'=> $ProductExist ] );

        //    }        
        // array_push( $FilterRecettes ,  $FilterRecette  ) ;


        // return  $FilterRecette ;


        // print_r ( $RecetteProduct_id ) ;
        // array_push($ProductDontExist, $RecetteProduct_id) ;

        //                     for ($k = 0; $k < count($ProductIdFrigo); $k++) {

        //                         if ($ProductIdFrigo[$k] ==  $TableRecettes[$i]['products_id'][$j] ) {
        // // return 'ok' ;
        //                             array_push($ProductExist, [ $TableRecettes[$i]['recette_id'][$j] ,  $TableRecettes[$i]['products_id'][$j] ]);

        //                             $count++ ;

        //                         } else  if ($ProductIdFrigo[$k] !== $TableRecettes[$i]['products_id'][$j] ) {

        //                              $k++ ;

        //                             //  array_push($ProductDontExist, $TableRecettes[$i]['products_id'][$j] );
        //                         // return 'not ok' ;
        //                         //      $i++ ;
        //                     }

        // return $ProductIdFrigo[$k] ;
        // } 
        //   return $key ;
        // return [$ProductExist, $ProductDontExist]; 
        //   return  $TableRecettes[$i]['products_id'][$j];
        // } 
        // return   $ProductDontExist;  
        // }

        //  return [$ProductExist, $ProductDontExist];

        //    return $ProductIdFrigo ;


        // $array = array(0 => 'blue', 1 => 'red', 2 => 'green', 3 => 'red');

        // $key = array_search( 7 , $ProductIdFrigo); // $key = 2;
        // $key = array_search('red', $array);
        // $key =   array_search(  $TableRecettes[0]['products_id'][1] , $ProductIdFrigo);

        // return   $key ;




        //      for($i=0 , $i<TableRecettes.length , i++){
        // echo $i ;

        //      }
        //  $seats = "";
        //  $num_cols = 2;
        //  $num_rows = ''; // assume you don't validate the request, so this can receive empty string too
        //  // $num_rows = 0; // will output the same as above
        //  for($i = 1;$i<=($num_cols * $num_rows);$i++)
        //  {
        //      $seats = $seats."b";
        //  }
        //  var_dump($seats);
