<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getAll()
    {
        try {
            return response()->json([
                'status' => true,
                'data' => User::with('state')->get()
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'status' => false,
                'error' => $ex->getMessage()
            ], 400);
        }
    }

    public function getId(Int $id)
    {
        try {
            $user = User::with('state')->where('id', $id)->get();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'data' => [
                        'error' => 'Id de usuario no encontrado. Id: ' . $id
                    ]
                ], 400);
            }
            return response()->json([
                'status' => true,
                'data' => $user
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'status' => false,
                'error' => $ex->getMessage()
            ], 400);
        }
    }

    public function getByState(Int $id)
    {
        try {
            $user = User::with('state')->where('state_id', $id)->get();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'data' => [
                        'error' => 'Id de usuario con el estado. Id: ' . $id
                    ]
                ], 400);
            }
            return response()->json([
                'status' => true,
                'data' => $user
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'status' => false,
                'error' => $ex->getMessage()
            ], 400);
        }
    }

    public function update(Int $id, Request $request)
    {
        try {

            $user = User::where('id', $id)->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'data' => [
                        'error' => 'Id de usuario no existente. Id: ' . $id
                    ]
                ], 400);
            }

            $user->update($request->all());

            return response()->json([
                'status' => true,
                'data' => [
                    'message' => 'Usuario actualizado correctamente. Id' . $id,
                    'update' => $request->all()
                ]
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'status' => false,
                'error' => $ex->getMessage()
            ], 400);
        }
    }

    public function delete(Int $id)
    {
        try {
            $user = User::where('id', $id)->first();
            if(!$user){
                return response()->json([
                    'status' => false,
                    'data' => [
                        'error'=>'Id de usuario no encontrado. Id'.$id
                    ]
                ], 400);
            }
            $user->delete();
            return response()->json([
                'status' => true,
                'data' => [
                    'message'=>'Usuario eliminado correctamente. Id'.$id
                ]
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'status' => false,
                'error'=>$ex->getMessage()
            ], 400);
        }
    }
}
