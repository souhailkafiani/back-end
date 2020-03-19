<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class command extends Model
{
    protected $filable = [

'idUser','fullname','email','numero','address','city','country','paymentWay'
    ];
    protected $table = "commands";
    
}
