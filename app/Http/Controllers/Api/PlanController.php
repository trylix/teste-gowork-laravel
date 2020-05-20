<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
      $plans = Plan::all();

      return response()->json($plans);
    }

    public function store(Request $request)
    {
      $request->validate([
        'name' => 'required|unique:plans',
        'monthly_cost' => 'required',
      ]);

      $plan = Plan::create([
        'name'=> $request->name,
        'monthly_cost'=> $request->monthly_cost,
      ]);

      return response()->json($plan, 201);
    }
}
