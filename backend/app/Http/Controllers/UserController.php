<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Muestra una lista de usuarios con rol 0.
     */
    public function index()
    {
        return response()->json(User::where('role', 0)->get());
    }

    /**
     * Almacena un nuevo usuario en el almacenamiento.
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
     * Muestra el usuario especificado.
     */
    public function show($id)
    {
        return response()->json(User::where('id', $id)->get());
    }

    /**
     * Actualiza el usuario especificado en el almacenamiento.
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

        return response()->json(['status' => 'Usuario actualizado'], 200);
    }

    /**
     * Elimina el usuario especificado del almacenamiento.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['status' => 'Usuario eliminado.'], 200);
    }
}
