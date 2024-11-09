<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Autherization;
use App\Utilts\ImageManger;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Str;
use Yajra\DataTables\Exceptions\Exception;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return request();//this equal to Request $request
        $order_by = request()->orderby ?? 'desc'; //insread of adding the request with default like sort by

        $admins = Admin::
            when(request()->keyword ?? null, function ($q) {
                $q->where('name', 'like', '%' . request()->keyword . '%')
                    ->orwhere('email', 'like', '%' . request()->keyword . '%')
                    ->orwhere('username', 'like', '%' . request()->keyword . '%');
            })
            ->when(!is_null(request()->status), function ($q) {
                $q->where('status', request()->status);
            })
            ->orderBy(request('sortby', 'id'), $order_by)
            ->paginate(request('limit', 5));

        return view('admin.admins.index', compact('admins'));
    }
    public function toggleStatus(Admin $admin)
    {
        $admin->status = !$admin->status;
        $admin->save();
        Session::flash('success', 'Status Updated');
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Autherization::all();
        return view('admin.admins.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
            'username' => 'required|min:2|unique:admins,username',
            'status' => 'required|in:0,1',
            'autherization_id' => 'required|exists:autherizations,id'
        ], [], [
            'autherization_id' => 'Role'
        ]);
        $admin = Admin::create($request->except('password_confirmation'));
        Session::flash('success', 'Admin created');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        $roles = Autherization::all();

        return view('admin.admins.edit', compact('admin', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => 'required|min:2',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'nullable|min:8|confirmed',
            'password_confirmation' => 'nullable',
            'username' => 'required|min:2|unique:admins,username,' . $admin->id,
            'status' => 'required|in:0,1',
            'autherization_id' => 'required|exists:autherizations,id'
        ], [], [
            'autherization_id' => 'Role'
        ]);

        if ($request->password) {
            $admin->update($request->except('password_confirmation'));

        } else {
            $admin->update($request->except('password_confirmation', 'password'));

        }
        Session::flash('success', 'Admin Updated');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();
        Session::flash('success', 'Admin deleted');
        return redirect()->route('admin.admins.index');
    }
}
