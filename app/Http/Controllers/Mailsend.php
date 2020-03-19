<?php

namespace App\Http\Controllers;
use \App\Mail\SendMail;
use Illuminate\Http\Request;

class Mailsend extends Controller
{
   
   public function mailsend(){
    /*$details = [
        'title' => 'Title Mail from KEBEF ',
        'body'  =>  'Body this is for trsting our applioca'
    ];
    \Mail::to('souhailkafiani2@gmail.com')->send(new SendMail($details));
    return view('emails.thanks');*/
   }  
}
