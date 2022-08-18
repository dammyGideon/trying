<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\loginRequest;
use App\Http\Requests\Auth\parent_regRequest;
use Illuminate\Http\Request;
use App\Repositories\Auth\UserRepository;

class AuthController extends Controller
{
    //
    public function parentReg(parent_regRequest $request, UserRepository $userRepository){
        return $userRepository->parent_reg($request);
    }
    public function login(loginRequest $request, UserRepository $userRepository){
        return $userRepository->authenticateUser($request);
    }
    public function forgot_password(Request $request, UserRepository $userRepository){
        $request->validate([
            'email'=>'required'
        ]);
        return $userRepository->forgot_password($request);
    }

    public function reset_password(Request $request, UserRepository $userRepository){
        return $userRepository->reset_password($request);
    }
    public function authenticatedUser(UserRepository $userRepository){
        return $userRepository->singleUser();
    }
}
