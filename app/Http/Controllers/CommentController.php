<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Recette;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
      $recette = Recette::find($id) ;
      $comments = $recette->comments->all() ;
      $commentaires = [];
      foreach ($comments as $comment ) {
        $user =  User::find($comment->user_id) ;

      array_push($commentaires,
       [ 'id' =>   $comment->id ,
       'comment' => $comment->comment,
       'rating' => $comment->rating , 
       'user_id' =>  $user->id ,
       'avatar' => $user->avatar ,
       'name' =>  $user->name ,
       'date' => $comment->created_at->diffForHumans()]);
      }
      return  $commentaires  ;
   }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $comment = $request->get('comment');
        $rating= $request->get('rating');
        $recette_id = $request->get('recette_id');
 
        $Comment = Comment::create([ 
            'comment' =>$comment,
            'rating' =>$rating,
             'user_id' => Auth::user()->id,
             'recette_id' => $id 
        ]);
       return $Comment ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
         
        $comment = Comment::where( 'id', $id)->get();
        return  $comment ; 
    }

    
    public function update(Request $request, $id)
    {   
        $comment = Comment::findOrFail($id); 
     $comment->comment = $request->get('comment');
   $request->get('comment') ; 
       $comment->update($request->all());
     return $comment ;
    }
 

    public function destroy($id)
    {
        // Auth::user()->id
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return 204;
    }
}
