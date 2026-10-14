<?php

namespace Modules\Agent\Listeners\Cashout;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Agent\Events\AgentCashoutOtpCode;
use Modules\Agent\Notifications\Mail\AgentCashoutOTPVerificationNotification;

class NotifyUsersOfCashoutOtpCode implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AgentCashoutOtpCode $event): void
    {
        $cashout = $event->cashout;

        (new AgentCashoutOTPVerificationNotification)->send($cashout, ['type' => 'Agent', 'medium' => 'email']);
    }
}
