<?php

namespace App\Services\Register;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    /**
     * Summary of register
     * @param \Illuminate\Foundation\Http\FormRequest $validated
     * @return User
     */
    public function register($validated)
    {
        $user = new User();
        $user->uuid = Str::uuid();
        $user->profile_picture = 'avatars/default_user.png';
        $user->username = $validated['username'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->phone_number = $validated['phone_number'];
        $user->save();

        return $user;
    }
}