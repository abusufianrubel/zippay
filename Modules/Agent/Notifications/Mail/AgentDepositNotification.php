<?php

namespace Modules\Agent\Notifications\Mail;

use Exception;
use App\Services\Mail\TechVillageMail;

class AgentDepositNotification extends TechVillageMail
{
    /**
     * The array of status and message whether the email is sent or not.
     *
     * @var array
     */
    protected $mailResponse = [];

    public function __construct()
    {
        parent::__construct();
        $this->mailResponse = [
            'status'  => true,
            'message' => __('Please check your email for deposit details. Click on the link to verify your email address.')
        ];
    }
    /**
     * Send deposit notification email to the agent
     *
     * @param object $deposit
     * @param array $optional
     * @return array $response
     */
    public function send($deposit, $optional = [])
    {
        try {
            $response = $this->getEmailTemplate('agent-deposit-notification-via-admin');
            
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
            $this->email->sendEmail($deposit->agent->email, $response['template']->subject, $message);

        } catch (Exception $e) {
            $this->mailResponse = ['status' => false, 'message' => $e->getMessage()];
        }
        
        return $this->mailResponse;
    }
}