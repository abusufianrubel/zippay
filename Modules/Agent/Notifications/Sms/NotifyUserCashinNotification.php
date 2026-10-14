<?php

namespace Modules\Agent\Notifications\Sms;

use Exception;
use App\Services\Sms\TechVillageSms;

class NotifyUserCashinNotification extends TechVillageSms
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
            'message' => __('Cashin details notification has been sent to the user via SMS. Please check your messages.')
        ];
    }
    /**
     * Send cashin details notification to user via SMS
     *
     * @param object $cashin
     * @param array $optional
     * @return array $smsResponse
     */
    public function send($cashin, $optional = [])
    {
        try {
            $response = $this->getSmsTemplate('notify-user-on-cashin');
            
            if (!$response['status']) {
                return $response;
            }

            $data = [
                "{user}"            => getColumnValue($cashin->user),
                "{created_at}"      => formatDateTime($cashin->created_at),
                "{payment_method}"  => $cashin->payment_method?->name,
                "{uuid}"            => $cashin->uuid,
                "{code}"            => $cashin->currency?->code,
                "{amount}"          => moneyFormat(optional($cashin->currency)->symbol, formatNumber($cashin->subtotal)),
                "{fee}"             => moneyFormat(optional($cashin->currency)->symbol, formatNumber($cashin->charge_fixed + $cashin->charge_percentage)),
                "{soft_name}"       => settings('name'),
            ];

            $message = str_replace(array_keys($data), $data, $response['template']->body);
            sendSMS($cashin->user->formatted_phone, $message);
        } catch (Exception $e) {
            $this->smsResponse = ['status' => false, 'message' => $e->getMessage()];
        }
        
        return $this->smsResponse;
    }
}