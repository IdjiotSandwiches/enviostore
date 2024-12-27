<?php

namespace App\Services;

use App\Interfaces\SessionKeyInterface;
use App\Interfaces\StatusInterface;
use App\Models\ErrorLog;
use App\Models\User;
use App\Utilities\GoogleDriveUtility;

class ProfileService implements SessionKeyInterface, StatusInterface
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
        return $user;
    }

    /**
     * Summary of getProfilePicture
     * @return array|string
     */
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

    /**
     * Summary of updateProfile
     * @param array $validated
     * @return void
     */
    public function updateProfile($validated)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = session(self::SESSION_IDENTITY);
        $user = User::find($user->id);

        foreach ($validated as $key => $value) {
            if (!is_null($value)) {
                $user->$key = $value;
            }
        }

        if ($validated['profile_picture']) {
            $fileExtension = $validated['profile_picture']->getClientOriginalExtension();
            $fileName = 'avatars/' . str_replace(' ', '_', $user->uuid) . '.' . $fileExtension;

            $this->googleDriveUtility->storeFile($fileName, $validated['profile_picture']);
            
            $user->profile_picture = $fileName;
        }
        
        $user->save();
    }
}
