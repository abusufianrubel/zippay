<?php

namespace Modules\Agent\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class AgentCashoutEvent
{
    use SerializesModels, Dispatchable;

    public $cashout;

    /**
     * Create a new event instance.
     */
    public function __construct($cashout)
    {
        $this->cashout = $cashout;
    }

    /**
     * Get the channels the event should be broadcast on.
     */
    public function broadcastOn(): array
    {
        return [];
    }
}
