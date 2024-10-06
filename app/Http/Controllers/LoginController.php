<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\ErrorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LoginRequest;
use App\Interfaces\StatusInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller implements StatusInterface
{
    /**
     * Return Login View
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('login');
    }

    /**
     * Login Attempt
     * @param \App\Http\Requests\LoginRequest $loginRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $loginRequest)
    {
        $validated = $loginRequest->validated();

        try {
            DB::beginTransaction();

            $user = User::where('email', $validated['email'])->first() ??
                Admin::where('email', $validated['email'])->first();

            if ($user && Hash::check($validated['password'], $user->password)) {
                $isAdmin = $user instanceof Admin ? 'admin' : 'web';
            }
            else {
                DB::rollBack();
                $response = [
                    'status' => self::STATUS_ERROR,
                    'message' => 'E-mail or password invalid.'
                ];

                return back()->with($response);
            }

            DB::commit();
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

        Auth::guard($isAdmin)->login($user);
        $loginRequest->session()->regenerate();
        $response = [
            'status' => self::STATUS_SUCCESS,
            'message' => 'Logged In.'
        ];

        return back()->with($response);
    }

    /**
     * Logout
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $response = [
            'status' => self::STATUS_SUCCESS,
            'message' => 'Logged Out.'
        ];

        return redirect()->route('home')
            ->with($response);
    }
}
