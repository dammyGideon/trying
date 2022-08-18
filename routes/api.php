<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Children\ChildrenController;


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


Route::post('/parentReg',[AuthController::class,'parentReg']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/forgot_password',[AuthController::class,'forgot_password']);
Route::post('/reset_password',[AuthController::class,'reset_password']);




Route::group(["middleware" => "auth:api"], function() {

    //authenticated super_admin
    Route::group(["middleware"=>'role:parent'], function (){

        Route::get('/authenticatedUser',[AuthController::class,'authenticatedUser']);
        Route::post('/childrenReg',[ChildrenController::class,'childrenReg']);
        Route::get('/parentChildren',[ChildrenController::class,'parentChildren']);
        Route::get('/singleChild/{id}',[ChildrenController::class,'singleChild']);

    });

    //authenticated admin
    Route::group(['middleware'=>'role:admin'], function (){


    });

    //authenticated client
    Route::group(['middleware'=>'role:client'], function (){

    });




    Route::middleware('')->group(function(){

    });

});


