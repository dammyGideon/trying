<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => 'VerifyAPIKey'], function () {
    Route::get('/welcome', function(){
        return "okay";
    });
});




