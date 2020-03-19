<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'name', 'description','category', 'color','quantity',
        'marque', 'new_price' ,'last_price' ,'promotion' ,'Poids',
        'images','is_send'
    ];

}
