<?php

namespace Modules\Agent\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;


class CheckAgentAuthenticate
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {

        if (!isset(auth('agent-v2')->user()->id)) {
           return $this->unauthorizedResponse([], 'unauthenticated.');
        }

        isset($request->lang) ? app()->setLocale($request->lang) : app()->setLocale('en');
       
        return $next($request);
    }
}
