<?php

namespace Modules\Agent\Notifications\Mail;

use Exception;
use App\Services\Mail\TechVillageMail;

class AgentRegistrationNotification extends TechVillageMail
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
            'message' => __('Please check your email for registration details. Your account has been created with the following information:')
        ];
    }
    /**
     * Send registration details to the agent via email
     * @param object $agent
     * @param array $optional
     * @return array $response
     */
    public function send($agent, $optional = [])
    {
        try {
            $response = $this->getEmailTemplate('notice-for-agent-registration');
            
            if (!$response['status']) {
                return $response;
            }

            $data = [
                '{agent}'      => getColumnValue($agent),
                '{email}'      => $agent->email,
                '{password}'   => '123456', // Assuming a default password for demonstration
                '{soft_name}'  => settings('name'),
            ];

            $message = str_replace(array_keys($data), $data, $response['template']->body);

            $this->email->sendEmail($agent->email, $response['template']->subject, $message);
        } catch (Exception $e) {
            $this->mailResponse = ['status' => false, 'message' => $e->getMessage()];
        }
        
        return $this->mailResponse;
    }
}