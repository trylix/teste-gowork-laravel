<?php

namespace App\Http\Controllers\Api;

use App\File;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function store(Request $request)
    {
        $image = $request->file('file');

        try {
            if ($image) {
                $file = new File;
                $file->path = $image->store('images', 'public');
                $file->save();

                return response()->json($file, 201, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 401);
        }
    }
}
