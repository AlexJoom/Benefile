<?php

namespace App\Http\Middleware;

use Closure;

class IsEnabled
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
        if (\Auth::user()->activation_status != 1 and \Auth::user()->is_deactivated != 0) {
            if ($request->ajax()) {
                return response('Forbidden.', 403);
            } else {
                return redirect()->guest('disabledUser');
            }
        }
        if (\Auth::user()->activation_status != 1 and \Auth::user()->is_deactivated != 1) {
            if ($request->ajax()) {
                return response('Forbidden.', 403);
            } else {
                return redirect()->guest('awaitingActivation');
            }
        }
        return $next($request);
    }
}
