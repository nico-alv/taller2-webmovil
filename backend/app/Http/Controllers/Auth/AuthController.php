<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Contracts\Providers\JWT;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    /**
     * Procesa la solicitud de inicio de sesión y emite un token JWT si las credenciales son válidas.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('name', 'password');

        try {
            // Intenta generar un token JWT con las credenciales proporcionadas.
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => 'Credenciales inválidas.'
                ], 400);
            }

            // Obtiene el usuario asociado al token JWT.
            $user = JWTAuth::user();

            // Verifica si el usuario tiene el rol correcto para acceder.
            if (!$user->role == 1) {
                return response()->json([
                    'error' => 'Credenciales inválidas.'
                ], 400);
            }

        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Error de token.'
            ], 500);
        }

        return response()->json(compact('token'));
    }

    /**
     * Invalida el token JWT actual, cerrando la sesión del usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            // Invalida el token JWT actual.
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'Cierre de sesión exitoso.']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Fallo al cerrar sesión.'], 500);
        }
    }

}
