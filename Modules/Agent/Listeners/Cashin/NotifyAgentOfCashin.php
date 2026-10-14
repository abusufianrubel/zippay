<?php

namespace Modules\Agent\Listeners\Cashin;

use Illuminate\Queue\InteractsWithQueue;
use Modules\Agent\Events\AgentCashinEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Agent\Notifications\Mail\NotifyAgentCashinNotification;

class NotifyAgentOfCashin implements ShouldQueue
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
    public function handle(AgentCashinEvent $event): void
    {
        $cashin = $event->cashin;

        (new NotifyAgentCashinNotification)->send($cashin, ['type' => 'Agent', 'medium' => 'email']);
    }
}
