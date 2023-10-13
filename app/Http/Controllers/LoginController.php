<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){
        $this->validateLogin($request);

        if(Auth::attempt($request->only('email','password'))){
            return response()->json([
                'token' =>  $request->user()->createToken('Api')->plainTextToken,
                 'message' => 'Login successful'
            ]);
        }else{
            return response()->json([
                'token' =>null,
                 'message' => 'Login failed'
            ],401);
        }
    }

    public function validateLogin(Request $request){
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    }
}
