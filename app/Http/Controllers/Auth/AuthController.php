<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\UserResource;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        $user = User::create([
            //required values
            'email' => $request->email,
            'password' => Hash::make($request->password),

            //additional values
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => "successful",
            'data' => UserResource::make($user)
        ], 200);
    }

    public function login(LoginRequest $request){
        $user = User::where('email', $request->email)->first();
        if($user){
            if(Hash::check($request->password, $user->password)){
                $token = $user->createToken('auth-token')->plainTextToken;
                return response()->json([
                    'message' => "successful",
                    'token' => $token,
                    'data' => UserResource::make($user)
                ], 200);
            }
        }else{
            return response()->json([
                'message' => "email or password is incorrect",
            ], 400);
        }
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'successful'
        ], 200);
    }
}
