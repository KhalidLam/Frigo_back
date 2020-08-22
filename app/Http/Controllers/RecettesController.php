<?php

namespace App\Http\Controllers;


use App\Categoryrecette;
use App\Comment;
use App\Frigo;
use App\Product;
use App\Recette;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RecettesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
         
        $Recettes  = Recette::latest()->get();
        $Recipes = [];
        
        foreach ($Recettes as $recette) {
            $user_id = $recette->user_id;
            $user = User::find($user_id); 
            $comments= Comment::where('recette_id' , $recette->id )->get() ;
            $rating = 0 ;
           foreach ($comments as $comment) {
              $rating += $comment->rating  ; 
           }
           if($rating >0){
            $rating =  $rating/count( $comments) ;
           }
         
            array_push($Recipes, ['recette' =>$recette, 'userName' => $user->name , 'rating' =>  $rating]);
     
        }
        return response()->json(['success' => $Recipes    ], 200);
    }
    public function getCat()
    {
        $Categories = Categoryrecette::all();
        $Categories_id = [];

        foreach ($Categories as $Category) {
            $Category_id = $Category->id;
            $Category_name = $Category->name;
            array_push($Categories_id, ['category_id' =>  $Category_id,  'category_name' => $Category_name]);
        }
        $CategoryRecettes = [];
        $i = 0;

        foreach ($Categories_id  as $Category) {
            $Category_id = $Category['category_id'];
            $Category_name =  $Category['category_name'];
            $Recette  = Recette::all()->where('category_id',  $Category_id);;

            array_push($CategoryRecettes, ['category_id' =>  $Category_id, 'category_name' => $Category_name, 'Recettes' =>  $Recette]);
            $i++;
        }
        return response()->json(['categories' => $Categories, 'CategoryRecettes' => $CategoryRecettes], 200);
        // return $CategoryRecette ;
    }

    public function myRecipes($user_id)
    {

        $Recettes  = Recette::where('user_id',  $user_id)->get();
      
        $Recipes = [];
        foreach ($Recettes as $recette) {
           $user = User::find($user_id);
           $comments= Comment::where('recette_id' , $recette->id )->get() ;
           $rating = 0 ;
          foreach ($comments as $comment) {
             $rating += $comment->rating  ; 
          }
          if($rating >0){
            $rating =  $rating/count( $comments) ;
           }
        array_push($Recipes, ['recette' =>$recette, 'userName' => $user->name , 'rating' =>  $rating]);
     
    }
    return response()->json(['success' => $Recipes    ], 200);
    }
    
    public function FilterRecette($frigo_id)
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
            //    return  $ProductIdRecette ;
            array_push($TableRecettes, ['recette_id' => $Recette->id, 'products_id' => $ProductIdRecette]);
        }
        // return response()->json( $ProductIdRecette );
        $frigo = Frigo::findOrFail($frigo_id);
        $AllProductFrigo =    $frigo->products->all();
        $ProductIdFrigo = [];
        foreach ($AllProductFrigo as $product) {
            array_push($ProductIdFrigo, $product->pivot->product_id);
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
                } else {
                    array_push($ProductDontExist, $TableRecettes[$i]['products_id'][$j]);
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

            if (count($ProductDontExist) <= 4) {
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
        $RecipesFilter = [];
        foreach ($RecettesId as $recette) {
            $recette_id =  $recette['recette_id'];
            $Recette = Recette::find($recette_id);
            
            $user_id = $Recette->user_id;
            $user = User::find($user_id);
            $comments= Comment::where('recette_id' ,  $recette_id)->get() ;
            $rating = 0 ;
           foreach ($comments as $comment) {
              $rating += $comment->rating  ; 
           }
           if($rating >0){
            $rating =  $rating/count( $comments) ;
           }
            array_push($RecipesFilter, [
                'recette' => $Recette, 'userName' => $user->name, 'rating' =>  $rating ,
                'ProductNameDontExist' =>  $recette['ProductNameDontExist']
            ]);
        }
        return response()->json(['success' => $RecipesFilter], 200);
    }


    public function show($id)
    {
        $recette  = Recette::find($id);
        // $products  = [] ;
        $recette->products->all();
        $description = $recette->description;
        // dd($description) ;
        $Posistion = [];
        $Etapes = [];

        for ($i = 1; $i < 4; $i++) {
            $pos =   strpos($description,  "Etape {$i}");
            if ($pos !== false) {
                array_push($Posistion, $pos);
            }
            // dd($pos) ;
        }
        // return ($Posistion) ;
        if (isset($Posistion[0]) && isset($Posistion[1])) {
            $Etape1 = substr($description, $Posistion[0] + 7, $Posistion[1] -  $Posistion[0] - 7);
        } elseif (isset($Posistion[0])) {
            $Etape1 = substr($description, $Posistion[0] + 7);
        } else {
            $Etape1 = '';
        }
        if (isset($Posistion[1]) &&  isset($Posistion[2])) {
            $Etape2 = substr($description, $Posistion[1] + 7, $Posistion[2] -  $Posistion[1] - 7);
        } elseif (isset($Posistion[1])) {
            $Etape2 = substr($description, $Posistion[1] + 7);
        } else {
            $Etape2 = '';
        }
        if (isset($Posistion[2])) {
            $Etape3 = substr($description, $Posistion[2] + 7);
        } else {
            $Etape3 = '';
        }

        $Etapes = [
            'Etape1' => $Etape1,
            'Etape2' =>  $Etape2,
            'Etape3' => $Etape3
        ];

        $user_id = $recette->user_id;
        $user = User::find($user_id);
        $UserName = $user->name;
        return [$recette, $Etapes, $UserName];
        // return response()->json(['success' =>  $recette , 'Etapes' => $Etapes ] , 200 );
    }
    // 


    public function store(Request $request)
    {

        $recette_name = $request->get('name');
        $description = $request->get('description');
        $number = $request->get('number');
        $time = $request->get('time');
        $category_id = $request->get('category_id');
        $user_id = $request->get('user_id');


        $category = Categoryrecette::findOrFail($category_id);

        $file = $request->file('image');
        $ext = $file->extension();
        $fileName = Carbon::now()->format('d-m-Y') . '-' . Str::random(10) . '.' . $ext;
        $request->file('image')->move(public_path("/img/"), $fileName);
        // return('tst') ;
        // dd(Auth::user());
        // $recette =      Recette::create([
        $recette = new Recette([
            // ' number_person' => $number,
            'name' => $recette_name,
            'description' =>  $description,
            'image' => 'img/' . $fileName,
            'cook_time' => $time,
            'number_person' => $number,
            'category_id' =>    $category_id,
            'user_id' => Auth::user()->id
        ]);
        // $recette =  Recette::create($request->all());

        $category->recettes()->save($recette);
        // ]) ;
        // return auth()->guard('api')->user();

        return [$recette];
    }

    //     public function show(Request $request ){
    // $recette_id = $request->get('recette_id');
    // $recette = Recette::find($recette_id );
    //         return $recette ;
    //     }



    public function update(Request $request, $id)
    {
        $recette = Recette::findOrFail($id);
        $recette->update($request->all());
        return $recette;
    }



    public function search(Request $request)
    {
        $q = $request->get('word');
        $Recettes = Recette::where('name', 'LIKE', '%' . $q . '%')
            ->orWhere('description', 'LIKE', '%' . $q . '%')->get();
        $Recipes = [];
        foreach ($Recettes as $recette) {
            $user_id = $recette->user_id;
            $user = User::find($user_id);

            // array_push($Recipes, ['id' => $recette->id, 'userName' => $user->name, 'recipeName' =>  $recette->name, 'person' => $recette->number_person, 'image' => $recette->image]);
            array_push($Recipes, ['recette' =>$recette, 'userName' => $user->name]);
     
        }
        return response()->json(['success' => $Recipes    ], 200);
    
    }
    

    public function destroy($id )
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
