<?php

namespace App\Http\Controllers;
use App\Categories;
use App\Products;
use Illuminate\Http\Request;

class notify_admin extends Controller
{
    public function send($all){
   $nbr = Products::where('quantity','<=',20)->where('is_send',0)->count();
   if ($nbr>0){
        Products::where('quantity','<=',20)->where('is_send',0)
       ->update(['is_send'=>1]);
       
        $to_name = "souhail kafiani";
        $to_email = $all;
        
      

        
        $data = array("name"=>"Admin","body"=>"Veuillez augmenter la quantite de quelques produits");
        \Mail::send('mail_notify_admin',$data,function($message) use ($to_name,$to_email){
            $message->to($to_email)
            ->subject('Alerte du Stock');
        } );
    }
    }
}
