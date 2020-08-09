<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recette extends Model
{
  protected $fillable = ['name' , 'description' ,'cook_time','image', 'number_person' ,'user_id' ] ;

  public function products()
  {

      return $this->belongsToMany('App\Product',  'products_recettes', 'recette_id', 'product_id') 
      ->withPivot('quantity','type')
    	->withTimestamps();
      
  }

  public function categoriesrecette()
  {
    return $this->belongsTo('App\Categoryrecette', 'category_id');
  }

  public function user(){
    return $this->belongsTo('App\User');
 }
 public function comments()
 { 
      return $this->hasMany('App\Comment' )  ; 
 }
}
