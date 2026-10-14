<?php

namespace Modules\Agent\Listeners;

use Modules\Agent\Events\AgentRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAgentOnRegistration implements ShouldQueue
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
    public function handle(AgentRegistered $event): void
    {
        $agent = $event->agent;

        (new \Modules\Agent\Notifications\Mail\AgentRegistrationNotification)->send($agent, ['type' => 'Agent', 'medium' => 'email']);
        (new \Modules\Agent\Notifications\Sms\AgentRegistrationNotification)->send($agent, ['type' => 'Agent', 'medium' => 'sms']);

    }
}
