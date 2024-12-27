<?php

namespace App\Services;

use App\Interfaces\SessionKeyInterface;
use App\Models\User;
use App\Utilities\GoogleDriveUtility;

class ProfileService implements SessionKeyInterface
{
    private $googleDriveUtility;

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->googleDriveUtility = new GoogleDriveUtility();
    }

    /**
     * Summary of getUser
     * @return array
     */
    public function getUser()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = session(self::SESSION_IDENTITY);
        $user = User::find($user->id);
        // $profilePicture = $this->googleDriveUtility->getFile($url);

        // return [$user, $profilePicture];
        return $user;
    }

    public function getProfilePicture()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = session(self::SESSION_IDENTITY);
        $url = User::find($user->id)->profile_picture;
        $profilePicture = $this->googleDriveUtility->getFile($url);

        return $profilePicture;
    }

    public function updateProfile($profileRequest)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = session(self::SESSION_IDENTITY);
        $validate = $profileRequest->validated();
        $user = User::find($user->id);

        foreach ($validate as $key => $value) {
            if (!is_null($value)) {
                $user->$key = $value;
            }
        }

        if ($profileRequest->hasFile('profile_picture')) {
            $file = $profileRequest->file('profile_picture');
            $fileExtension = $file->getClientOriginalExtension();
            $fileName = 'avatars/' . str_replace(' ', '_', $user->uuid) . '.' . $fileExtension;

            try {
                $fileUrl = $this->googleDriveUtility->storeFile($fileName, $file);

                if ($fileUrl) {
                    $user->profile_picture = $fileName;
                } else {
                    return back()->withErrors([
                        'profile_picture' => 'Failed to upload profile picture to Google Drive.',
                    ]);
                }
            } catch (\Exception $e) {
                return back()->withErrors([
                    'profile_picture' => 'Error uploading profile picture: ' . $e->getMessage(),
                ]);
            }
        }

        $user->save();
    }
}
