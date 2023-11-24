<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(User::where('role', 0)->get());
    }

    /**
     * Store a newly created resource in storage.
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

        return response()->json("Usuario registrado.");
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        return response()->json(User::where('id', $id)->get());
    }

    /**
     * Update the specified resource in storage.
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
            'password' => bcrypt($request->password), // Hash the password
            'points' => $request->points,
        ]);

        return response()->json("Usuario actualizado");
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json("Usuario eliminado.");
    }
}
