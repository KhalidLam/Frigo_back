<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
class User extends \TCG\Voyager\Models\User
{
    use Notifiable , HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // to create profile with user we can use function boot or create it in   regisrtercontroller   
    protected static function boot() {
        parent::boot() ; 
        static::created(function($user){
         $data = $user->profile()->create([
                'prenom'=> $user->name ,
      'description' =>'description'.$user1-> email
            ]);
        }); }

    public function frigo()
    {
        return $this->hasOne('App\Frigo');
    }
 
    public function liste()
    {
        return $this->belongsTo('App\Liste');
    }
    
    public function recettes(){
        return $this->hasMany('App\Recette');
    
      }
 
      public function profile()
      {
          return $this->hasOne('App\Profile');
      }
}
