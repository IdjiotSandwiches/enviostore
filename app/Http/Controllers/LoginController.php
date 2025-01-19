<?php

namespace App\Http\Controllers;

use App\Interfaces\SessionKeyInterface;
use App\Models\ErrorLog;
use App\Services\Login\LoginService;
use App\Utilities\ErrorUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LoginRequest;
use App\Interfaces\StatusInterface;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller implements StatusInterface, SessionKeyInterface
{
    private $errorUtility;

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->errorUtility = new ErrorUtility();
    }

    /**
     * Return Login View
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('login');
    }

    /**
     * Summary of login
     * @param \App\Http\Requests\LoginRequest $loginRequest
     * @param \App\Services\Login\LoginService $loginService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $loginRequest, LoginService $loginService)
    {
        $validated = $loginRequest->validated();
        
        try {
            DB::beginTransaction();

            [$user, $isAdmin] = $loginService->login($validated['email'], $validated['password']);
            $sessionData = $loginService->setSessionData($user, $isAdmin);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->errorUtility->errorLog($e->getMessage());

            return back()->withInput()->with([
                'status' => self::STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        session($sessionData->all());
        Auth::guard($sessionData['identity']->auth)->login($user);
        $loginRequest->session()->regenerate();

        $response = [
            'status' => self::STATUS_SUCCESS,
            'message' => __('message.login'),
        ];

        if ($sessionData['is_admin']) {
            return to_route('admin.product.index')->with($response);
        }

        return to_route('home')->with($response);
    }

    /**
     * Logout
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = session(self::SESSION_IDENTITY);
        
        Auth::guard($user->auth)->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('home')->with([
            'status' => self::STATUS_SUCCESS,
            'message' => __('message.logout'),
        ]);
    }
}
