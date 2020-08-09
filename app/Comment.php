<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [ 'comment' , 'rating' , 'user_id' , 'recette_id'] ;

    public function recette(){
    return $this->belongsTo('App\Recette');
 }
}
