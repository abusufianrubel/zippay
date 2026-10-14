<?php

namespace Modules\Agent\Notifications\Mail;

use Exception;
use App\Services\Mail\TechVillageMail;

class AgentCashoutOTPVerificationNotification extends TechVillageMail
{
    /**
     * The array of status and message whether email sent or not.
     *
     * @var array
     */
    protected $mailResponse = [];

    public function __construct()
    {
        parent::__construct();
        $this->mailResponse = [
            'status'  => true,
            'message' => __('Please check your email for an OTP verification code. Click on the link to verify your email address.')
        ];
    }
    /**
     * Send OTP verification code to the user's email
     * @param object $cashout
     * @param array $optional
     * @return array $response
     */
    public function send($cashout, $optional = [])
    {
        try {
            $response = $this->getEmailTemplate('agent-cashout-otp-code-verification');
            
            if (!$response['status']) {
                return $response;
            }

            $data = [
                '{user}'      => getColumnValue($cashout->user),
                '{otp_code}'  => $cashout->otp_code,
                '{soft_name}' => settings('name'),
            ];

            $message = str_replace(array_keys($data), $data, $response['template']->body);

            $this->email->sendEmail($cashout->user->email, $response['template']->subject, $message);
        } catch (Exception $e) {
            $this->mailResponse = ['status' => false, 'message' => $e->getMessage()];
        }
        
        return $this->mailResponse;
    }
}