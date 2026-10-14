<?php

namespace Modules\Agent\Http\Middleware;

use App\Http\Helpers\Common;
use App\Traits\ApiResponse;
use Closure;


class CheckAgentSuspended
{
    use ApiResponse;
    
    public function handle($request, Closure $next)
    {
        // if user suspended can't do any transactions
        $agent = auth('agent-v2')->user() ?? auth('agent')->user();
       
        $user = Common::getUserStatus($agent->status);

        if ($user == 'Suspended') {
            $prefix = str_replace('/', '', request()->route()->getPrefix());
            if (str_contains($prefix, 'apiv2')) {
                return $this->badRequestResponse([], __("Suspended"));
            }

            return redirect('agent/check-agent-status');
        }
        return $next($request);
    }
}
