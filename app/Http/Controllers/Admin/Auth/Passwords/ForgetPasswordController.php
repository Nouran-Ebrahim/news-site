<?php

namespace App\Http\Controllers\Admin\Auth\Passwords;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Notifications\SendOtpNotify;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Exceptions\Exception;
use Ichtrojan\Otp\Otp;

class ForgetPasswordController extends Controller
{
    public function showEmailForm()
    {
        return view('admin.auth.passwords.email');
    }
    public function sendOtp(Request $request)
    {

        $request->validate([
            'email' => 'required|email'
        ]);
        $admin = Admin::where('email', $request->email)->first();
        if (!$admin) {
            return redirect()->back()->withErrors(['email' => 'try again later!']);
        }
        $admin->notify(new SendOtpNotify());
        return redirect()->route('admin.password.showConfirmForm', ['email' => $admin->email]);

    }
    public function showConfirmForm($email)
    {
        return view('admin.auth.passwords.confirm', compact('email'));
    }

    public function verifyOtp(Request $request)
    {

        $request->validate([
            'token' => 'required|min:5',
            'email' => 'required|email'
        ]);
        $otp = (new Otp)->validate($request->email, $request->token);
        if ($otp->status == false) {
            return redirect()->back()->withErrors(['token' => $otp->message]);

        }
        return redirect()->route('admin.password.showRestForm',['email' => $request->email]);

    }
}
