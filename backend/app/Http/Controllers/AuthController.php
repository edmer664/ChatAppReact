<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    // login
    public function login(Request $request){    
        // Laravel Sanctum Login
        
        // validate
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        // attempt to login
        if (!$token = auth()->attempt($request->only(['email', 'password']), $request->remember_me)) {
            return response()->json([
                'errors' => [
                    'email' => ['Invalid credentials.']
                ]
            ], 401);
        }

        // return response
        return response()->json([
            'access_token' => auth()->user()->createToken('authToken')->plainTextToken,
            'token_type' => 'bearer',
            'user' => auth()->user(),
            
        ]);

    }

    // Register
    public function register(Request $request){
        // validate
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);

        // create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // return response
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    // logout
    public function logout(Request $request){
        
        // Laravel Sanctum Logout
        $request->user('sanctum')->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function forbidden(){
        return response()->json([
            'status' => 'error',
            'message' => 'Forbidden - You are not authorized to access this resource'
        ], 403);
    }

    // verify token
    public function verifyToken(Request $request){
        
        if (!$request->user('sanctum')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Forbidden - You are not authorized to access this resource'
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Token is valid'
        ]);

    }
}
