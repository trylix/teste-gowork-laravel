<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Middleware\GetEmployeeByCustomerMiddleware;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware(GetEmployeeByCustomerMiddleware::class)->only([
            'index',
            'store',
        ]);
    }

    public function index()
    {
        $customer = request()->offsetGet('customer');

        $employees = Employee::where('customer_id', $customer->id)->get();

        return response()->json($employees->load('customer'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'customer_id' => 'required',
        ]);

        $customer = request()->offsetGet('customer');

        $employee = Employee::create([
            'name' => $request->name,
            'customer_id' => $customer->id,
        ]);

        return response()->json($employee->load('customer'), 201);
    }
}
