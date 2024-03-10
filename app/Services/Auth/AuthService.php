<?php

namespace App\Services\Auth;

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
            throw new AuthenticationException('Credenciales inválidas');
        } else {
            /**
             * @var User $user
             */
            $user = Auth::user();
            $token = $user->createToken('token-name')->plainTextToken;

            return [
                'user_name'  => $user->name,
                'role_name' => $user->roles->value('name'),
                'token' => $token,
                'company_id' => $user->companies?->first()?->id
            ];
        }
    }

    public function logout()
    {
        if (Auth::check()) {
            /**
             * @var User $user
             */
            $user = Auth::user();

            $user->tokens()->delete();

            return true;
        }  else {
            return [ "message" => "No hay una sesión activa para cerrar."];
        }

    }
}
