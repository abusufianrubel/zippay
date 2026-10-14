<?php

namespace Modules\Agent\Listeners\Cashout;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Agent\Events\AgentCashoutEvent;
use Modules\Agent\Notifications\Mail\NotifyAgentCashoutNotification;

class NotifyAgentOfCashout implements ShouldQueue
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

        (new NotifyAgentCashoutNotification)->send($cashout, ['type' => 'Agent', 'medium' => 'email']);
    }
}
