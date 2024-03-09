<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Auth\AuthService;
use Illuminate\Support\Facades\Log;

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
            Log::error($th->getMessage());
            return response()->json(['Error al registrar usuario, error interno del servidor'], 500);
        }

        return response()->json(['data' => $response], 200);

    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            $response = $this->authService->login($request);

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['Error al ingresar, error interno del servidor'], 500);
        }
        return response()->json(['data' => $response], 200);

    }

    public function logout()
    {
        try {

            $response = $this->authService->logout();

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['Error al salir de la sesion, error interno del servidor'], 500);
        }

        return response()->json(['data' => $response], 200);
    }
}

