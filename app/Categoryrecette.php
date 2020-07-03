<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoryrecette extends Model
{
    public function recettes()
    {
        return $this->hasMany('App\Recette');
    }
}
