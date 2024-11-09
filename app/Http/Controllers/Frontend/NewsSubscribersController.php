<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\Frontend\NewsSubscriberMail;
use App\Models\NewsSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Session;

class NewsSubscribersController extends Controller
{
    public function storeSubscriber(Request $request)
    {
        //validate make automatic redirection with errors to the blade file but validator not make that
        $request->validate([
            'email' => 'required|email|unique:news_subscribers,email'
        ]);

        $status = NewsSubscriber::create([
            'email' => $request->email
        ]);
        if (!$status) {
            Session::flash('error', 'please try again');
            return redirect()->back();
        }

        Mail::to($request->email)->send(new NewsSubscriberMail());
        Session::flash('success', 'you have been subscribed successfully');
        return redirect()->back();

    }
}
