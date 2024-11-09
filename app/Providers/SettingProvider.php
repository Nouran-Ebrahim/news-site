<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\RelativeSite;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class SettingProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //check if settings exsist so if not do the call back fun
        $getSettings = Setting::firstOr(function () {
            return Setting::create([
                'site_name' => 'news',
                'email' => 'news@gmail.com',
                'logo' => '/img/logo.png',
                'favicon' => 'default',
                'facebook' => 'https://web.facebook.com/',
                'twitter' => 'https://web.twitter.com/',
                'youtube' => 'https://web.youtube.com/',
                'instgram' => 'https://web.instagram.com/',
                'phone' => '01223701860',
                'country' => 'Egypt',
                'city' => 'Alex',
                'street' => 'mostafa sabry',
                'small_desc'=>'small description for seo for the website'

            ]);
        });
        $categories=Category::select('id','slug','name')->where('status',1)->get();
        $rlativeSites=RelativeSite::select('name','url')->get();
        view()->share(['getSettings' => $getSettings,
        'rlativeSites'=>$rlativeSites,
    'categories'=>$categories]);

    }
}
