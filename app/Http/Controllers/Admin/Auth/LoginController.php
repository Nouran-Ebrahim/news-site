<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Session;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest:admin'])->only(['showLoginForm', 'login']);
        $this->middleware(['auth:admin'])->only(['logout']);

    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
            'remmber' => 'in:on,off'
        ]);

        if (auth()->guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remmber)) {
            if (auth('admin')->user()->status == 0) {
                Session::flash('error', 'You are not active admin');
                auth()->guard('admin')->logout();
                return redirect()->back();
            }
            $permessions = auth('admin')->user()->role->permessions;
            $firstPermssssion = $permessions[0];
            Session::flash('success', 'logged successfuly');

            if (!in_array('home', $permessions)) {
                return redirect()->intended('admin/' . $firstPermssssion);

            }
            return redirect()->intended(RouteServiceProvider::ADMIN);

        }
        Session::flash('error', 'credentials does not match');

        return redirect()->back();
    }
    public function logout()
    {
        auth()->guard('admin')->logout();
        Session::flash('success', 'logged out successfuly');
        return redirect()->route('admin.showLoginForm');

    }
}
