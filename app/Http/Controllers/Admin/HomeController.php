<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Session;

class HomeController extends Controller
{
    public function index(){

        $chart_options = [
            'chart_title' => 'Posts by months',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Post',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'line',

            'filter_field' => 'created_at',
            'filter_days' => 360, // show only last 30 days
        ];
        $chart1 = new LaravelChart($chart_options);

        $chart_options_user = [
            'chart_title' => 'Users by months',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\User',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'bar',

            'filter_field' => 'created_at',
            'filter_days' => 360, // show only last 30 days
        ];
        $chart2 = new LaravelChart($chart_options_user);
        return view('admin.index',compact('chart1','chart2'));
    }
    public function deleteNotification(Request $request){
        auth('admin')->user()->notifications()->where('id',$request->notify_id)->delete();

        Session::flash('success', 'Notification deleted successfuly');

        return redirect()->back();
    }
    public function deleteAll(Request $request)
    {
        // dd(1);
        auth('admin')->user()->notifications()->delete();
        Session::flash('success', 'All Notifications deleted successfuly');

        return redirect()->back();
    }
}
