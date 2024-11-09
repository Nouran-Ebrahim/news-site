<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Str;

class SocialLoginController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();

    }
    public function callback($provider)
    {
        try {
            $userGoogle = Socialite::driver($provider)->stateless()->user();
            // firstOrCreate take 2 array first is check that data is exsits so get the frst match if not will create new
            // dd( $userGoogle);
            // updateOrCreate check if the email exsit so update the data in secound array and if the email not found so create the data in secound array
            $user = User::where('email', $userGoogle->getEmail())->first();

            if ($user) {
                Auth::login($user);
                return redirect()->route('frontend.dashboard.profile');

            }
            $username = $this->generateRandomUserName($userGoogle->getName());
            $user = User::create(
                [
                    'name' => $userGoogle->getName(),
                    'email' => $userGoogle->getEmail(),
                    'username' => $username,
                    // 'username' => Str::replace(' ', '', $userGoogle->getName()) . time(),
                    'image' => $userGoogle->getAvatar(),
                    'status' => 1,
                    'country' => null,
                    'city' => null,
                    'street' => null,
                    'phone' => null,
                    'email_verified_at' => now(),
                    'password' => Hash::make(Str::random(8))

                ]
            );

            Auth::login($user);
            return redirect()->route('frontend.dashboard.profile');
        } catch (\Exception $e) {
            return redirect()->route('login');
        }

    }

    protected function generateRandomUserName($name)
    {
        //nouran ebrahim to nouran-ebrahim
        $username = Str::slug($name);
        $count = 1;
        while (User::where('username', $username)->exists()) {
            $username = $username . $count++;
        }
        return $username;
    }
}
