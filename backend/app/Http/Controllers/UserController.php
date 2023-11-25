<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Obtener la lista de usuarios con rol 0.",
     *     @OA\Response(response="200", description="OK"),
     * )
     */
    public function index()
    {
        return response()->json(User::where('role', 0)->get());
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Registrar un nuevo usuario.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="last_name", type="string"),
     *             @OA\Property(property="dni", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="points", type="integer"),
     *         )
     *     ),
     *     @OA\Response(response="201", description="Usuario registrado."),
     *     @OA\Response(response="422", description="Error de validación.")
     * )
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'last_name' => 'required',
            'dni' => 'required|unique:users,dni',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'points' => 'integer|min:0',
        ]);

        User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'dni' => $request->dni,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'points' => $request->points,
        ]);

        return response()->json(['status' => 'Usuario registrado.'], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Obtener información de un usuario específico.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del usuario",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Response(response="404", description="Usuario no encontrado.")
     * )
     */
    public function show($id)
    {
        return response()->json(User::where('id', $id)->get());
    }

    /**
     * @OA\Put(
     *     path="/api/users/{user}",
     *     summary="Actualizar información de un usuario específico.",
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         description="Usuario a actualizar",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="last_name", type="string"),
     *             @OA\Property(property="dni", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="points", type="integer"),
     *         )
     *     ),
     *     @OA\Response(response="200", description="Usuario actualizado."),
     *     @OA\Response(response="404", description="Usuario no encontrado."),
     *     @OA\Response(response="422", description="Error de validación.")
     * )
     */
    public function update(StoreUserRequest $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required',
            'last_name' => 'required',
            'dni' => 'required|unique:users,dni,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'required',
            'points' => 'integer|min:0',
        ]);

        $user->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'dni' => $request->dni,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'points' => $request->points,
        ]);

        return response()->json(['status' => 'Usuario actualizado.'], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{user}",
     *     summary="Eliminar un usuario específico.",
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         description="Usuario a eliminar",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Usuario eliminado."),
     *     @OA\Response(response="404", description="Usuario no encontrado.")
     * )
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['status' => 'Usuario eliminado.'], 200);
    }
}
