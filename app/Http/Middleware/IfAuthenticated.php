<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IfAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if($request->bearerToken()) {
            $user = Auth::guard('sanctum')->user();
            if($user) Auth::setUser($user);
        }
        return $next($request);
    }
}
