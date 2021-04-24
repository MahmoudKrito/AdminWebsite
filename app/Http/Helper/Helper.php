<?php
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

if (!function_exists('webpUploadImage')) {
    function webpUploadImage($upload, $path, $resize_width = null, $resize_height = null)
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

if (!function_exists('jsonResponse')) {
    function jsonResponse($message, $data, $status)
    {
        $res = [
            'msg' => $message,
            'data' => $data,
        ];
        return response()->json($res, $status);
    }
}

if (!function_exists('getExistAttribute')) {
    function getExistAttribute($colName)
    {
        $lang = app()->getLocale();
        if ($colName && $lang != 'en') {
            return $colName . '_' . $lang;
        }
        return $colName;
    }
}

if (!function_exists('getExistData')) {
    function getExistData($colName, $value, $model)
    {
        $current_lang = app()->getLocale();
        if ($current_lang != 'en') {
            $value1 = $colName . '_' . $current_lang;
            $result = $model->$value1;
        } else {
            $result = $value;
        }
        if ($result) {
            return $result;
        } else {
            foreach (config('setting.languages') as $lang) {
                if ($lang != $current_lang) {
                    if ($lang != 'en') {
                        $value2 = $colName . '_' . $lang;
                        $result = $model->$value2;
                    } else {
                        $value2 = $colName;
                        $result = $value;
                    }
                    if ($result) {
                        return $result;
                    }
                }
            }
        }
    }
}

if (!function_exists('checkRelation')) {
    function checkRelation($model, $relations)
    {
        foreach ($relations as $relation) {
            if ($model->has($relation)) {
                $result = count($model->$relation);
                if ($result <= 0) {
                    return 0; // when model has not relation
                } else {
                    return 1; // when model has relation
                }
            } else {
                return -1; // when model has not relation
            }
        }
    }
}
