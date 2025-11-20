<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecureAccess
{
    public function handle(Request $request, Closure $next)
    {
        // Allowed URLs without authentication
        $allowed = [
            'secure',
            'secure/login',
            'secure/set',
        ];

        // Allow only allowed routes
        if (in_array($request->path(), $allowed)) {
            return $next($request);
        }

        // Check authentication session
        if (session('authenticated') === true) {
            return $next($request);
        }

        // Block everything else
        return redirect('/secure');
    }
}
