<?php

namespace App\Http\Controllers;
use App\Http\Requests\phoneRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
class SendSMSController extends Controller
{
    public function sendSMS(phoneRequest $req)
    {

 $basic  = new \Nexmo\Client\Credentials\Basic('57a3c2f7', '2CaTiSLebmqRBTtX');
$client = new \Nexmo\Client($basic);
$phone_num = $req->code.$req->phone;
$code = Str::random(4);
$message = $client->message()->send([
    'to' => $phone_num,
    'from' => 'Nexmo',
    'text' => 'votre code est '.$code
]);
return response()->json(['code'=>$code],Response::HTTP_OK);



        
    }
}