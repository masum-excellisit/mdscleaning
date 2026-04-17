<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Allow access only to users with one of the admin-side roles.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('admin.login')
                ->with('error', 'Please log in to access the admin panel.');
        }

        $adminRoles = ['super-admin', 'admin', 'manager', 'content-editor', 'order-manager'];

        if (! $user->hasAnyRole($adminRoles)) {
            abort(403, 'You do not have permission to access the admin panel.');
        }

        if ($user->status === 'banned') {
            auth()->logout();
            return redirect()->route('admin.login')
                ->with('error', 'Your account has been disabled.');
        }

        return $next($request);
    }
}
