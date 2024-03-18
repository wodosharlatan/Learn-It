<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    function register(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'name' => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'min:8', 'max:255'],
            'password_confirmation' => ['required', 'min:8', 'same:password']
        ]);

        if ($validator->fails()) {
            
            // If validation fails, return the error messages
            return response()->json(['errors' => $validator->errors()], 422);
        } else {

            // If validation passes, continue with your logic
            return response()->json(['message' => 'User registered successfully'], 201);
        }
    }
}
