<?php

namespace App\Services\Login;

use App\Interfaces\StatusInterface;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class LoginService implements StatusInterface
{
    /**
     * Summary of login
     * @param string $email
     * @param string $password
     * @throws \Exception
     * @return array
     */
    public function login($email, $password)
    {
        $user = User::where('email', $email)->first() ??
            Admin::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            $isAdmin = $user instanceof Admin;
        } else {
            throw new \Exception('E-mail or password invalid.');
        }

        return [$user, $isAdmin];
    }
}