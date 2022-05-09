<?php

namespace App\Http\Middleware;

use Closure;

class AddIdToRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $pf = $request->path();
        $parts = explode('/', $pf);
        $id = $parts[count($parts) - 1];
        $request->request->add(['id' => $id]);
        return $next($request);
    }
}
