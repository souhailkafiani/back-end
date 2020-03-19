<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ImageController extends Controller
{

  
        
        use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
        public function uploadimage(Request $request)
        {
          //dd($request->all());
          if ($request->hasFile('image'))
          {
                $file      = $request->file('image');
                $filename  = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $picture   = date('His').'-'.$filename;
                $file->move('C:\Users\souhail kafiani\Desktop\navbarXS\src\assets\images',$file->getClientOriginalName());
                return response()->json(["message" => "Image Uploaded Succesfully and ".$file->getClientOriginalName()]);
          } 
          else
          {
                return response()->json(["message" => "Select image first."]);
          }
        }

}
