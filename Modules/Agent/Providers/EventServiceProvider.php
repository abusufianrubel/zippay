<?php

namespace Modules\Agent\Providers;

use Modules\Agent\Events\AgentDeposited;
use Modules\Agent\Events\AgentRegistered;
use Modules\Agent\Events\AgentCashinEvent;
use Modules\Agent\Events\AgentCashoutEvent;
use Modules\Agent\Events\AgentCashoutOtpCode;
use Modules\Agent\Listeners\Cashout\NotifyUserOfCashout;
use Modules\Agent\Listeners\Cashout\NotifyAgentOfCashout;
use Modules\Agent\Listeners\NotifyAgentOfDeposit;
use Modules\Agent\Listeners\Cashout\NotifyAdminsOfCashout;
use Modules\Agent\Listeners\Cashin\NotifyUserOfCashin;
use Modules\Agent\Listeners\NotifyAgentOnRegistration;
use Modules\Agent\Listeners\Cashin\NotifyAgentOfCashin;
use Modules\Agent\Listeners\Cashin\NotifyAdminsOfCashin;
use Modules\Agent\Listeners\Cashout\NotifyUsersOfCashoutOtpCode;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        AgentRegistered::class => [
           NotifyAgentOnRegistration::class,
        ],
        AgentDeposited::class => [
            NotifyAgentOfDeposit::class,
        ],
        AgentCashinEvent::class => [
            NotifyAdminsOfCashin::class,
            NotifyAgentOfCashin::class,
            NotifyUserOfCashin::class,
        ],
        AgentCashoutOtpCode::class => [
            NotifyUsersOfCashoutOtpCode::class,
        ],
        AgentCashoutEvent::class => [
            NotifyAgentOfCashout::class,
            NotifyUserOfCashout::class,
            NotifyAdminsOfCashout::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
