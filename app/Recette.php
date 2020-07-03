<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recette extends Model
{
  protected $fillable = ['name' ] ;

  public function products()
  {

      return $this->belongsToMany('App\Product',  'products_recettes', 'recette_id', 'product_id');
      
  }

  public function categoriesrecette()
  {
    return $this->belongsTo('App\Categoryrecette');
  }
}
