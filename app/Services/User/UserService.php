<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public function getUsers()
    {
        $users = User::all();

        return $users;
    }

    public function getUser($id): User
    {
        $user = User::find($id);

        return $user;
    }

    public function register(string $name, string $email, string $password): User
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $user->assignRole('user');

        return $user;
    }

    public function updateDeviceId(Request $data)
    {
        /**
         * @var User $user
         */
        $user = Auth::user();

        if (!$user) {
            return ['message' => 'Usuario no autenticado'];
        }
        $user->device_id = $data->device_id;
        $user->save();

        return $user;
    }
}
