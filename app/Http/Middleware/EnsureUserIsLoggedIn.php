<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsLoggedIn
{
    /**
     * Verify that the current visitor has an active demo session.
     * Deny entry and bounce back if no valid session flag exists.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isAuthenticated = $request->session()->has('logged_in');

        if (! $isAuthenticated) {
            return redirect('/')
                ->with('error', 'You must be logged in to perform this action.');
        }

        return $next($request);
    }
}
