<?php

namespace Modules\Agent\Notifications\Mail;

use Exception;
use App\Services\Mail\TechVillageMail;

class NotifyUserCashoutNotification extends TechVillageMail
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
            'message' => __('Cashout details notification has been sent to the user. Please check your email.')
        ];
    }
    /**
     * Send cashout details notification to user
     * @param object $cashout
     * @param array $optional
     * @return array $response
     */
    public function send($cashout, $optional = [])
    {
        try {
            $response = $this->getEmailTemplate('notify-user-on-cashout');
            
            if (!$response['status']) {
                return $response;
            }

            $data = [
                "{user}"            => getColumnValue($cashout->user),
                "{created_at}"      => dateFormat($cashout->created_at, $cashout->user_id),
                "{payment_method}"  => $cashout->payment_method?->name,
                "{uuid}"            => $cashout->uuid,
                "{code}"            => $cashout->currency?->code,
                "{amount}"          => moneyFormat(optional($cashout->currency)->symbol, formatNumber($cashout->subtotal)),
                "{fee}"             => moneyFormat(optional($cashout->currency)->symbol, formatNumber($cashout->charge_fixed + $cashout->charge_percentage)),
                "{soft_name}"       => settings('name'),
            ];

            $message = str_replace(array_keys($data), $data, $response['template']->body);

            $this->email->sendEmail($cashout->user->email, $response['template']->subject, $message);
        } catch (Exception $e) {
            $this->mailResponse = ['status' => false, 'message' => $e->getMessage()];
        }
        
        return $this->mailResponse;
    }
}