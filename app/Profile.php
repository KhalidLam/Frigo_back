<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    // protected $fillable = [
    //     'prenom', 'nom', 'age','sexe' , 'taille' , 'membre_date'
    // ];
    protected $guarded = [] ;
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
