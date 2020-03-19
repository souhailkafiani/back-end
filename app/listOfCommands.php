<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class listOfCommands extends Model
{
    protected $filable = [

        'idCommand','idProduct','quantity'
            ];
            protected $table = "listOfCommands";
}
