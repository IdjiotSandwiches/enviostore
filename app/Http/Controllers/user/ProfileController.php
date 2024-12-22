<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Interfaces\SessionKeyInterface;
use App\Interfaces\StatusInterface;
use App\Utilities\GoogleDriveUtility;

use function PHPUnit\Framework\isNull;

class ProfileController extends Controller implements StatusInterface, SessionKeyInterface
{
    private $googleDriveUtility;
    private $profileService;
    public function __construct()
    {
        $this->googleDriveUtility = new GoogleDriveUtility();
        $this->profileService = new ProfileService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        [$user, $profilePicture] = $this->profileService->getUser();

        return view('profile.index', compact('user', 'profilePicture'));
    }

    /**
     * Show the form for editing the specified res  ource.
     */
    public function edit()
    {
        [$user, $profilePicture] = $this->profileService->getUser();

        return view('profile.edit', compact('profilePicture'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileRequest $profileRequest)
    {
        try {
            DB::beginTransaction();

            $user = $this->profileService->updateProfile($profileRequest);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Profile update error: ' . $e->getMessage());

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
