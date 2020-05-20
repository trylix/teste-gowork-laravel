<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Tymon\JWTAuth\Facades\JWTAuth;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
          } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
              return response()->json(['message' => 'Token is invalid']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {

              return response()->json(['message' => 'Token is expired']);
            } else {
              return response()->json(['message' => 'Authorization Token not found']);
            }
          }

          return $next($request);
    }
}
