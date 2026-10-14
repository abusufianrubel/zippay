<?php

namespace Modules\Agent\Http\Controllers\Api\V2;

use Exception;
use App\Event\LoginActivity;
use App\Exceptions\Api\V2\LoginException;
use App\Http\Controllers\Controller;
use App\Http\Resources\V2\PreferenceResource;
use Illuminate\Support\Facades\Event;
use Modules\Agent\Http\Requests\LoginRequest;
use Modules\Agent\Transformers\AgentResource;

class AgentController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        try {
            $request->authenticate();

            $agent = auth('agent')->user();

            if ('Inactive' === $agent->status) {
                return $this->unprocessableResponse([], __('This account is Blocked.'));
            }

            Event::dispatch(new LoginActivity($agent, 'Agent'));

            $data['agent'] = new AgentResource($agent);
            $data['token'] = getAccessToken($agent);

            return $this->successResponse($data);
        } catch (LoginException $e) {
            return $this->unprocessableResponse([], $e->getMessage());
        } catch (Exception $e) {
            return $this->unprocessableResponse([], $e->getMessage());
        }
    }

    public function preferenceSettings()
    {
        return $this->okResponse(new PreferenceResource(null));
    }
}
