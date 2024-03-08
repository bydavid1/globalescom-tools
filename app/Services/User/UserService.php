<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserService
{

    public function updateDeviceId(Request $data)
    {
        $user = Auth::user();

        if (!$user) {
            return ['message' => 'Usuario no autenticado'];
        }
        $user->device_id = $data->device_id;
        $user->save();

        return $user;
    }
}
