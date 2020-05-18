<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ImageProcessor - upload image files worker
 * @package App\Helpers
 */
class ImageProcessor
{
    /**
     * Save uploaded image, set model's image path
     * @param UploadedFile $file
     * @param Model $i
     * @param string $imgFolder
     */
    public static function imageSave(UploadedFile $file, Model $i, string $imgFolder) {
        if($path = $i->image)
            self::imageDelete($path);
        $dateName = date('dmyHis');
        $name = $dateName . '.' . $file->getClientOriginalExtension();
        $file->move($imgFolder, $name);
        $i->image = '/'.$imgFolder.'/'.$name;
    }

    /**
     * Delete file by path
     * @param string $path
     */
    public static function imageDelete(string $path) {
        if($path)
            File::delete(trim($path, '/'));
    }
}