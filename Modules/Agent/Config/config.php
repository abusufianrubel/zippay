<?php

if (!app()->runningInConsole()) {
    return [
        'name' => 'Agent',
        'item_id' => 'wr6h7efkefa',
        'supported_versions' => "5.0.0",
        'permission_group' => [
            'Agent', 'Agent Package', 'Cashin', 'Cashout', 'Agent Revenue', 'Agent feeslimit', 'Agent Deposit'
        ],
        'agent_status' => [
            'Active', 'Inactive', 'Suspended'
        ],
        'route_group' => [
            'authenticated' => [
                'agent' => [
                    'prefix' => 'agent',
                    'middleware' => ['guest:agent', 'locale']
                ],
            ],
            'unauthenticated' => [
                'agent' => [
                    'prefix' => 'agent',
                    'middleware' => ['no_auth:agent', 'locale']
                ],
            ]
        ],
        'guards' => [
            'agent' => [
                'driver'   => 'session',
                'provider' => 'agent',
            ],
            'agent-v2' => [
                'driver' => 'passport',
                'provider' => 'agent',
                'hash' => false
            ],
        ],
        'providers' => [
            'agent' => [
                'driver' => 'eloquent',
                'model'  => Modules\Agent\Entities\Agent::class,
                'table'  => 'agents',
            ],
        ],
        'passwords' => [
            'agent' => [
                'provider' => 'agent',
                'table'    => 'password_resets',
                'expire'   => 60,
                'throttle' => 60,
            ],
        ],
        'transaction_types' => (defined('Cashin') && defined('Cashout') && defined('Deposit') )
                                ? [Cashin, Cashout, Deposit] : [],
        'transaction_type_settings' => [
            'web' => [
                'sent' => (defined('Cashin') && defined('Cashout')) ? [Cashin, Cashout] : [],
                'received' => [],
            ],
            'mobile' => [
                'sent' => [
                    'Cashin' => defined('Cashin') ? Cashin : '',
                ],
                'received' => [
                    'Cashout' => defined('Cashout') ? Cashout : ''
                ]
            ]
        ],

        'transaction_list' => [
            'sender' => (defined('Cashin') && defined('Cashout') && defined('Deposit'))
                    ? [ Cashin => 'user', Cashout => 'user', Deposit => 'agent']
                    : [],
            'receiver' => []
        ],
        'menu_config' => [
            'name' => __('AgentPay'),
            'label' => 'Agent',
            'icon' => megaMenuSvg('agent'),
            'route' => 'agent'
        ],
    ];
} else {
    return [
        'name' => 'Agent',
        'item_id' => 'wr6h7efkefa',
        'supported_versions' => "5.0.0",
        'permission_group' => [
            'Agent', 'Agent Package', 'Cashin', 'Cashout', 'Agent Revenue', 'Agent feeslimit', 'Agent Deposit'
        ],
        'agent_status' => [
            'Active', 'Inactive', 'Suspended'
        ]
    ];
}
