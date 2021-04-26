<?php namespace App\Http\Services;

use File;

class UploadFileService {
   
    public function __construct()
    {
    }

    public function uploadFile($file,$path)
    {
        $fullPath = public_path() . "/uploads" .$path;
        $name = preg_replace('/\s+/', '', $file->getClientOriginalName());
        $filename = time() . '_' . $name;

        if (!is_dir($fullPath)) {
            File::makeDirectory($fullPath, 0777, true);
        }
        if ($file->move($fullPath, $filename)) {
            $filePath = "uploads" .$path . '/' . $filename;
            return $filePath;
        } else {
            return NULL;
        }
    }
}