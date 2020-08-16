<?php

namespace App\Http\Controllers;

use App\Recette;
use App\User;
use Illuminate\Http\Request;


class FavorisController extends Controller
{
    public function index(Request $request){
$recettes_id = $request->get('recettes_id') ;
  $Recipes = [] ;
foreach (json_decode($recettes_id)as $item) {

$recette = Recette::find($item) ;
$user_id = $recette->user_id; 
$user = User::find($user_id); 

// $comments= Comment::where('recette_id' , $item)->get() ;
// $rating = 0 ;
// foreach ($comments as $comment) {
//   $rating += $comment->rating  ; 
// }
// $rating =  $rating /count( $comments) ;
array_push($Recipes, ['recette' =>$recette, 'userName' => $user->name ,'rating' =>  '$rating ' ]);

}
return response()->json(['success' => $Recipes    ], 200);
}


}