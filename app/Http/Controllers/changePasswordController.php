<?php

namespace App\Http\Controllers;
use App\Http\Requests\ChangePasswordRequest;
use App\User;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;


class changePasswordController extends Controller
{
    public function change(ChangePasswordRequest $request){
        return $this->verifier_user_if_exists($request)->count()>0 ? 
      $this->changePassword($request) : $this->responseError();
     
      
 
      }

      private function  verifier_user_if_exists($request){
        return DB::table('password_resets')->where('email',$request->email)->where('token',$request->token);
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
        }

}
