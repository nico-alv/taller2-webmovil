<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Contracts\Providers\JWT;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request){
        $this->validate($request, [
            'name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'dni' => 'required|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'dni' => $request->dni,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }
    public function login(LoginRequest $request){
        $credentials = $request->only('name', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => 'Invalid credentials.'
                ], 400);
            }

            $user = JWTAuth::user();

            if (!$user->role == 1) {
                return response()->json([
                    'error' => 'Invalid credentials.'
                ], 400);
            }

        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Token error.'
            ], 500);
        }

        return response()->json(compact('token'));
    }

    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'Logout successful.']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to logout.'], 500);
        }
    }

}
