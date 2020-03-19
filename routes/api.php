<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([

    'middleware' => 'api'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('register', 'AuthController@register');
    Route::post('resetPassword','ResetPassword@sendEmail');
    Route::post('changepassword','changePasswordController@change');
    Route::post('registerSocial','AuthController@register_social');
    Route::post('registerSocial_google','AuthController@register_social_google');
    Route::post('update_table_google/{id}','AuthController@update_table_google');
    Route::post('update_table_facebook/{id}','AuthController@update_table_facebook');
    Route::post('update_table_DB/{id}','AuthController@update_table_DB');
    Route::get('getData/{id}&{from}','AuthController@get_data');
    Route::post('create_admin','AuthController@create_admin');
    Route::get('isAdmin/{email}','AuthController@isAdmin');
    Route::get('get_admin','AuthController@get_admin');
    Route::post('login_admin','AuthController@login');
    Route::post('update_admin/{id}','AuthController@update_admin');
    Route::delete('deleteAdmin/{id}','AuthController@deleteAdmin');
    Route::post('/send-sms',['as'=>'send.sms','uses'=>'SendSMSController@sendSMS']);
    Route::post('createCategory', 'product_category@storeCategory');
    Route::post('createProduct', 'product_category@storeProduct');
    Route::get('products', 'product_category@getProducts');
    Route::get('get_products', 'product_category@allProducts');
    Route::get('categories', 'product_category@getCategories');
    Route::delete('deleteCategorie/{id}', 'product_category@deleteCategorie');
    Route::delete('deleteProduct/{id}', 'product_category@deleteProduct');
    Route::post('updateProduct/{id}', 'product_category@updateProduct');
    Route::post('updateCategorie/{id}','product_category@updateCategorie');
    Route::post("upload" , "ImageController@uploadimage");
    Route::get('which_categorie/{name}','product_category@which_categorie');
    Route::get('which_categorie_by_id/{id}','product_category@get_product_by_id');
    Route::get('product_like/{id}/{name}','product_category@product_like');
    Route::get('get_product/{id}','product_category@get_product');
    /*   siùo                    */
    Route::post('saveCommands', 'panierController@saveCommands');
    Route::post('saveLineCommand', 'panierController@saveLineCommand');
    Route::get('getCommands/{idUser}', 'panierController@getCommands');
    Route::get('getCommandsForAdmin', 'panierController@getCommandsForAdmin');    
    Route::get('getCommandsLines/{id}', 'panierController@getCommandsLines');
    Route::get('getThisProduct/{id}', 'panierController@getThisProduct');
    Route::get('getUserId/{email}', 'panierController@getUserId');
    Route::get('getQuantity/{id}', 'panierController@getQuantity');
    Route::post('reduceQuantity', 'panierController@reduceQuantity');
    Route::post('changeStatus', 'panierController@changeStatus');
    Route::get('product_quantite','product_category@product_quantite');
    Route::get('product_quantite_count','product_category@product_quantite_count');
    Route::get('send_notify_admin/{all}','notify_admin@send');

    Route::get('execute-payment', 'paypalController@execute');
    
    Route::get('removeCommand/{id}', 'panierController@removeCommand');
    Route::get('if_user/{email}','check_canactivate@if_user');
 Route::get('if_admin/{email}','check_canactivate@if_admin');
    Route::get('if_super_admin/{email}','check_canactivate@if_super_admin');





});
