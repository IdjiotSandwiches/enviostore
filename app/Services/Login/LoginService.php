<?php

namespace App\Services\Login;

use App\Interfaces\SessionKeyInterface;
use App\Interfaces\StatusInterface;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class LoginService implements StatusInterface, SessionKeyInterface
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

    /**
     * Summary of setSessionData
     * @param User $user
     * @param bool $isAdmin
     * @return \Illuminate\Support\Collection
     */
    public function setSessionData($user, $isAdmin)
    {
        $identity = [
            'id' => $user->id,
            'email' => $user->email,
            'username' => $user->username,
            'phone_number' => $user->phone_number,
            'address' => $user->address,
        ];

        $identity['auth'] = $isAdmin ? 'admin' : 'web';

        return collect([
            self::SESSION_IDENTITY => (object) $identity,
            self::SESSION_IS_ADMIN => $isAdmin,
            self::SESSION_IS_LOGGED_IN => true,
        ]);
    }
}