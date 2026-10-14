<?php

namespace Modules\Agent\Http\Controllers\Agent;

use App\Http\Helpers\Common;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class NewPasswordController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data['token'] = $request->route('token');
        $tokenCheck = DB::table('password_resets')->where('token', $request->route('token'))->first();

        if (!$tokenCheck) {
            Common::one_time_message('error', __('Password reset token has been expired'));
            return redirect()->route('agent');
        }
        
        return view('agent::agent.auth.reset-password', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $data = executeNoAuthAgentPostApi('reset-password', $request);
            Common::one_time_message('success', __($data['message']));
            return redirect()->route('agent');
        } catch (Exception $e) {
            Common::one_time_message('error', $e->getMessage());
            return redirect()->route('agent');
        }
    }
}
