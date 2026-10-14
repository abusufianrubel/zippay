<?php

namespace Modules\Agent\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgentWalletsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('agent_wallets')->delete();
        
        DB::table('agent_wallets')->insert([
            [
                'agent_id' => getAgentIdByEmail('agent@techvill.net'),
                'currency_id' => getCurrencyId('USD'),
                'balance' => '85.80000000',
                'is_default' => 'Yes'
            ],
            [
                'agent_id' => getAgentIdByEmail('agent@techvill.net'),
                'currency_id' => getCurrencyId('GBP'),
                'balance' => '0.00000000',
                'is_default' => 'No'
            ],
            [
                'agent_id' => getAgentIdByEmail('agent@techvill.net'),
                'currency_id' => getCurrencyId('EUR'),
                'balance' => '0.00000000',
                'is_default' => 'No'
            ]
        ]);
    }
}
