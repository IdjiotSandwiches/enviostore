<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ErrorLog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Interfaces\StatusInterface;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RegisterRequest $registerRequest)
    {
        $validated = $registerRequest->validated();

        try {
            DB::beginTransaction();

            $user = new User();
            $user->uuid = Str::uuid();
            $user->name = ucwords($validated['name']);
            $user->email = $validated['email'];
            $user->password = Hash::make($validated['password']);
            $user->phone_number = $validated['phone_number'];
            $user->user_type = 0;
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

        return redirect()->route('login')
            ->with($response);
    }
}
