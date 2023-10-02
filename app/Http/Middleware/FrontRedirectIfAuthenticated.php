<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class FrontRedirectIfAuthenticated
 * @package App\Http\Middleware
 * @author Richard Guevara
 */
class FrontRedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (auth()->guard($guard)->check()) {
            if (session()->get('logged_in_from') == 'admin') {
                return redirect('/admin/dashboard');
            } elseif (session()->get('logged_in_from') == 'normal') {
                return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}
