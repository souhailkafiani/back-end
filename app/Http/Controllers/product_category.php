<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Http\Requests\categoryRequest;
use  App\Http\Requests\productRequest;
use  App\Http\Requests\update_category_Request;
use  App\Http\Requests\update_product_Request;

use App\Categories;
use App\Products;
class product_category extends Controller
{
    function storeCategory(categoryRequest $request)
    {

        $cat = new Categories;
        $cat->name = $request->name;
        $cat->description = $request->description;
        $cat->save();
       
    }

    function storeProduct(productRequest $request)
    {

        /*$pro = new Products;
        $pro->name = $request->name;
        $pro->description = $request->description;
        $pro->category = $request->category;
        $pro->color = $request->color;
        $pro->quantity = $request->quantity;
        $pro->save();*/
        $data = Products::where('name',$request->name)->where('description',$request->description)->count();
        if($data>=1){
            return response()->json(['error'=>"Name and  Description has already exist"],404);
        }
        Products::create($request->all());
       
    }

    

    public function getCategories()
    {
        $allCategories = Categories::all();
        return $allCategories;
    }
    public function deleteCategorie($id)
    {
        $data = Categories::find($id);
        if($data){
            Products::where('category',$data->first()->name)->delete();
            $data->delete();
           
            return response()->json(["data"=>'success']);
        }
        return response()->json(['error'=>'Categorie Not Found'],404);
    }
    public function deleteProduct($id)
    {
        $data = Products::find($id);
        if($data){
            $data->delete();
            return response()->json(["data"=>'success']);
        }
        return response()->json(['error'=>'Product Not Found'],404);
    }
    public function updateProduct(update_product_Request $request,$id)
    {
        $data = Products::find($id);
        if($data){
            $count = Products::where('name',$request->name)->count();
            if($count==0){
            $data->update($request->all());
            $data->update(['is_send'=>0]);
            return response()->json(["data"=>'success']);
            }
            if($count==1 && Products::where('name',$request->name)->get('id')[0]->id==$id){
                $data->update($request->all());
                $data->update(['is_send'=>0]);
                return response()->json(["data"=>'success']);
            }
            return response()->json(['error'=>'The name has laready Taken'],404);
        }
        return response()->json(['error'=>'Product Not Found'],404);
    }
    public function updateCategorie(update_category_Request $request,$id)
    {
        $data= Categories::find($id);
        
        
        if($data){
            $count = Categories::where('name',$request->name)->count();
            if($count==0){
            $data->update($request->all());
            return response()->json(["data"=>'success']);
            }
            $id2 = Categories::where('name',$request->name)->get('id');
            if($count==1 &&  $id2[0]->id==$id){
                $data->update($request->all());
                return response()->json(["data"=>'success']);
            }
            else{
                return response()->json(['error'=>'Categorie Name has already taken'],404);
            }
        }
        return response()->json(['error'=>'Categorie Not Found'],404);
    }
    public function getProducts()
    {
   if(Products::all()->count()>9){
        $all = Products::get('id');
        $taille_table = sizeof($all);
        $which_id = $this->random_id($taille_table);
        $data_id = [];
       for($i=0;$i<sizeof($which_id);$i++){
$data_id[$i]=$all[$which_id[$i]]->id;
       }
      return  response()->json(["data"=>Products::whereIn('id',$data_id)->get()]);
    }
    else{
        return   response()->json(["data"=>Products::all()]);
      
    }

    }
    public function random_id($tab){
$all = [];
$rand_tab ;
for($i=0;$i<9;$i++){
    $rand_tab  = $this->get_rand($tab-1);
    if(in_array($rand_tab,$all)){$i--;}
    else {
        $all[$i]= $rand_tab;
    }
}
return $all;
    }
    public function get_rand($max){
        return  rand(0,$max);
    }
    public function allProducts(){
        return Products::all();
    }
    public function which_categorie($name){
$data= Products::where('category',$name)->get();
return response()->json(['data'=>$data]);
    }
    public function get_product_by_id($id){
        $name_of_categorie = Categories::where('id',$id)->first();
        if($name_of_categorie){
    
         $data = Products::where('category',$name_of_categorie->name)->get();
         return response()->json(['data'=>$data]);
        }
        else return response()->json(['error'=>null],404);

    }
    public function product_like($id,$name){
        if($name==''){return "hi";}
        if($name==null){return "hi null";}

        $name_of_categorie = Categories::where('id',$id)->first();  
$data = Products::where("category",$name_of_categorie->name)->where('name','like','%'.$name.'%')->get();
return response()->json(['data'=>$data]);
    }
    public function get_product($id){
        $data = Products::where('id',$id)->first();
        $similaire_product = Products::where('category',$data->category)->where('id','!=',$id)->take(9)->get();
        return response()->json(['data'=>$data,'products'=>$similaire_product]);
    }
    public function product_quantite(){
        $data = Products::where('quantity','<=',20)->get(['id','name']);
        if(!$data) {$data=[];}
        return response()->json(["data"=>$data]);
    }
    public function product_quantite_count(){
        $data = Products::where('quantity','<=',20)->count();
        
        return response()->json(["data"=>$data]);
    }
}
