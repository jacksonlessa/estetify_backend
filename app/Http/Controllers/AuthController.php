<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'name'=> 'required|string',
            'email'=> 'required|string|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'device_name' => "required",
        ]);
        $fields['role'] = "admin";
        $user = User::create($fields);

        $token = $user->createToken($fields['device_name'])->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
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
        $user = User::with('account')->where('email', $fields['email'])->first();

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

        return response($response,200);
    }


    public function recoverPassword(Request $request){
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        

        return $status === Password::RESET_LINK_SENT
            ? response(["success" => __($status)], 200)
            : response(["error" =>__($status)], 400);
    }
    public function resetPassword(Request $request){
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
    
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );
    
        return $status === Password::PASSWORD_RESET
            ? response(["success" => __($status)], 200)
            : response(["error" =>__($status)], 400);
    }
}
