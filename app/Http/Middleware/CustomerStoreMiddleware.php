<?php

namespace App\Http\Middleware;

use App\Helpers\Helper;
use App\Office;
use App\Plan;
use Closure;

class CustomerStoreMiddleware
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
        $request->validate([
            'name' => 'required',
            'is_company' => 'required',
            'document' => 'required|unique:customers',
            'office_id' => 'required',
            'plan_id' => 'required',
        ]);

        $isCpf = $request->is_company === '0';
        $document = $request->document;

        $cpf = Helper::validCpf($document);
        $cnpj = Helper::validCnpj($document);

        if (($isCpf && !$cpf) || (!$isCpf && !$cnpj)) {
            return response()->json([
                'error' => 'Invalid document.',
            ], 401);
        }

        $office = Office::find(request('office_id'));
        if ($office === null) {
            return response()->json([
                'error' => 'Office not found.',
            ], 401);
        }

        $plan = Plan::find(request('plan_id'));
        if ($plan === null) {
            return response()->json([
                'error' => 'Plan not found.',
            ], 401);
        }

        return $next($request);
    }
}
