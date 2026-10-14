<?php

namespace Modules\Agent\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class AgentCashoutOtpCode
{
    use SerializesModels, Dispatchable;

    public $cashout;

    /**
     * Create a new event instance.
     */
    public function __construct($otpCodeInstance)
    {
        $this->cashout = $otpCodeInstance;
    }

    /**
     * Get the channels the event should be broadcast on.
     */
    public function broadcastOn(): array
    {
        return [];
    }
}
