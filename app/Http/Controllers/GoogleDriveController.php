<?php

namespace App\Http\Controllers;

use App\Http\Utilities\GoogleDriveUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GoogleDriveController
{
    private $googleDriveUtility;

    public function __construct()
    {
        $this->googleDriveUtility = new GoogleDriveUtility();
    }

    public function index()
    {
        return view('test');
    }

    public function storeFile(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $img = $request->file('image');
        $imgName = time() . '_' . $img->getClientOriginalName();

        $response = $this->googleDriveUtility->storeImage($imgName, $img);
        return back()->with($response);
    }

    public function getFile()
    {
        $img = $this->googleDriveUtility->getImage('1729481441_eupho3-icon10.png');
        return $img;
    }
}
