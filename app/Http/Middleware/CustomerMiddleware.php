<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    /**
     * Ensure the request is from an authenticated customer (or any authenticated user).
     * Admin-side users may also access customer routes if needed.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return redirect()->route('login')
                ->with('error', 'Please log in to continue.');
        }

        return $next($request);
    }
}
