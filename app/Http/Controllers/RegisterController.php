<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    /**
     * Return Register View
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('register');
    }

    public function register(RegisterRequest $registerRequest)
    {
        $validated = $registerRequest->validated();

        try {
            DB::beginTransaction();

            $user = new User();
            $user->uuid = Str::uuid();
            $user->name = ucwords($validated['name']);
            $user->email = $validated['email'];
            $user->password = $validated['password'];
            $user->save();

            DB::commit();
            $response = [

            ];
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
