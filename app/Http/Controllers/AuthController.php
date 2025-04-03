<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){ 
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $validatedData['password'] = hash::make($validatedData['password']);
        $user = User::create($validatedData);
        $token = $user->createToken($user->name)->plainTextToken;
        return ['user' => $user, 'token' => $token];
    }

    public function login(Request $request){
        $validatedData = $request->validate([
            'email' => 'required|string|email|exists:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $validatedData['email'])->first();
        if(!$user || !Hash::check($validatedData['password'], $user->password)){
            return response()->json(['errors' => ['email' => 'The provided credentials are incorrect.']], 401);
        }

        $token = $user->createToken($user->name)->plainTextToken;
        return ['user' => $user, 'token' => $token];
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return ["message" => "logout"];
    }
}
