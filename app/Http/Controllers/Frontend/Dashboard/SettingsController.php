<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\SettingsRequest;
use App\Utilts\ImageManger;
use Hash;
use Illuminate\Http\Request;
use Log;
use Str;
use Session;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Exceptions\Exception;
class SettingsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('frontend.dashboard.settings', compact('user'));
    }
    public function update(SettingsRequest $request)
    {
        // $request->validated(); // to make automatic redirection
        $user = auth()->user();
        $data = $request->except('image');
        $user->update($data);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filePath = public_path('uploads' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . $user->image);
            ImageManger::deleteImage($filePath);
            $fileName = ImageManger::uploadImage($image, 'uploads/users', 'uploads');
            $user->update(['image' => $fileName]);
        }

        // Session::flash('success', 'User Updated successfuly');

        return redirect()->back()->with('success', 'User Updated successfuly');
    }
    public function updatePassword(Request $request)
    {
        $request->validate($this->filterPasswordRequest());
        $user = auth()->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Current password not matched');

        }

        $user->update(['password' => Hash::make($request->password)]);
        return redirect()->back()->with('success', 'Password Updated successfuly');

    }

    private function filterPasswordRequest(): array
    {
        return [
            'current_password' => 'required',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => 'required'

        ];
    }
}
