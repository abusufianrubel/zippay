<?php

namespace Modules\Agent\Http\Controllers\Api\V2;

use App\Exceptions\Api\V2\ForgotPasswordException;
use Exception;
use Illuminate\Http\Request;
use Modules\Agent\Entities\Agent;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class NewPasswordController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data['token'] = $request->route('token');
       
        return view('agent::agent.auth.reset-password', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'token' => ['required', 'string'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ]);

            $passwordResetRecord = DB::table('password_resets')->where('token', $request->token)->firstOrFail();

            $agent = Agent::where('email', $passwordResetRecord->email)->firstOrFail();

            if (Hash::check($request->password, $agent->password)) {
                throw new ForgotPasswordException(
                    __("The new password you have entered is the same as your current password. Please choose a different password.")
                );
            }

            $agent->password = Hash::make($request->password);
            $agent->save();

            DB::table('password_resets')->where('token', $request->token)->delete();
            DB::commit();

            return $this->successResponse([
                'status' => 'success',
                'message' => __('Password reset successfully')
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->unprocessableResponse([], $e->getMessage());
        }
    }

}
