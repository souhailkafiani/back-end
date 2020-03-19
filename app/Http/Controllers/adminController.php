<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admins;
use App\Http\Requests\adminRequest;
use App\Http\Requests\updateAdminRequest;
use App\Http\Requests\loginAddminRequest;
use Illuminate\Support\Facades\Crypt;
class adminController extends Controller
{
   public function  create_admin(adminRequest $request){
Admins::create($request->all());

    }
    public function  get_admin(){
       return  Admins::all();
        
            }
            public function  update_admin($id,updateAdminRequest $request){

              /*Admins::where('id',$id)
              ->update($request->all())
              ;*/

              $data = Admins::find($id);
              if($data){
                  $count = Admins::where('email',$request->email)->count();
                  if($count==0){
                  $data->update($request->all());
                  return response()->json(["data"=>'success']);
                  }
                  if($count==1 && Admins::where('email',$request->email)->get('id')[0]->id==$id){
                      $data->update($request->all());
                      return response()->json(["data"=>'success']);
                  }
                  return response()->json(['error'=>'The email has laready Taken'],404);
              }
              return response()->json(['error'=>'Email Not Found'],404);

                
                    }
  public function deleteAdmin($id)
    {
        $data = Admins::find($id);
        if($data){
            $data->delete();
            return response()->json(["data"=>'success']);
        }
        return response()->json(['error'=>'Admin Not Found'],404);
    }
    public function login(loginAddminRequest $request){
        $pass = Crypt::encryptString($request->password);
      $data =   Admins::all()
      ->where('password',$pass)
      ->count();
 
       return response()->json(['password exist'=>$pass]);
      
      
      if($data==1){return response()->json(['data'=>'success']);}
      else return response()->json(['error'=>'Email or Password not correct'],404);
    }
}
