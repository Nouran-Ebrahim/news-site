<?php

namespace App\Http\Controllers\Admin\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // if i need to make all notification readed when i viste notification route
        //auth('admin')->user()->unreadNotifications->markAsRead();
        return view('admin.notifications.index');
    }
}
