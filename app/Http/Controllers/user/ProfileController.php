<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $identity = session('identity');

        if (!$identity) {
            return redirect()->route('login')->with('error', 'Please log in to access your profile.');
        }
    
        return view('profile.index', compact('identity'));
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
        $image = $profileRequest->validated()->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();

        $response = $this->googleDriveUtility->storeFile($imageName, $image);
        return back()->with($response);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
