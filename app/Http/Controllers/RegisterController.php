<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    /**
     * Return Register View
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('register');
    }

    public function register(RegisterRequest $registerRequest)
    {
        $validated = $registerRequest->validated();

        try {

        } catch (\Exception $e) {

        }
    }
}
