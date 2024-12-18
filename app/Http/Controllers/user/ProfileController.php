<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use App\Utilities\GoogleDriveUtility;

class ProfileController extends Controller
{
    private $googleDriveUtility;
    public function __construct()
    {
        $this->googleDriveUtility = new GoogleDriveUtility();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $identity = auth()->user();
        $profileUrl = $identity->profile_picture;
        $profilePicture = $this->googleDriveUtility->getFile($profileUrl);
        // dd($identity);
        return view('profile.index', compact('identity', 'profilePicture'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeProfilePicture(ProfileRequest $profileRequest)
    {
        $identityName = session('identity')->getName();
        $image = $profileRequest->validated()->file('image');
        $imageName = $identityName;

        try {
            $response = $this->googleDriveUtility->storeFile($imageName, $image);

            $user = auth()->user();
            $user->profile_picture = $response['path'];

            return back()->with($response);
        } catch (\Exception $e) {
            return back()->with($response);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified res  ource.
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    const PROFILE_PICTURE_COLUMN = 'profile_picture';
    const NAME_COLUMN = 'username';
    const ADDRESS_COLUMN = 'address';
    const EMAIL_COLUMN = 'email';
    const PHONE_COLUMN = 'phone_number';
    public function update(ProfileRequest $profileRequest)
    {
        $identity = session('identity');
        $validated = $profileRequest->validated();

        try {
            $user = auth()->user();
            $user = User::find($user->id);
            // Check if any updateable field is present
            $updateFields = [
                self::NAME_COLUMN,
                self::ADDRESS_COLUMN,
                self::EMAIL_COLUMN,
                self::PHONE_COLUMN,
                self::PROFILE_PICTURE_COLUMN,
            ];

            $hasUpdates = false;
            foreach ($updateFields as $field) {
                if (isset($validated[$field])) {
                    $hasUpdates = true;
                    break;
                }
            }

            if (!$hasUpdates) {
                return back()->with([
                    'status' => 'error',
                    'message' => 'No fields to update.',
                ]);
            }

            if (!empty($validated[self::NAME_COLUMN])) {
                $user->username = $validated[self::NAME_COLUMN];
            }

            if (!empty($validated[self::ADDRESS_COLUMN])) {
                $user->address = $validated[self::ADDRESS_COLUMN];
            }

            if (!empty($validated[self::EMAIL_COLUMN])) {
                $user->email = $validated[self::EMAIL_COLUMN];
            }

            if (!empty($validated[self::PHONE_COLUMN])) {
                $user->phone_number = $validated[self::PHONE_COLUMN];
            }

            if ($profileRequest->hasFile(self::PROFILE_PICTURE_COLUMN)) {
                $file = $profileRequest->file(self::PROFILE_PICTURE_COLUMN);
                $fileExtension = $file->getClientOriginalExtension();
                $timestamp = time();
                $fileName = 'avatars/' . str_replace(' ', '_', $user->username) . '_' . $timestamp . '.' . $fileExtension;
            
                try {
                    $fileUrl = $this->googleDriveUtility->storeFile($fileName, $file);
            
                    if ($fileUrl) {
                        $user->profile_picture = $fileName;
                    } else {
                        return back()->withErrors([
                            self::PROFILE_PICTURE_COLUMN => 'Failed to upload profile picture to Google Drive.',
                        ]);
                    }
                } catch (\Exception $e) {
                    return back()->withErrors([
                        self::PROFILE_PICTURE_COLUMN => 'Error uploading profile picture: ' . $e->getMessage(),
                    ]);
                }
            }

            $user->save();

            return back()->with([
                'status' => 'success',
                'message' => 'Profile updated successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('Profile update error: ' . $e->getMessage());
            return back()->with([
                'status' => 'error',
                'message' => 'An error occurred while updating your profile.',
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
