<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Googles extends Model
{
 


   

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'email', 'password',
        'address','city','phone','id_facebook'
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
    
}
