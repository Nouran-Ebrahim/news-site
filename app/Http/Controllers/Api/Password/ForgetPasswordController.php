<?php

namespace App\Http\Controllers\Api\Password;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendOtpVirifyUserEmail;
use Illuminate\Http\Request;

class ForgetPasswordController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);
        $user = User::where('email', $request->email)->first();
        $user->notify(new SendOtpVirifyUserEmail('Rest Password code check your email'));
        return apiResponse(200, 'Rest Password code send');

    }
}
