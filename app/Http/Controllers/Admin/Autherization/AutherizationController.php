<?php

namespace App\Http\Controllers\Admin\Autherization;

use App\Http\Controllers\Controller;
use App\Models\Autherization;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Str;
use Cache;
use Yajra\DataTables\Exceptions\Exception;
class AutherizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return request();//this equal to Request $request
        $order_by = request()->orderby ?? 'desc'; //insread of adding the request with default like sort by

        $autherizations = Autherization::
            when(request()->keyword ?? null, function ($q) {
                $q->where('name', 'like', '%' . request()->keyword . '%');
            })
            ->orderBy(request('sortby', 'id'), $order_by)
            ->paginate(request('limit', 5));

        return view('admin.autherization.index', compact('autherizations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.autherization.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'permessions' => 'required|array|min:1'
        ]);
        $autherization = new Autherization();
        $autherization->role = $request->role;

        $autherization->permessions = json_encode($request->permessions);//to convert array to json object
        $autherization->save();
        Session::flash('success', 'Role created successfuly');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Autherization $autherization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Autherization $autherization)
    {
        return view('admin.autherization.edit', compact('autherization'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Autherization $autherization)
    {
        $request->validate([
            'role' => 'required',
            'permessions' => 'required|array|min:1'
        ]);

        $autherization->role = $request->role;
        $autherization->permessions = json_encode($request->permessions);//to convert array to json object
        $autherization->save();
        Session::flash('success', 'Role Updated successfuly');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Autherization $autherization)
    {
        if ($autherization->admins) {
            Session::flash('error', 'Role is used by admin');
            return redirect()->back();
        }
        $autherization->delete();
        Session::flash('success', 'Role deleted');
        return redirect()->route('admin.autherizations.index');
    }
}
