<?php

/**
 * @package ForgotPasswordService
 * @author tehcvillage <support@techvill.org>
 * @contributor Ashraful Rasel <[ashraful.techvill@gmail.com]>
 * @created 11-1-2023
 */

 namespace Modules\Agent\Services;

use Modules\Agent\Entities\Agent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Services\Mail\PasswordResetMailService;
use App\Exceptions\Api\V2\ForgotPasswordException;
use App\Services\Mail\ForgotPasswordMailService;

class ForgotPasswordService
{
    /**
     * send forgot password code
     *
     * @param string $email
     * @return void
     */
    public function resetCode($email)
    {
        $agent  = Agent::where('email', $email)->first();
        if (!$agent) {
            throw new ForgotPasswordException(__("Email Address does not match."));
        }

        $reset['email'] = $email;
        $reset['code'] = $agent['code']  = otpCode6();
        $reset['created_at'] = date('Y-m-d H:i:s');

        DB::table('password_resets')->where('email', $email)->delete();
        DB::table('password_resets')->insert($reset);

        return (new ForgotPasswordMailService)->send($agent, $reset);
    }

    public function verifyCode($code, $email)
    {
        $reset = DB::table('password_resets')->where(['code' => $code, 'email' => $email ])->first();
        if (!$reset) {
            throw new ForgotPasswordException(__("Verify code not valid. Please try again."));
        }

        return [
            'status'  => true,
            'message' => __('Reset code verified.')
        ];

    }

    public function confirmPassword($code, $email, $password)
    {
        $reset = DB::table('password_resets')->where(['code' => $code, 'email' => $email])->first();
        if (!$reset) {
            throw new ForgotPasswordException(__("Verify code not valid. Please try again."));
        }

        $agent = Agent::where('email', $email)->first();
        if (Hash::check($password, $agent->password)) {
            throw new ForgotPasswordException(__("The new password you have entered is the same as your current password. Please choose a different password."));
        }

        $agent->password = Hash::make($password);
        $agent->save();

        DB::table('password_resets')->where(['code' => $code, 'email' => $email])->delete();
        return [
            'status'  => true,
            'message' => __('Password changed successfully.')
        ];
    }



}
