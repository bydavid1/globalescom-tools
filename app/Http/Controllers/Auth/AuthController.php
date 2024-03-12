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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        try {
            $response = $this->authService->register($request->name, $request->email, $request->password);

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['Error al registrar usuario, error interno del servidor'], 500);
        }

        return response()->json(['data' => $response], 200);

    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            $response = $this->authService->login($request->email, $request->password);

            return response()->json($response, 200);
        } catch (\Error $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Error al ingresar, error interno del servidor'], 500);
        }
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

