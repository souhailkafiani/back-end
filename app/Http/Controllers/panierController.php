<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\command;
use App\Products;
use App\User;
use App\listOfCommands;
use Illuminate\Support\Facades\DB;

class panierController extends Controller
{
    function saveCommands(Request $request)
    {
        $com = new command;
        $com->idUser = $request->idUser;
        $com->fullname	 = $request->fullname	;
        $com->email = $request->email;
        $com->numero = $request->numero;
        $com->address = $request->address;
        $com->city = $request->city;
        $com->country = $request->country;
        $com->paymentWay = $request->paymentWay;
        $com->total = $request->total;
        $com->status = false;

        $com->save();
        return $com->id;
    }

    function saveLineCommand(Request $request)
    {
       
        $line = new listOfCommands;
        $line->idCommand = $request->idCommand;
        $line->idProduct= $request->idProduct	;
        $line->quantity = $request->quantity;
        $line->status = false;
        $line->save();
       return $line;
    }
    function getCommands($idUser)
    {
        $commands = command::where('idUser', $idUser)->cursor();
        return $commands;
    }

    function getCommandsForAdmin()
    {
        $commands = command::All();
        return $commands;
    }

    function getCommandsLines($id)
    {
        $commands = listOfCommands::where('idCommand', $id)->cursor();
        return $commands;
    }
    
    function getThisProduct($id)
    {
        $pro = Products::where('id', $id)->first();
        return $pro;
    }

    function getUserId($email)
    {
        $userId = User::where('email', $email)->first()->id;
        return $userId;
    }

    function getQuantity($id)
    {
        $quan = Products::where('id', $id)->first()->quantity;
        return $quan;
    }
    function reduceQuantity(Request $request)
    {
        DB::table('products')
        ->where('id', $request->id)
        ->update(['quantity'=>$request->quantity]);
    }

    function changeStatus(Request $request)
    {
        DB::table('commands')
        ->where('id', $request->id)
        ->update(['status'=>true]);

        DB::table('listofcommands')
        ->where('idCommand', $request->id)
        ->update(['status'=>true]);

    }

    function removeCommand($id)
    {
        command::where('id', $id)->delete();
        listOfCommands::where('idCommand', $id)->delete();

    }

    
}
