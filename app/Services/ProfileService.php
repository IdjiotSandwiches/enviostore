<?php

namespace App\Services;

use App\Interfaces\SessionKeyInterface;
use App\Interfaces\StatusInterface;
use App\Models\ErrorLog;
use App\Models\User;
use App\Utilities\GoogleDriveUtility;
use Illuminate\Support\Facades\Hash;

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
     * @return array|User|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
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
        $user = $this->getUser();

        foreach ($validated as $key => $value) {
            if (!is_null($value)) {
                $user->$key = $value;
            }
        }

        if (isset($validated['profile_picture'])) {
            $fileExtension = $validated['profile_picture']->getClientOriginalExtension();
            $fileName = 'avatars/' . str_replace(' ', '_', $user->uuid) . '.' . $fileExtension;

            $this->googleDriveUtility->storeFile($fileName, $validated['profile_picture']);
            $user->profile_picture = $fileName;
        }
        
        $user->save();
    }

    /**
     * Summary of attemptChangePassword
     * @param array $validated
     * @throws \Exception
     * @return void
     */
    public function attemptChangePassword($validated)
    {
        $user = $this->getUser();

        if (!Hash::check($validated['old_password'], $user->password)) {
            throw new \Exception(__('message.wrong_password'));
        }

        if (Hash::check($validated['password'], $user->password)) {
            throw new \Exception(__('message.same_password'));
        }

        $user->password = Hash::make($validated['password']);
        $user->save();
    }
}
