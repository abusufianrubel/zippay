<?php

namespace Modules\Agent\Listeners\Cashout;

use Modules\Agent\Events\AgentCashoutEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Agent\Notifications\Mail\NotifyAdminCashoutNotification;

class NotifyAdminsOfCashout implements ShouldQueue
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
    public function handle(AgentCashoutEvent $event): void
    {
        $cashout = $event->cashout;

        (new NotifyAdminCashoutNotification)->send($cashout, ['type' => 'Agent', 'medium' => 'email']);
    }
}
