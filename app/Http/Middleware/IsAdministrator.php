<?php

namespace App\Http\Middleware;

use Closure;

class IsAdministrator
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
        if (\Auth::user()->user_role_id != 1) {
            if ($request->ajax()) {
                return response('Forbidden.', 403);
            } else {
                return redirect()->guest('/');
            }
        }
        return $next($request);
    }
}
