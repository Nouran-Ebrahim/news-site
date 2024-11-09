<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Http\Request;
use Session;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile.index');
    }
    public function update(Request $request)
    {
        $admin = auth('admin')->user();

        $request->validate([
            'name' => 'required|min:2',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
            'username' => 'required|min:2|unique:admins,username,' . $admin->id,
            'status' => 'required|in:0,1',
        ]);
        if (!Hash::check($request->password, $admin->password)) {
            Session::flash('error', 'Sorry you can not update the password is wrong');
            return redirect()->back();

        }
        $admin->update($request->except('password_confirmation'));

        Session::flash('success', 'Profile Updated');
        return redirect()->back();



    }
}
