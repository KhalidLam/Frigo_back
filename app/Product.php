<?php

namespace App;
use App\Frigo;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name'
    ];
    public function categories()
    {
      return $this->belongsTo('App\Category');
    }

    public function frigos()
    {
      return $this->belongsToMany(Frigo::class ) ;
      // ->withPivot('stock')     
      // ->withTimestamps();
    }

    public function recettes()
    {
      return $this->belongsToMany('App\Recette');
    } 

    public function liste()
    {
        return $this->belongsTo('App\Liste');
    }
 

}
