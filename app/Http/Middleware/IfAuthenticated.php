<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IfAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if($request->bearerToken()) {
            Auth::setUser(
                Auth::guard('sanctum')->user()
            );
        }
        return $next($request);
    }
}
