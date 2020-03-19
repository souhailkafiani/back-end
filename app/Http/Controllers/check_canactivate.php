<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;

class check_canactivate extends Controller
{
 public function    if_user($email){
    $count = User::where('email',$email)->where('isAdmin',null)->where('super_admin',null)->count();
     if($count>0){return response()->json(['data'=>'user']);}
     $count = User::where('email',$email)->where('isAdmin','1')->where('super_admin',null)->count();
     if($count>0){return response()->json(['data'=>'admin']);}
     $count = User::where('email',$email)->where('isAdmin',null)->where('super_admin','oui')->count();
    if($count>0){return response()->json(['data'=>'super-admin']);}
 }
 

}
