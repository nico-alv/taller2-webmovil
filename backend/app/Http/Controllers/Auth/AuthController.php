<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Contracts\Providers\JWT;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use OpenApi\Annotations as OA;

class AuthController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Iniciar sesión y obtener un token JWT.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="password", type="string"),
     *         )
     *     ),
     *     @OA\Response(response="200", description="Inicio de sesión exitoso. Se devuelve un token JWT."),
     *     @OA\Response(response="400", description="Credenciales inválidas."),
     *     @OA\Response(response="500", description="Error de token."),
     * )
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
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Cerrar sesión y invalidar el token JWT actual.",
     *     @OA\Response(response="200", description="Cierre de sesión exitoso."),
     *     @OA\Response(response="500", description="Fallo al cerrar sesión."),
     * )
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
