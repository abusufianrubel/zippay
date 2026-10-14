<?php

namespace Modules\Agent\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class AgentCashinOtpCode
{
    use SerializesModels, Dispatchable;

    public $agent;

    /**
     * Create a new event instance.
     */
    public function __construct($agent)
    {
        $this->agent = $agent;
    }

    /**
     * Get the channels the event should be broadcast on.
     */
    public function broadcastOn(): array
    {
        return [];
    }
}
