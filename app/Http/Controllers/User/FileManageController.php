<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileManageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function download($file_url)
    {
        $file_url = decrypt($file_url);
        if (Storage::exists('public/' . $file_url)) {
            $fileExtension = pathinfo($file_url, PATHINFO_EXTENSION);

            if (strtolower($fileExtension) === 'pdf') {
                return response()->file(storage_path('app/public/' . $file_url), [
                    'Content-Disposition' => 'inline; filename="' . basename($file_url) . '"'
                ]);
            } else {
                return response()->download(storage_path('app/public/' . $file_url), basename($file_url));
            }
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }
}
