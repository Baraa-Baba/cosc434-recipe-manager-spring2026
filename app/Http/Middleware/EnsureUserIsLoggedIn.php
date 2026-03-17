<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * Check whether the session indicates a logged-in state.
     * If not logged in, redirect to the recipes index with an error message.
     * If logged in, allow the request to continue.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->get('logged_in')) {
            return redirect()->route('recipes.index')
                ->with('error', 'Access denied. Please log in first.');
        }

        return $next($request);
    }
}
