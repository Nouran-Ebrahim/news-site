<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use App\Utilts\ImageManger;
use Hash;

use Illuminate\Http\Request;
use App\Http\Requests\Frontend\SettingsRequest;

class SettingsController extends Controller
{
    public function updateSettings(SettingsRequest $request)
    {
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
        return apiResponse('200', 'profile updated');

    }
    public function passwordUpdate(Request $request)
    {
        $request->validate($this->filterPasswordRequest());
        $user = auth()->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return apiResponse('400', 'current password does not match');

        }

        $user->update(['password' => Hash::make($request->password)]);
        return apiResponse('200', 'password updated');

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
