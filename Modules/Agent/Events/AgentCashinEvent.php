<?php

namespace Modules\Agent\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class AgentCashinEvent
{
    use SerializesModels, Dispatchable;

    public $cashin;

    /**
     * Create a new event instance.
     */
    public function __construct($cashin)
    {
        $this->cashin = $cashin;
    }

    /**
     * Get the channels the event should be broadcast on.
     */
    public function broadcastOn(): array
    {
        return [];
    }
}
