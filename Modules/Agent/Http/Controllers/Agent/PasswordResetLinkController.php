<?php

namespace Modules\Agent\Http\Controllers\Agent;

use Exception;
use App\Http\Helpers\Common;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class PasswordResetLinkController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('agent::agent.auth.forgot-password');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $data = executeNoAuthAgentPostApi('forgot-password', $request);
            Common::one_time_message('success', __($data['message']));
            return redirect()->route('agent.password.request');
        } catch (Exception $e) {
            Common::one_time_message('error', $e->getMessage());
            return redirect()->route('agent.password.request');
        }
    }
}
