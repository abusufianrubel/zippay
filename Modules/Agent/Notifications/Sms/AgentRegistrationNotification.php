<?php

namespace Modules\Agent\Notifications\Sms;

use Exception;
use App\Services\Sms\TechVillageSms;

class AgentRegistrationNotification extends TechVillageSms
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
            'message' => __("Thank you for registering as an agent! Your account has been created with the following details:")
        ];
    }

    /**
     * Send SMS notification to the agent
     *
     * @param object $agent
     * @param array $optional
     * @return array $smsResponse
     */
    public function send($agent, $optional = [])
    {
        try {
            $response = $this->getSmsTemplate('notice-for-agent-registration');

            if (!$response['status']) {
                return $response;
            }

            $data = [
                '{agent}'  => getColumnValue($agent),
                '{email}' => $agent->email,
                '{password}' => '123456',
                '{soft_name}' => settings('name'),
            ];
            
            $message = str_replace(array_keys($data), $data, $response['template']->body);
            sendSMS($agent->formatted_phone, $message);
        } catch (Exception $e) {
            $this->smsResponse['message'] = $e->getMessage();
        }

        return $this->smsResponse;
    }

}
