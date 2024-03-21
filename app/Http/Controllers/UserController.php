<?php

namespace App\Http\Controllers;

use auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

include_once(app_path('Helpers/RedirectFunction.php'));

class UserController extends Controller
{

    function register(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'name' => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:255'],
            'password_confirmation' => ['required', 'min:8', 'same:password']
        ]);


        if ($validator->fails()) {

            return ValidatorRedirect(url()->previous(), $validator, '#form');
        } else {

            // get all the incoming request data
            $incomingReq = $req->all();

            // hash the password
            $incomingReq['password'] = bcrypt($incomingReq['password']);

            $user = User::create($incomingReq);
            auth()->login($user);

            // If validation passes, continue with your logic
            return redirect('/home');
        }
    }

    function logout()
    {
        auth()->logout();
        return redirect('/');
    }

    function login(Request $req)
    {


        // check if the incoming request parameters are correct
        $validator = Validator::make($req->all(), [
            'login_email' => ['required', 'email', 'max:255'],
            'login_password' => ['required', 'min:8', 'max:255']
        ]);


        if ($validator->fails()) {

            return ValidatorRedirect(url()->previous(), $validator, '#form');
        } else {

            $incomingReq = $req->all();

            // if the incoming request parameters are correct, attempt to login
            if (auth()->attempt(['email' => $incomingReq['login_email'], 'password' => $incomingReq['login_password']])) {

                // If the login attempt is successful, regenerate the session
                $req->session()->regenerate();
                return redirect('/home');
            }
        }
    }
}
