<?php

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

if (!function_exists('webpUploadImage')) {
    function webpUploadImage($upload, $path, $resize_width = 120, $resize_height = 120)
    {
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        $filename = rand() . time() . '.' . $upload->getClientOriginalExtension();
        $filePath = '/' . $path . '/' . $filename;
        if ($resize_width || $resize_height) {
            $img = Image::make($upload)->resize($resize_width, $resize_height)->encode($upload->getClientOriginalExtension(), 100);
        } else {
            $img = Image::make($upload);
        }
        $img->save(public_path($filePath));
        return $filePath;
    }
}

if (!function_exists('deleteImage')) {
    function deleteImage($path)
    {
        if (file_exists($path)) {
            $delete = File::delete($path);
            if ($delete) return 1;
        }
        return 0;
    }
}

