<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function uploadImageSummernote(Request $request)
    {
        $ext = $request->file->getClientOriginalExtension();

        $directory = 'public/files/';
        switch ($ext) {
            case 'pdf':
                $directory .= 'pdf/';
                break;
            case 'jpg':
            case 'jpeg':
            case 'png':
                $directory .= 'images/';
                break;
            default:
                $directory .= 'misc/';
                break;
        }

        if (!Storage::exists($directory)) {
            Storage::makeDirectory($directory);
        }

        $originalName = str_replace(' ', '_', pathinfo($request->file->getClientOriginalName(), PATHINFO_FILENAME));

        $filename = $originalName . '_' . time() . '.' . $ext;

        $save = Storage::putFileAs($directory, $request->file, $filename);

        if ($save) {
            $relativePath = str_replace('public/', '', $directory);

            return [
                "status" => "success",
                "path" => $relativePath,
                "image" => $filename,
                "image_url" => Storage::url($directory . $filename)
            ];
        } else {
            return [
                "status" => "fail"
            ];
        }
    }

    public function deleteImageSummernote(Request $request)
    {
        $urlParts = parse_url($request->target);
        $path = ltrim($urlParts['path'], '/');
        
        $path = preg_replace('/^storage\//', '', $path);
        
        $deleteStorage = Storage::disk('public')->delete($path);
    
        if ($deleteStorage) {
            return [
                "status" => "success"
            ];
        } else {
            return [
                "status" => "error"
            ];
        }
    }
}
