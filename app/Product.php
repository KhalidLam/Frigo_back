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
      return $this->belongsToMany(Frigo::class);
    }

}
