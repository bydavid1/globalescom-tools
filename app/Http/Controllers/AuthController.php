<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Tools\BiZig\Auth\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{

    private $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);
    
            $response = $this->authService->register($request);

        } catch (\Throwable $th) {
            return ['message' => 'Error al registar usuario', 'Error' => $th->getMessage()];
        }

        return $response;

    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            $response = $this->authService->login($request);

            return $response;

        } catch (\Throwable $th) {
            return ['message' => 'Error al ingresar', 'Error' => $th->getMessage()];
        }

        
        
    }

    public function logout(Request $request)
    {
        try {
            $response = $this->authService->logout($request);
        } catch (\Throwable $th) {
            return ['message' => 'Error al cerrar la sesion', 'Error' => $th->getMessage()];
        }

        return $response;
    }
}

