<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    public function register(string $name, string $email, string $password) : User
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $user->assignRole('user'); // Assign role to new user by default.

        return $user;
    }


    public function login(string $email, string $password)
    {
        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            throw new AuthenticationException('Contraseña o email incorrecto.');
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

    public function logout() : void
    {
        if (Auth::check()) {
            $user = Auth::user();

            $user->tokens()->delete();
        }
    }
}
