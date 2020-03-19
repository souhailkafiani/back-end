<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;
use App\facebooks;
use App\Googles;
use App\Http\Requests\updateRequest;
use App\Http\Requests\registerRequest;
use App\Http\Requests\socialRequuest;
use App\Http\Requests\googleRequest;
use Illuminate\Http\Request;
use App\Http\Requests\adminRequest;
use App\Http\Requests\updateAdminRequest;
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register',
        'register_social','register_social_google','get_data',
        'update_table_DB','update_table_facebook','update_table_google',
        'create_admin','deleteAdmin','get_admin','update_admin',
        'isAdmin'
        ]]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Email or Password not correct!'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'User' => auth()->user()->name
        ]);
    }

public function register(registerRequest $request){

    User::create($request->all());
   return  $this->login($request);
}
public function register_social(socialRequuest $request){
    $data = facebooks::all()->where("email",$request->email)->count();
    if($data<=0){
facebooks::create($request->all());
return  response()->json(["data"=>"sucess"]);
}
}
public function register_social_google(googleRequest $request){
    $data = googles::all()->where("id_facebook",$request->id_facebook)->count();
    if($data<=0){
Googles::create($request->all());
return  response()->json(["data"=>"sucess"]);
}
}
public function get_data($id,$from){
    if($from=="google"){
     $data = facebooks::all()->where('id_google',$id)->count();
     if($data>0) return response()->json(["data"=>facebooks::where('id_google',$id)->get()]);
     return response()->json(["error"=>"non trouver"]);
    }
if($from=="facebook"){
    $data = googles::all()->where('id_facebook',$id)->count();
    if($data>0) return response()->json(["data"=>googles::where('id_facebook',$id)->get()]); 
    return response()->json(["error"=>"non trouver"]);
}
else{
    $data = User::all()->where("email",$id)->count();
    if($data>0){
        return response()->json(["data"=>User::where("email",$id)->get()]);
    }
    return response()->json(["error"=>"non trouver"]);
}


}

public function update_table_google(updateRequest $request ,$id){

   
    $all = facebooks::where("email",$request->email)->count();
    if($all==0){
        
        $data = facebooks::where("id_google",$id)->update([
            "first_name"=>$request->first_name,
            'email'=>$request->email,
            'last_name'=>$request->last_name,
            'phone'=>$request->phone,
            'city'=>$request->city,
            'address'=>$request->address
            ]);
    return response()->json(['data'=>$data]);
        }
    $em = facebooks::where("id_google",$id)->get("email");
    if($all==1 && $request->email==$em[0]->email ){
        $data = facebooks::where("id_google",$id)->update([
            "first_name"=>$request->first_name,
            'email'=>$request->email,
            'last_name'=>$request->last_name,
            'phone'=>$request->phone,
            'city'=>$request->city,
            'address'=>$request->address
            ]);
    return response()->json(['data'=>$data]);
    }
    return response()->json(["error"=>"email has already been taken"],404);



}
public function update_table_facebook(updateRequest $request ,$id){


    $all = googles::where("email",$request->email)->count();
    if($all==0){
        
        $data = googles::where("id_facebook",$id)->update([
            "first_name"=>$request->first_name,
            'email'=>$request->email,
            'last_name'=>$request->last_name,
            'phone'=>$request->phone,
            'city'=>$request->city,
            'address'=>$request->address
            ]);
    return response()->json(['data'=>$data]);
        }
    $em = googles::where("id_facebook",$id)->get("email");
    if($all==1 && $request->email==$em[0]->email ){
        $data = googles::where("id_facebook",$id)->update([
            "first_name"=>$request->first_name,
            'email'=>$request->email,
            'last_name'=>$request->last_name,
            'phone'=>$request->phone,
            'city'=>$request->city,
            'address'=>$request->address
            ]);
    return response()->json(['data'=>$data]);
    }
    return response()->json(["error"=>"email has already been taken"],404);
    




}
public function update_table_DB(updateRequest $request ,$id){

$all = User::where("email",$request->email)->count();
if($all==0){
    $data = User::where("email",$id)->update([
        "first_name"=>$request->first_name,
        'email'=>$request->email,
        'last_name'=>$request->last_name,
        'phone'=>$request->phone,
        'city'=>$request->city,
        'address'=>$request->address
        ]);
return response()->json(['data'=>$data]);
    }

if($all==1 && $request->email==$id){
    $data = User::where("email",$id)->update([
        "first_name"=>$request->first_name,
        'email'=>$request->email,
        'last_name'=>$request->last_name,
        'phone'=>$request->phone,
        'city'=>$request->city,
        'address'=>$request->address
        ]);
return response()->json(['data'=>$data]);
}
return response()->json(["error"=>"email has already been taken"],404);

}
public function  create_admin(adminRequest $request){
    User::create($request->all());
}
        public function  get_admin(){
           return  User::where('isAdmin','!=',null)->get(); 
        }
public function  update_admin($id,updateAdminRequest $request){
    
                  $data = User::find($id);
                  if($data){
                      $count = User::where('email',$request->email)->count();
                      if($count==0){
                      $data->update($request->all());
                      return response()->json(["data"=>'success']);
                      }
                      if($count==1 && User::where('email',$request->email)->get('id')[0]->id==$id){
                          $data->update($request->all());
                          return response()->json(["data"=>'success']);
                      }
                      return response()->json(['error'=>'The email has laready Taken'],404);
                  }
                  return response()->json(['error'=>'Email Not Found'],404);
    
                    
                        }
      public function deleteAdmin($id) 
        {
            $data = User::find($id);
            if($data){
                $data->delete();
                return response()->json(["data"=>'success']);
            }
            return response()->json(['error'=>'Admin Not Found'],404);
        }
        public function isAdmin($email){
            $data = User::where('email',$email)->get(['isAdmin','super_admin']);
            return response()->json(['data'=>$data]);
        }


}