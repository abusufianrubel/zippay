<?php

namespace Modules\Agent\Notifications\Sms;

use Exception;
use App\Services\Sms\TechVillageSms;

class AgentDepositNotification extends TechVillageSms
{
    /**
     * The array of status and message whether the SMS is sent or not.
     *
     * @var array
     */
    protected $smsResponse = [];

    public function __construct()
    {
        parent::__construct();
        $this->smsResponse = [
            'status'  => true,
            'message' => __('Deposit details notification has been sent to the agent via SMS. Please check your messages.')
        ];
    }
    /**
     * Send deposit notification SMS to the agent
     *
     * @param object $deposit
     * @param array $optional
     * @return array $smsResponse
     */
    public function send($deposit, $optional = [])
    {
        try {
            $response = $this->getSmsTemplate('agent-deposit-notification-via-admin');
            
            if (!$response['status']) {
                return $response;
            }

            $paymentMethodName = '';
            if ($deposit->payment_method) {
                $paymentMethodName = $deposit->payment_method->name == "Mts" ? settings('name') : $deposit->payment_method->name;
            }

            $data = [
                "{agent}"          => getColumnValue($deposit->agent),
                "{created_at}"     => agentDateFormat($deposit->created_at),
                "{payment_method}" => $paymentMethodName,
                "{uuid}"           => $deposit->uuid,
                "{code}"           => $deposit->currency ? $deposit->currency->code : "",
                "{amount}"         => moneyFormat(optional($deposit->currency)->symbol, formatNumber($deposit->amount)),
                "{fee}"            => moneyFormat(optional($deposit->currency)->symbol, formatNumber($deposit->charge_fixed + $deposit->charge_percentage)),
                "{soft_name}"      => settings('name'),
            ];

            $message = str_replace(array_keys($data), $data, $response['template']->body);
            sendSMS($deposit->user->formatted_phone, $message);
        } catch (Exception $e) {
            $this->smsResponse['message'] = $e->getMessage();
        }

        return $this->smsResponse;
    }
}