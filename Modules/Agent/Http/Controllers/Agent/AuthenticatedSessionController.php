<?php

namespace Modules\Agent\Http\Controllers\Agent;

use App\Models\Preference;
use App\Event\LoginActivity;
use App\Http\Helpers\Common;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    Auth,
    Event,
    Artisan,
    Session
};
use Illuminate\Http\RedirectResponse;
use Modules\Agent\Http\Requests\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('agent::agent.auth.login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $login_type = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'formatted_phone';

        if (Auth::guard('agent')->attempt([$login_type => $request->input('email'), 'password' => $request->input('password')],$request->boolean('remember'))) {

            $agent = auth('agent')->user();

            if ('Inactive' === $agent->status) {
                auth('agent')->logout();
                Common::one_time_message('danger', __('You are Blocked.'));
                return redirect()->route('agent');
            }

            $preferences = Preference::get();

            if (!empty($preferences)) {
                foreach ($preferences as $pref) {
                    $pref_arr[$pref->field] = $pref->value;
                }
            }

            if (!empty($preferences)) {
                Session::put($pref_arr);
            }

            Event::dispatch(new LoginActivity($agent, 'Agent'));

            return redirect()->route('agent.dashboard');
        } else {
            Common::one_time_message('danger', __('Please Check Your Email/Password'));
            return redirect()->route('agent');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('agent')->logout();
        Artisan::call('optimize:clear');
        session()->forget('agentAccessToken');
        return redirect()->route('agent');
    }
}