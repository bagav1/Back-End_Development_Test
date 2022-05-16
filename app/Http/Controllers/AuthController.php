<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'state_id' => 1
        ]);

        return response()->json([
            'status' => true,
            'data' => [
                'message' => 'Usuario creado correctamente.',
                'user' => $user
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            $credentials = request(['email', 'password']);

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status' => false,
                    'data' => [
                        'message' => 'No autorizado'
                    ]
                ], 401);
            }

            $user = Auth::user();
            if ($user->state_id == 1) {
                return response()->json([
                    'status' => false,
                    'data' => [
                        'message' => 'Usuario pendiente por aprobacion.'
                    ]
                ], 206);
            }elseif ($user->state_id == 3) {
                return response()->json([
                    'status' => false,
                    'data' => [
                        'message' => 'Usuario con peticion rechazada.'
                    ]
                ], 206);
            }
            $tokenResult = $user->createToken('AccessToken');
            $token = $tokenResult->accessToken;

            return response()->json([
                'status' => true,
                'data' => [
                    'user' => $user['email'],
                    'accessToken' => $token,
                ]
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'status' => false,
                'data' => [
                    'error' => $ex
                ]
            ], 400);
        }
    }

    public function logout()
    {
        try {
            Auth::user()->tokens->each(function ($token, $key) {
                $token->delete();
            });

            return response()->json([
                'status' => true,
                'data' => [
                    'message' => 'Sesion cerrada correctamente.'
                ]
            ], 201);
        } catch (Exception $ex) {
            return response()->json([
                'status' => false,
                'data' => [
                    'error' => $ex
                ]
            ], 400);
        }
    }
}
