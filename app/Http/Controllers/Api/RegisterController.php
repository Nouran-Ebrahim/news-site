<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Jobs\SendOtpTsk;
use App\Models\User;
use App\Notifications\SendOtpVirifyUserEmail;
use App\Utilts\ImageManger;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Log;

class RegisterController extends Controller
{
    protected $otp;
    public function __construct()
    {
        $this->otp = new Otp();

    }
    public function register(UserRequest $request)
    {
        try {
            DB::beginTransaction();
            $request->merge([
                'password' => bcrypt($request->password), // we can add in the cast of the model that password hased so automaticly hash the passsword
            ]);
            $user = User::create($request->except('image', 'password_confirmation'));

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = ImageManger::uploadImage($file, 'uploads/users', 'uploads');
                $user->update([
                    'image' => $fileName //store the path but the right is to store the name
                ]);
            }

            $token = $user->createToken('auth_token', [], now()->addMinutes(60))->plainTextToken; // if we need to make the user go to profile direct without login
            // SendOtpTsk::dispatch($user); // this will save a job in the job table and not excute the job so we need to start the queue to ecxute the job and send the otp to the mailtrap (queue:work) then it will be removed from the jobs table
            $user->notify(new SendOtpVirifyUserEmail('Email verification code.')); // other tasks no depend on this task so we can add it in the queu
            // SendOtpTsk we can use the notficarion class that send the otp to make the queue job insted of the job class we need to add that notficaton implemets shouldqueue
            DB::commit();
            return apiResponse(201, 'user created', ['token' => $token]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('error from registeration : ' . $e->getMessage());
            return apiResponse(500, 'inr=ternal server error');

        }

    }
    public function emailVerfication(Request $request)
    {
        $request->validate([
            'token' => 'required',
        ]);
        $user = auth()->user();

        $otp2 = $this->otp->validate($user->email, $request->token);
        if ($otp2->status == false) {

            return apiResponse(400, 'code is in vaild');

        }
        $user->update([
            'email_verified_at' => now()
        ]);
        return apiResponse(200, 'Email verified sucssfully');

    }
    public function sendOtpAgain()
    {
        $user = auth()->user();
        $user->notify(new SendOtpVirifyUserEmail('Email verification code.'));
        return apiResponse(200, 'otp send again');

    }
}
