<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ErrorLog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Interfaces\StatusInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller implements StatusInterface
{
    /**
     * Return Register View
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('register');
    }

    /**
     * Register Attempt
     * @param \App\Http\Requests\RegisterRequest $registerRequest
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function register(RegisterRequest $registerRequest)
    {
        $validated = $registerRequest->validated();

        try {
            DB::beginTransaction();

            $user = new User();
            $user->uuid = Str::uuid();
            $user->username = $validated['username'];
            $user->email = $validated['email'];
            $user->password = Hash::make($validated['password']);
            $user->phone_number = $validated['phone_number'];
            $user->save();

            DB::commit();
            $response = [
                'status' => self::STATUS_SUCCESS,
                'message' => 'Account successfully created.',
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            $errorLog = new ErrorLog();
            $errorLog->error = $e->getMessage();
            $errorLog->save();

            $response = [
                'status' => self::STATUS_ERROR,
                'message' => 'Invalid operation.',
            ];

            return back()->with($response);
        }

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('verification.notice');
    }
}
