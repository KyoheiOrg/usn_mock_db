<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remenber_token' => Str::random(10),
        ]);


        return response()->json(['status' => 200]);
    }

    public function login(LoginRequest $request){
        $request->validate([
            'email' => ['required','email'],
            'password' => ['required']
        ]);
        try{
            $request->authenticate();
        }catch(\Exception $e){
            return response()->json(['errors' => $e],401);
        }
        $user = Auth::user();
        $token = $request->user()->createToken('auth-token');
        return response()->json(['user' => $user ,'api_token'=> $token->plainTextToken], 200);
    }
}
