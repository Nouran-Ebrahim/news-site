<?php

namespace App\Utilts;
use Str;
use File;

class ImageManger
{
    //we add static to call method uploadImage direct without tacking object from the class
    public static function uploadImage($image,$folder,$disk)
    {
        $file = $image;
        // if the imges has same extention will store one image only in the folder so we use uuid instead of slug
        // $fileName = $post->slug . time() . $file->getClientOriginalExtension();
        $fileName = Str::uuid() . time() . $file->getClientOriginalExtension();
        $path = $file->storeAs($folder, $fileName, ['disk' => $disk]);

        return $fileName;
    }
    public static function deleteImage($filePath)
    {
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
    }
}
