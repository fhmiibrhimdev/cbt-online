<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function uploadImageSummernote(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png|max:2048', // Hanya izinkan file jpg, jpeg, png, pdf dengan ukuran maksimum 2MB
        ]);

        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();

        $directory = 'public/files/';
        switch ($ext) {
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

        // Simpan file dan tangani jika terjadi kesalahan
        try {
            $save = Storage::putFileAs($directory, $file, $filename);

            if ($save) {
                $relativePath = str_replace('public/', '', $directory);

                return response()->json([
                    "status" => "success",
                    "path" => $relativePath,
                    "image" => $filename,
                    "image_url" => Storage::url($directory . $filename)
                ]);
            } else {
                return response()->json([
                    "status" => "fail",
                    "message" => "File gagal disimpan."
                ], 500);
            }
        } catch (\Exception $e) {
            // Tangani kesalahan saat menyimpan file
            return response()->json([
                "status" => "fail",
                "message" => "Terjadi kesalahan: " . $e->getMessage()
            ], 500);
        }
    }

    public function deleteImageSummernote(Request $request)
    {
        // Validasi input request
        $request->validate([
            'target' => 'required|url'
        ]);

        // Ambil path dari URL yang diterima
        $urlParts = parse_url($request->target);
        $path = ltrim($urlParts['path'], '/');

        // Hapus prefix 'storage/' dari path
        $path = preg_replace('/^storage\//', '', $path);

        // Pastikan path valid dan tidak menyebabkan eksploitasi path traversal
        if (preg_match('/\.\./', $path)) {
            return response()->json([
                "status" => "error",
                "message" => "Invalid file path."
            ], 400);
        }

        // Hapus file dari storage
        try {
            $deleteStorage = Storage::disk('public')->delete($path);

            if ($deleteStorage) {
                return response()->json([
                    "status" => "success"
                ]);
            } else {
                return response()->json([
                    "status" => "error",
                    "message" => "File not found or could not be deleted."
                ], 404);
            }
        } catch (\Exception $e) {
            // Tangani kesalahan saat menghapus file
            return response()->json([
                "status" => "error",
                "message" => "An error occurred: " . $e->getMessage()
            ], 500);
        }
    }
}
