<?php

namespace App\Http\Controllers\user;

use App\Http\Requests\ChangePasswordRequest;
use App\Models\ErrorLog;
use App\Models\Order;
use App\Services\ProfileService;
use App\Utilities\ErrorUtility;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Interfaces\SessionKeyInterface;
use App\Interfaces\StatusInterface;
use Illuminate\Http\Response;

class ProfileController extends Controller implements StatusInterface, SessionKeyInterface
{
    private $profileService;
    private $errorUtility;

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->profileService = new ProfileService();
        $this->errorUtility = new ErrorUtility();
    }

    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = $this->profileService->getUser();
        $orders = $this->profileService->getOrders($user->id);

        return view('profile.index', compact('user', 'orders'));
    }

    public function getProfilePicture()
    {
        if (!request()->ajax()) abort(404);

        try {
            $profilePicture = $this->profileService->getProfilePicture();
        } catch (\Exception $e) {
            $this->errorUtility->errorLog($e->getMessage());

            return response()->json([
                'status' => self::STATUS_ERROR,
                'message' => __('message.invalid'),
                'data' => [],
            ], Response::HTTP_OK);
        }

        return response()->json([
            'status' => self::STATUS_SUCCESS,
            'message' => 'Data fetch successfully.',
            'data' => $profilePicture,
        ], Response::HTTP_OK);
    }

    /**
     * Summary of edit
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit()
    {
        $user = $this->profileService->getUser();

        return view('profile.edit', compact('user'));
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\ProfileRequest $profileRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $profileRequest)
    {
        $validated = $profileRequest->validated();

        try {
            DB::beginTransaction();

            $this->profileService->updateProfile($validated);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $errorLog = new ErrorLog();
            $errorLog->error = $e->getMessage();
            $errorLog->save();

            $response = [
                'status' => self::STATUS_ERROR,
                'message' => $e->getMessage(),
            ];

            return back()->with($response);
        }

        $response = [
            'status' => self::STATUS_SUCCESS,
            'message' => __('message.profile_update_success'),
        ];

        return back()->with($response);
    }

    /**
     * Summary of changePassword
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function changePassword()
    {
        return view('profile.change-password');
    }

    /**
     * Summary of attemptChangePassword
     * @param \App\Http\Requests\ChangePasswordRequest $changePasswordRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function attemptChangePassword(ChangePasswordRequest $changePasswordRequest)
    {
        $validated = $changePasswordRequest->validated();

        try {
            DB::beginTransaction();

            $this->profileService->attemptChangePassword($validated);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $errorLog = new ErrorLog();
            $errorLog->error = $e->getMessage();
            $errorLog->save();

            $response = [
                'status' => self::STATUS_ERROR,
                'message' => $e->getMessage(),
            ];

            return back()->with($response);
        }

        $response = [
            'status' => self::STATUS_SUCCESS,
            'message' => __('message.change_password_success'),
        ];

        return back()->with($response);
    }
}
