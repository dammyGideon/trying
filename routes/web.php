<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\HomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/test', function (){
    return "hello worked";
});
Route::get('send-mail', function () {

    $details = [
        'title' => 'Mail from synetoss.com',
        'body' => 'This is for testing email using smtp'
    ];

    Mail::to('ajayegidolas@gmail.com')->send(new \App\Mail\MyTestMail($details));

    dd("Email is Sent.");
});

Auth::routes();

Route::group(["middleware" => "auth:web"], function() {

    Route::group(['middleware'=>'role:parent'], function (){

        Route::get('/home', [HomeController::class, 'index'])->name('home');
    });

    Route::group(['middleware'=>'role:provider'], function (){

        Route::get('/home', [HomeController::class, 'index'])->name('home');
    });
    Route::group(['middleware'=>'role:admin'], function (){

        Route::get('/home', [HomeController::class, 'index'])->name('home');
    });

    

  
});

