<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AuthLoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);
        $salt = Str::uuid();
        return User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password'], ["salt" => $salt]),
            'salt' => $salt
        ]);
    }   

    public function login(AuthLoginRequest $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        $user = User::where(column: "email", operator: $request->email)->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response(["message" => "Invalid credentials"], status: 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }
}
