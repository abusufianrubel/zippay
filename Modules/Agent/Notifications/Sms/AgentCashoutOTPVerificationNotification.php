<?php

namespace Modules\Agent\Notifications\Sms;

use Exception;
use App\Services\Sms\TechVillageSms;

class AgentCashoutOTPVerificationNotification extends TechVillageSms
{
    /**
     * The array of status and message whether SMS sent or not.
     *
     * @var array
     */
    protected $smsResponse = [];

    public function __construct()
    {
        parent::__construct();
        $this->smsResponse = [
            'status'  => true,
            'message' => __('An OTP verification code has been sent to your phone via SMS. Please check your messages.')
        ];
    }

    /**
     * Send SMS notification to the agent for OTP verification
     *
     * @param object $cashout
     * @param array $optional
     * @return array $smsResponse
     */
    public function send($cashout, $optional = [])
    {
        try {
            $response = $this->getSmsTemplate('agent-cashout-otp-code-verification');
            
            if (!$response['status']) {
                return $response;
            }

            $data = [
                '{user}'      => getColumnValue($cashout->user),
                '{otp_code}'  => $cashout->otp_code,
                '{soft_name}' => settings('name'),
            ];

            
            $message = str_replace(array_keys($data), $data, $response['template']->body);
            sendSMS($cashout->user->formatted_phone, $message);
        } catch (Exception $e) {
            $this->smsResponse['message'] = $e->getMessage();
        }

        return $this->smsResponse;
    }
}