<?php

namespace Modules\Agent\Http\Middleware;

use App\Http\Helpers\Common;
use App\Traits\ApiResponse;
use Closure;


class CheckAgentInactive
{
    use ApiResponse;

    public function handle($request, Closure $next)
    {
        // if user inactive wouldn't be able to login
        $prefix = str_replace('/', '', request()->route()->getPrefix());

        $agent = auth('agent-v2')->user() ?? auth('agent')->user();
        
        if (empty($agent)) {
            if (str_contains($prefix, 'apiv2')) {
                return $this->unauthorizedResponse([], __("Agent not found."));
            }

            auth('agent')->logout();
            Common::one_time_message('danger', __('Agent not found.'));
            return redirect('/agent');
        }

        $status = Common::getUserStatus($agent->status);

        if ($status == 'Inactive') {

            if (str_contains($prefix, 'apiv2')) {
                return $this->unauthorizedResponse([], __("Inactive"));
            }

            auth('agent')->logout();
            Common::one_time_message('danger', __('Your account has been deactivated. Please retry later'));
            return redirect('/agent');
        }

        return $next($request);
    }
}
