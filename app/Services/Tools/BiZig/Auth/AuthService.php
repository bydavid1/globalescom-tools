<?php

namespace App\Services\Tools\BiZig\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    public function register(Request $request) : User
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('user'); // Assign role to new user by default.

        return $user;
    }


    public function login(Request $request)
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return [ "message" => "Credenciales incorrectas"];
        }else {
            $user = Auth::user();
            $token = $user->createToken('token-name')->plainTextToken;

            return [
                'user_name'  => $user->name,
                'role_name' => $user->roles->value('name'),
                'token' => $token
            ];
        }     
    }

    public function logout()
    {
        if (Auth::check()) {
            $user = Auth::user();

            $user->tokens()->delete();

            return true;
        }  else {
            return [ "message" => "No hay una sesión activa para cerrar."];
        }

    }
}
