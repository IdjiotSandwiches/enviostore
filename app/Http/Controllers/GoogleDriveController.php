<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GoogleDriveController extends Controller
{
    public function storeFile()
    {
        Storage::disk('google')->put('file.txt', 'Hello, World!');
        return response()->json(['message' => 'File uploaded successfully']);
    }

    public function getFile()
    {
        $fileContent = Storage::disk('google')->read('file.txt');
        return response($fileContent, 200)->header('Content-Type', 'text/plain');
    }
}
