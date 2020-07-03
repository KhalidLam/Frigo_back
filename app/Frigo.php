<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Frigo extends Model
{

    protected $fillable = [
        'name'
    ];
    public function products()
    {

        return $this->belongsToMany(Product::class,  'product_frigo', 'frigo_id' , 'product_id')
        ->withPivot('quantity','type')
    	->withTimestamps();
    }

    public function  user()
    {
        return $this->belongsTo('App\User');
    }
}
