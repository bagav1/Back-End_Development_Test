<?php

namespace App\Http\Controllers;

use App\Models\UserStates;
use Illuminate\Http\Request;

class UserStatesController extends Controller
{
    public function getAll()
    {
        try {
            return response()->json([
                'status' => true,
                'data' => UserStates::get()
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'status' => false,
                'error' => $ex->getMessage()
            ], 400);
        }
    }
}
