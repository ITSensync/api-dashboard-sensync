<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ApiRoutesController extends Controller
{
    public function getRoutes()
    {
        $path = public_path('api_routes.json'); // Sesuaikan path jika diperlukan
        if (File::exists($path)) {
            $json = File::get($path);
            return response()->json(json_decode($json, true));
        } else {
            return response()->json(['status' => 'Error', 'message' => 'File not found'], 404);
        }
    }
}
