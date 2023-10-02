<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class FrontMiddleware
 * @package App\Http\Middleware
 * @author Guevara Web Graphics Studio
 */
class FrontMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = NULL)
    {
        if (!auth()->check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('/user/login');
            }
        }

        
    }
}