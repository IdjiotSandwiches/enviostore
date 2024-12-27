<?php

namespace App\Http\Controllers\user;

use App\Models\ErrorLog;
use App\Services\ProfileService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Interfaces\SessionKeyInterface;
use App\Interfaces\StatusInterface;
use App\Utilities\GoogleDriveUtility;
use Illuminate\Http\Response;

class ProfileController extends Controller implements StatusInterface, SessionKeyInterface
{
    private $googleDriveUtility;
    private $profileService;

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->googleDriveUtility = new GoogleDriveUtility();
        $this->profileService = new ProfileService();
    }

    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        // [$user, $profilePicture] = $this->profileService->getUser();
        $user = $this->profileService->getUser();

        return view('profile.index', compact('user'));
    }

    public function getProfilePicture()
    {
        if (!request()->ajax()) abort(404);

        try {
            $profilePicture = $this->profileService->getProfilePicture();
        } catch (\Exception $e) {
            $errorLog = new ErrorLog();
            $errorLog->error = $e->getMessage();
            $errorLog->save();

            return response()->json([
                'status' => self::STATUS_ERROR,
                'message' => 'Invalid operation.',
                'data' => []
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
        [$user, $profilePicture] = $this->profileService->getUser();

        return view('profile.edit', compact('profilePicture'));
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
            'message' => __('message.profile_update_success')
        ];

        return back()->with($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
