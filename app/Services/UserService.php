<?php
namespace App\Services;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function getUsers() {
        $users = User::all();

        return $users;
    }

    public function getUser($id) : User
    {
        $user = User::find($id);

        return $user;
    }

    public function register(string $name, string $email, string $password) : User
    {
        $user = User::create([
            'name' => $email,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $user->assignRole('user');

        return $user;
    }

}
