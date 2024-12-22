<?php

namespace App\Services;

use App\Interfaces\SessionKeyInterface;
use App\Models\User;
use App\Utilities\GoogleDriveUtility;

class ProfileService implements SessionKeyInterface
{
    private $googleDriveUtility;
    public function __construct()
    {
        $this->googleDriveUtility = new GoogleDriveUtility();
    }

    public function getUser()
    {
        /**
         * @var User
         */
        $user = session(self::SESSION_IDENTITY);
        $url = User::find($user->id)->profile_picture;
        $profilePicture = $this->googleDriveUtility->getFile($url);

        return [$user, $profilePicture];
    }

    public function updateProfile($profileRequest)
    {
        /**
         * @var User id
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

        return $user;
    }
}
