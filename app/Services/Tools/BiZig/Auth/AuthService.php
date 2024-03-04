<?php

namespace App\Services\Tools\BiZig\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    public function register(Request $request) : array|JsonResponse
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->assignRole('user'); // Assign role to new user by default.

            return [
                'success' => true,
                'user' => $user
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al crear usuario, ' . $e->getMessage()
            ];
        }
    }


    public function login(Request $request)
    {
        try {
            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return response()->json(['message' => 'Contraseña o correo incorrectos'], 401);
            }
    
            $user = Auth::user();
            $token = $user->createToken('token-name')->plainTextToken;
    
            return [
                'user_name'  => $user->name,
                'role_name' => $user->roles->value('name'),
                'token' => $token
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function logout(Request $request) : array
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return [
                'success' => true,
                'message' => "success logout"
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
