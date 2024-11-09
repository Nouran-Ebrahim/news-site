<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Utilts\ImageManger;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Str;
use Yajra\DataTables\Exceptions\Exception;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return request();//this equal to Request $request
        $order_by = request()->orderby ?? 'desc'; //insread of adding the request with default like sort by

        $users = User::
            when(request()->keyword ?? null, function ($q) {
                $q->where('name', 'like', '%' . request()->keyword . '%')
                    ->orwhere('email', 'like', '%' . request()->keyword . '%');
            })
            ->when(!is_null(request()->status), function ($q) {
                $q->where('status', request()->status);
            })
            ->orderBy(request('sortby', 'id'), $order_by)
            ->paginate(request('limit', 5));

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        // dd($request->all()) ;
        try {
            DB::beginTransaction();

            $request->merge([
                'email_verified_at' => $request->email_verified_at == 1 ? now() : null,
                'password' => bcrypt($request->password), // we can add in the cast of the model that password hased so automaticly hash the passsword
            ]);
            $user = User::create($request->except('image', 'password_confirmation'));

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = ImageManger::uploadImage($file, 'uploads/users', 'uploads');
                $user->update([
                    'image' => $fileName //store the path but the right is to store the name
                ]);
            }
            DB::commit();
            Session::flash('success', 'User created');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $filePath = public_path('uploads' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . $user->image);
        // dd($filePath);
        ImageManger::deleteImage($filePath);
        $user->delete();
        Session::flash('success', 'User deleted');
        return redirect()->route('admin.users.index');
    }
    public function toggleStatus(User $user)
    {
        $user->status = !$user->status;
        $user->save();
        Session::flash('success', 'Status Updated');
        return redirect()->back();
    }
}
