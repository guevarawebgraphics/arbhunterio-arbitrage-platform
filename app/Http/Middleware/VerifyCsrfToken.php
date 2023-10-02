<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];
    
    public function handle($request, \Closure $next)
    {
        $response = $next($request);
       
        if (!is_null($response) && last(explode('\\', get_class($response))) != 'RedirectResponse') {
            $response->header('P3P', 'CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
        }

        if ($response instanceof Response) {
            return $response->withHeaders([
                'P3P' => 'CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"'
            ]);
        }

        return $response ?: new \Symfony\Component\HttpFoundation\Response();
    }
}
