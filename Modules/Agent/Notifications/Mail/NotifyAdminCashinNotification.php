<?php

namespace Modules\Agent\Notifications\Mail;

use Exception;
use App\Services\Mail\TechVillageMail;

class NotifyAdminCashinNotification extends TechVillageMail
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
            'message' => __('Cashin details notification has been sent to the admin. Please check your email.')
        ];
    }
    /**
     * Send cashin details notification to admin
     * @param object $cashin
     * @param array $optional
     * @return array $response
     */
    public function send($cashin, $optional = [])
    {
        $recipient = getRecipientFromNotificationSetting($optional);

        try {
            $response = $this->getEmailTemplate('notify-admin-on-cashin');

            if (!$response['status']) {
                return $response;
            }
        
            $data = [
                "{admin}"           => $recipient['name'] ?? $recipient['email'],
                "{user}"            => getColumnValue($cashin->user),
                "{created_at}"      => formatDateTime($cashin->created_at, $cashin->user_id),
                "{payment_method}"  => $cashin->payment_method?->name,
                "{uuid}"            => $cashin->uuid,
                "{code}"            => $cashin->currency?->code,
                "{amount}"          => moneyFormat(optional($cashin->currency)->symbol, formatNumber($cashin->subtotal)),
                "{fee}"             => moneyFormat(optional($cashin->currency)->symbol, formatNumber($cashin->charge_fixed + $cashin->charge_percentage)),
                "{agent_fees}"      => moneyFormat(optional($cashin->currency)->symbol, formatNumber($cashin->agent_percentage)),
                "{soft_name}"       => settings('name'),
            ];

            $message = str_replace(array_keys($data), $data, $response['template']->body);
            $this->email->sendEmail($recipient['email'], $response['template']->subject, $message);
        } catch (Exception $e) {
            $this->mailResponse = ['status' => false, 'message' => $e->getMessage()];
        }
        return $this->mailResponse;
    }
}