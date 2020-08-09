<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liste extends Model
{
    protected $fillable = [   'product_id'  , 'user_id'  , 'quantity'  , 'type' ] ;

    public function products()
    { 
         return $this->hasMany('App\Product' )  ; 
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

    
}
