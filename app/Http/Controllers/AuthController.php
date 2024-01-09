<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {

    public function register(Request $request){

        $attrs = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);

        User::create([
            'name' => $attrs['name'],
            'email' => $attrs['email'],
            'password' => bcrypt($attrs['password'])
        ]);

        return response([
            'response' => 'success'
        ], 200);

    }

    public function login(Request $request)
{
    $login = $request->validate([
        'email' => 'required',
        'password'=> 'required',
    ]);
    if (!Auth::attempt($login)){
        return response()->json(['message' => 'error']);
    }
    /** @var \App\Models\MyUserModel $user **/
    $user = Auth::user();
    $token = $user->createToken('Token Name')->plainTextToken;
    return response()->json(['user' => $user, 'token' => $token]);
}

}

