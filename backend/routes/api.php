<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('login', [AuthController::class, 'login']);
 // Rutas para la gestión de usuarios con autenticación JWT.
Route::middleware('jwt-verify')->group(function() {
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{user}', [UserController::class, 'show']);
    Route::post("users/", [UserController::class, "store"]);
    Route::put("users/{user}", [UserController::class, "update"]);
    Route::delete("users/{user}", [UserController::class, "destroy"]);
    // Ruta para cerrar sesión.
    Route::post('logout', [AuthController::class, 'logout']);

});
