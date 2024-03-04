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
            return response()->json(['Credenciales incorrectas'], 401);
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

    public function logout(Request $request) : bool
    {
        $request->user()->currentAccessToken()->delete();

        return true;
    }
}
