<?php

namespace Modules\Agent\Notifications\Sms;

use Exception;
use App\Services\Sms\TechVillageSms;

class NotifyUserCashoutNotification extends TechVillageSms
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
            'message' => __('Cashout details notification has been sent to the user via SMS. Please check your messages.')
        ];
    }
    /**
     * Send cashout details notification to user via SMS
     *
     * @param object $cashout
     * @param array $optional
     * @return array $smsResponse
     */
    public function send($cashout, $optional = [])
    {
        try {
            $response = $this->getSmsTemplate('notify-user-on-cashout');
            
            if (!$response['status']) {
                return $response;
            }

            $data = [
                "{user}"            => getColumnValue($cashout->user),
                "{created_at}"      => formatDateTime($cashout->created_at),
                "{payment_method}"  => $cashout->payment_method?->name,
                "{uuid}"            => $cashout->uuid,
                "{code}"            => $cashout->currency?->code,
                "{amount}"          => moneyFormat(optional($cashout->currency)->symbol, formatNumber($cashout->subtotal)),
                "{fee}"             => moneyFormat(optional($cashout->currency)->symbol, formatNumber($cashout->charge_fixed + $cashout->charge_percentage)),
                "{soft_name}"       => settings('name'),
            ];

            $message = str_replace(array_keys($data), $data, $response['template']->body);
            sendSMS($cashout->user->formatted_phone, $message);
        } catch (Exception $e) {
            $this->smsResponse = ['status' => false, 'message' => $e->getMessage()];
        }
        
        return $this->smsResponse;
    }
}