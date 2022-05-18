<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    //construct method
    public function __construct(){
//        $this->middleware('auth:api', ['except' => ['login','register']]);
        $this->middleware('JWT', ['except' => ['login']]);
    }

    //login function
    public function login(Request $request){
        $credentials = request(['email', 'password']);
        if (! $token = auth()->attempt($credentials)){
            return response()->json(['error' => 'Email Or Password Invalid...'], 401);
        }
        return $this->respondWithToken($token);
    }


    //me function
    public function me(Request $request){
        return response()->json(auth()->user());
    }

    //logout function
    public function logout(Request $request){
        auth()->logout();
        return response()->json(['message' => 'Successfully Logout Done...']);
    }


    //refresh function
    public function refresh(Request $request){
        return $this->respondWithToken(auth()->refresh());
    }

    //generate token function
    public function respondWithToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'fullName' => auth()->user()->full_name,
            'userName' => auth()->user()->username,
            'email' => auth()->user()->email,
            'userRole' => auth()->user()->role,
            'userPhoto' => auth()->user()->photo,
            'userId' => auth()->id(),
            'info' => auth()->user(),
        ]);
    }


    //payload function
    public function payload(){
        return auth()->payload();
    }


    //register function
    public function register(Request $request){
        $this->validate($request,[
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        User::create([
            'full_name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return $this->login($request);
    }


}
