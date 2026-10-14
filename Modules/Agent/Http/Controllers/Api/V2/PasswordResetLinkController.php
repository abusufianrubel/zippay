<?php

namespace Modules\Agent\Http\Controllers\Api\V2;

use Exception;
use Illuminate\Http\Request;
use Modules\Agent\Entities\Agent;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Password;
use App\Services\Mail\PasswordResetMailService;
use Illuminate\Http\JsonResponse;

class PasswordResetLinkController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'email' => 'required|email',
            ]);

            $data['email'] = $email = $request->email;
            $agent = Agent::where('email', $email)->first();

            if (!$agent) {
                return $this->unprocessableResponse([], __('Email Address does not match.'));
            }

            $data['token'] = base64_encode(Password::createToken($agent));
            $data['created_at'] = date('Y-m-d H:i:s');
            DB::table('password_resets')->insert($data);
            
            $data['resetUrl'] = route('agent.password.reset', $data['token']);
            (new PasswordResetMailService)->send($agent, $data);

            DB::commit();

            return $this->successResponse([
                'status' => 'success',
                'message' => __('Password reset link has been sent to :x', ['x' => $email])
            ]);
        } catch (QueryException $e) {
            DB::rollBack();
            return $this->unprocessableResponse([], $e->errorInfo[2]);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->unprocessableResponse([], $e->getMessage());
        }
    }
}
