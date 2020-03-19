<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use \Carbon\Carbon;

use App\Mail\ResetpasswordMail;
class ResetPassword extends Controller
{
    public function sendEmail(Request $request){
        if(!$this->validateEmail($request->email)){
            return $this->responseFailed();
        }
      
   $this->send($request->email);
    return $this->successResponse();
  
    }
    public function validateEmail($email){
      $data =   User::where("email",$email)->count();
    
        if($data) return true;
        return false;
    }
    public function send($all){
   
        $to_name = "souhail kafiani";
        $to_email = $all;
        $url = "http://localhost:4200/response-reset-password?token=";
        $key = $this->createToken($all);
        
      

        
        $data = array("name"=>"Admin","body"=>"Veuillez cliquer sur ce lien pour changer votre mot passe","url"=>$url.$key);
        \Mail::send('mail',$data,function($message) use ($to_name,$to_email){
            $message->to($to_email)
            ->subject('Changer le mot-passe');
        } );
    }
    public function responseFailed(){
        return response()->json(["error"=>"email not existe"],401);

    
}

    
    public function successResponse(){
        return response()->json(["ok"=>"email was send success"]
        ,
        Response::HTTP_OK
        );
    }
    
    public function createToken($email){
        $oldToken = DB::table('password_resets')->where("email",$email)->first();
        if($oldToken){
            return $oldToken->token;
        }


        $token = Str::random(60);
        $this->saveToken($token,$email);
        return $token;
    }
    public function saveToken($token,$email){
DB::table('password_resets')->insert([
    "email" => $email,
    "token" => $token,
    "created_at"=>Carbon::now()
]);
    }

}
