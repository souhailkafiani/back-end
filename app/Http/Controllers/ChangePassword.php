<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ChangePasswordRequest;
use Symfony\Component\HttpFoundation\Response;

class ChangePassword extends Controller
{
  public function change(ChangePasswordRequest $request){
    return $this->verifier_user_if_exists($request)->get();
  }

}
/*return $this->verifier_user_if_exists($request)->count()>0 ? 
$this->changePassword($request) : $this->responseError();

  }
  private function  verifier_user_if_exists($request){
      return DB::table('password_resets'->where('email',$request->email,'token',$request->token));
  }
  private function changePassword($request){
      $user = User::where('email',$request->email)->first();
      $user->update(['password'=>$request->password]);
      $this->verifier_user_if_exists($request)->delete();
      return response()->json(['ok',"password successfully changed"],
      Response::HTTP_CREATED
  );
  }

  private function responseError(){
      return response()->json(['error'=>'Token or Email is incorrect'],
      Response::HTTP_UNPROCESSABLE_ENTITY
  );
  }*/
