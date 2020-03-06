<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);
        auth()->login($user);
        $token = $user->createToken('login token')->accessToken;
        return ['user' => $user, 'token' => $token];
    }
    public function login(Request $request)
    {
        $credentials = ['email' => $request['email'], 'password' => $request['password']];
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = auth()->user();
        return ['user' => $user, 'token' => $user->createToken('login token')->accessToken];
    }
}
