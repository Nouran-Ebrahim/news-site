<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            "email" => 'email|required|string',
            'password' => 'required|string|min:8',
        ]);

        // attemp create a session and we need to genreate token based authantication
        $user = User::where('email', $request->email)->first();

        if ($user && \Hash::check($request->password, $user->password)) {

            $token = $user->createToken('auth_token', [], now()->addMinutes(60))->plainTextToken;
            return apiResponse(200, 'login success', ['token' => $token]);


        }
        // to get the user we use $request->user() or request()->user() or Auth::guard('sanctum')->user() or auth()->user() without any gaurd as sancutm know the loggend user form the token as sancutom save tokens in databas and compare between token in data base and sended with request
        return apiResponse(200, 'wrong creditionals');
    }
    public function logout(Request $request)
    {
        $user = $request->user();
        // $user->tokens()->delete(); // will romve all tokens (log out from all mobiles)
        $user->currentAccessToken()->delete(); // to delete only token gived
        return apiResponse(200, 'logout success');
    }
}