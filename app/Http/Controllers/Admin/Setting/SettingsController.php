<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingsRequest;
use App\Models\Setting;
use App\Utilts\ImageManger;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Str;
use Cache;
use Yajra\DataTables\Exceptions\Exception;
class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }
    public function update(SettingsRequest $request)
    {
        $stettings = Setting::first();
        $stettings->update($request->except('logo', 'favicon'));

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = ImageManger::uploadImage($file, 'uploads/settings', 'uploads');
            $filePath1 = public_path('uploads' . DIRECTORY_SEPARATOR . 'settings' . DIRECTORY_SEPARATOR . $stettings->logo);
            ImageManger::deleteImage($filePath1);
            $stettings->update(
                [
                    'logo' => $fileName,
                ]
            );
        }
        if ($request->hasFile('favicon')) {
            $file = $request->file('favicon');
            $fileName = ImageManger::uploadImage($request->favicon, 'uploads/settings', 'uploads');
            $filePath2 = public_path('uploads' . DIRECTORY_SEPARATOR . 'settings' . DIRECTORY_SEPARATOR . $stettings->favicon);
            ImageManger::deleteImage($filePath2);

            $stettings->update(
                [
                    'favicon' => $fileName,
                ]
            );
        }

        Session::flash('success', 'Settings Updated');
        return redirect()->back();



    }
}
