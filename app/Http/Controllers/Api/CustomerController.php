<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Middleware\CustomerStoreMiddleware;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware(CustomerStoreMiddleware::class)->only([
            'store',
        ]);
    }

    public function index()
    {
        $customers = Customer::all();

        return response()->json($customers->load(['office', 'plan']));
    }

    public function store(Request $request)
    {
        $customer = Customer::create([
            'name' => $request->name,
            'is_company' => $request->is_company,
            'document' => $request->document,
            'office_id' => $request->office_id,
            'plan_id' => $request->plan_id,
        ]);

        return response()->json(
            $customer->load(['office', 'plan']),
            201
        );
    }
}
