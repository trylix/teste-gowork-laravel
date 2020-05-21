<?php

namespace App\Http\Middleware;

use App\Customer;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetEmployeeByCustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $customer = Customer::findOrFail($request->customer_id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Customer not found.',
            ], 404);
        }

        $request->offsetSet('customer', $customer);

        return $next($request);
    }
}
