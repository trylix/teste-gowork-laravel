<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Office;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function index()
    {
        $offices = Office::all();

        return response()->json($offices);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:offices',
            'city' => 'required',
            'state' => 'required',
            'image' => 'required',
        ]);

        $office = Office::create([
            'name' => $request->name,
            'city' => $request->city,
            'state' => $request->state,
            'image' => $request->image,
        ]);

        return response()->json($office, 201);
    }
}
