<?php

namespace App\Http\Controllers;

use App\Models\ErrorLog;
use App\Services\Login\LoginService;
use App\Services\Register\RegisterService;
use Illuminate\Support\Facades\DB;
use App\Interfaces\StatusInterface;
use Illuminate\Support\Facades\Auth;
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
     * Summary of register
     * @param \App\Http\Requests\RegisterRequest $registerRequest
     * @param \App\Services\Register\RegisterService $registerService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RegisterRequest $registerRequest, RegisterService $registerService, LoginService $loginService)
    {
        $validated = $registerRequest->validated();

        try {
            DB::beginTransaction();

            $user = $registerService->register($validated);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $errorLog = new ErrorLog();
            $errorLog->error = $e->getMessage();
            $errorLog->save();

            $response = [
                'status' => self::STATUS_ERROR,
                'message' => __('message.invalid'),
            ];

            return back()->withInput()->with($response);
        }

        event(new Registered($user));

        [$user, $isAdmin] = $loginService->login($validated['email'], $validated['password']);
        $sessionData = $loginService->setSessionData($user, $isAdmin);
        session($sessionData->all());
        Auth::guard($sessionData['identity']->auth)->login($user);
        $registerRequest->session()->regenerate();

        return to_route('verification.notice');
    }
}
