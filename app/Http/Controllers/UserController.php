<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\User\UserService;

class UserController extends Controller
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function updateDeviceId(Request $data){
        try {
            $response = $this->userService->updateDeviceId($data);

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['Error al actualizar, error interno del servidor'], 500);
        }
        return response()->json(['data' => $response], 200);
    }
}
