<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\JWTGuard;

class AuthController extends Controller
{
    ///Obtener el guard de autenticacion JWT.
    private function jwtGuard(): JWTGuard
    {
        $guard = auth()->guard('api');

        //@var JWTGuard $guard */
        return $guard;
    }

    ///Registrar un usuario.
     
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validacion',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $guard = $this->jwtGuard();

        $token = $guard->login($user);

        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'user' => $user,
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $guard->factory()->getTTL() * 60
        ], 201);
    }

    //Iniciar sesion
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validacion',
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $validator->validated();

        $guard = $this->jwtGuard();

        $token = $guard->attempt($credentials);

        if (!$token) {
            return response()->json([
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        return response()->json([
            'message' => 'Inicio de sesion exitoso',
            'user' => $guard->user(),
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $guard->factory()->getTTL() * 60
        ]);
    }

    //Cerrar sesion e invalidar token
    public function logout()
    {
        $this->jwtGuard()->logout();

        return response()->json([
            'message' => 'Sesion cerrada correctamente'
        ]);
    }

    ///btener perfil del usuario autenticado
    public function me()
    {
        return response()->json([
            'user' => $this->jwtGuard()->user()
        ]);
    }
}
