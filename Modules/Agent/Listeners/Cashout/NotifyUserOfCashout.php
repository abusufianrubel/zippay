<?php

namespace Modules\Agent\Listeners\Cashout;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Agent\Events\AgentCashoutEvent;
use Modules\Agent\Notifications\Mail\NotifyUserCashoutNotification;

class NotifyUserOfCashout implements ShouldQueue
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

        (new NotifyUserCashoutNotification)->send($cashout, ['type' => 'Agent', 'medium' => 'email']);
    }
}
