<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;
use Notification;
use Str;
use Session;
use Cache;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Exceptions\Exception;
class NotificationsController extends Controller
{
    public function index()
    {
        // if i need to make all notification readed when i viste notification route
        //auth()->user()->unreadNotifications->markAsRead();
        return view('frontend.dashboard.notifications');
    }
    public function delete(Request $request)
    {

        auth()->user()->notifications()->where('id',$request->notify_id)->delete();

        Session::flash('success', 'Notification deleted successfuly');

        return redirect()->back();
    }
    public function deleteAll(Request $request)
    {
        auth()->user()->notifications()->delete();
        Session::flash('success', 'All Notifications deleted successfuly');

        return redirect()->back();
    }
}
