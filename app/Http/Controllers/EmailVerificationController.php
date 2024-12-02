<?php

namespace App\Http\Controllers;

use App\Interfaces\StatusInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller implements StatusInterface
{
    /**
     * Return verification notice
     * @return mixed|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function verificationNotice()
    {
        if (Auth::user()->hasVerifiedEmail()) {
            return to_route('home');
        }

        return view('auth.verify-email');
    }

    /**
     * Verify email
     * @param \Illuminate\Foundation\Auth\EmailVerificationRequest $request
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();
        
        $response = [
            'status' => self::STATUS_SUCCESS,
            'message' => 'Account has been verified.',
        ];

        return to_route('home')->with($response);
    }

    /**
     * Resend verification email
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendVerification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }
}
