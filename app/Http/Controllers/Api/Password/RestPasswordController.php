<?php

namespace App\Http\Controllers\Api\Password;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Ichtrojan\Otp\Otp;

class RestPasswordController extends Controller
{ protected $otp;
    public function __construct()
    {
        $this->otp = new Otp();

    }
    public function rest(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $otp2 = $this->otp->validate($request->email, $request->otp);
        if ($otp2->status == false) {

            return apiResponse(400, 'code is in vaild');

        }
        $user = User::where('email', $request->email)->first();

        $user->password = bcrypt($request->password);
        $user->save();
        return apiResponse(200, 'Password updated');

    }
}
