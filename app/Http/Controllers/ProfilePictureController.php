<?php

namespace App\Http\Controllers;

use App\Interfaces\StatusInterface;
use App\Utilities\GoogleDriveUtility;
use Illuminate\Http\Request;

class ProfilePictureController extends Controller implements StatusInterface
{
    private $googleDriveUtility;

    public function __construct()
    {
        $this->googleDriveUtility = new GoogleDriveUtility();
    }

    public function getProfilePicture($path)
    {
        if (!request()->ajax()) abort(404);

        $img = $this->googleDriveUtility->getFile($path);

        return response()->json([
            'status' => self::STATUS_SUCCESS,
            'message' => 'Profile picture retrieved!',
            'data' => $img,
        ]);
    }
}
