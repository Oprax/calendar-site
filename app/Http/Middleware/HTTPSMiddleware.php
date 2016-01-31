<?php

namespace App\Http\Middleware;

use Closure;

class HTTPSMiddleware
{
    /**
     * Redirects any non-secure requests to their secure counterparts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return redirects to the secure counterpart of the requested uri.
     */
    public function handle($request, Closure $next)
    {
        if (!$request->secure() && app()->environment('production'))
        {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
