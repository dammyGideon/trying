<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateUsersRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\loginRequest;
use App\Http\Requests\Auth\parent_regRequest;
use App\Repositories\Auth\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class Authentication extends Controller
{


    public function parentReg(parent_regRequest $request, UserRepository $userRepository){
        return $userRepository->parent_reg($request);
    }

    public function login(loginRequest $request, UserRepository $userRepository){
        return $userRepository->authenticateUser($request);
    }

    public function forgot_password(Request $request, UserRepository $userRepository){
        $email=$request->validate([
            "email"=>'required|string'
        ]);
        if(!$email){
            return[
                "message"=>"email could not been found"
            ];
        }

        return $userRepository->forgot_password($request);
    }

    public function reset_password(Request $request,UserRepository $userRepository){

        $request->validate([
            'email'=>['required'],
            'password'=>['required'],
            'password_confirmation'=>['required'],
            'token'=>['required']
        ]);

        return $userRepository->reset_password($request);
    }

    public function authenticatedUser(UserRepository $userRepository){
        return $userRepository->singleUser();
    }

    public function profileImage(Request $request, UserRepository $userRepository){
        $image=$request->validate([
            "image"=>'required|mimes:jpeg,png,jpg,gif'
        ]);
        if(!$image){
            return[
                "message"=>"please upload image"
            ];
        }

        return $userRepository->profilePicture($request);
    }
}
