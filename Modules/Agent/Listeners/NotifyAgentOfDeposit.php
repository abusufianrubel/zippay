<?php

namespace Modules\Agent\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Modules\Agent\Events\AgentDeposited;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Agent\Notifications\Mail\AgentDepositNotification;

class NotifyAgentOfDeposit implements ShouldQueue
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
    public function handle(AgentDeposited $event): void
    {
        $deposit = $event->deposit;

        (new AgentDepositNotification)->send($deposit, ['type' => 'cashout', 'medium' => 'email']);
    }
}
