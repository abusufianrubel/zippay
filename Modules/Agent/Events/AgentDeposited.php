<?php

namespace Modules\Agent\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class AgentDeposited
{
    use SerializesModels, Dispatchable;

    public $deposit;

    /**
     * Create a new event instance.
     */
    public function __construct($deposit)
    {
        $this->deposit = $deposit;
    }

    /**
     * Get the channels the event should be broadcast on.
     */
    public function broadcastOn(): array
    {
        return [];
    }
}
