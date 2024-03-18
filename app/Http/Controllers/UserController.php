<?php

namespace App\Http\Controllers;

use auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    function register(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'name' => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users','email')],
            'password' => ['required', 'min:8', 'max:255'],
            'password_confirmation' => ['required', 'min:8', 'same:password']
        ]);


        if ($validator->fails()) {

            // If validation fails, return the error messages
            return response()->json(['errors' => $validator->errors()], 422);
        } else {

            // get all the incoming request data
            $incomingReq = $req->all();

            // hash the password
            $incomingReq['password'] = bcrypt($incomingReq['password']);

            $user = User::create($incomingReq);
            auth()->login($user);   

            // If validation passes, continue with your logic
            return redirect('/');
        }
    }

    function logout()
    {
        auth()->logout();
        return redirect('/login');
    }
}
