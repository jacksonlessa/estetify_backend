<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'name'=> 'required|string',
            'email'=> 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create($fields);
        
        return response($user, 201);
    }

    public function logout(Request $request){
        // Revoke the token that was used to authenticate the current request...
        $request->user()->currentAccessToken()->delete();
        
        // Revoke all tokens...
        // $user->tokens()->delete();
        
        // Revoke a specific token...
        // $user->tokens()->where('id', $tokenId)->delete();
        return [
            'message' => 'Logget out'
        ];
    }

    public function login(Request $request){
        $fields = $request->validate([
            'email'=> 'required|string',
            'password' => 'required|string',
            'device_name' => "required",
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password) ){
            return response(
                ['message' => 'bad credencial'],
                401
            );
        }

        $token = $user->createToken($fields['device_name'])->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
}
