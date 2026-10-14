<?php

namespace Modules\Agent\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CashoutsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('cashouts')->delete();
        
        DB::table('cashouts')->insert([
            [
                'user_id' => getUserByEmail('kyla@gmail.com'),
                'agent_id' => getAgentIdByEmail('agent@techvill.net'),
                'agent_package_id' => getAgentDefaultPackageId(),
                'currency_id' => getCurrencyId('USD'),
                'payment_method_id' => getPaymentMethodId('Cash'),
                'uuid' => '31B796C206CE8',
                'payment_method_info' => 'kyla@gmail.com',
                'agent_percentage' => '0.05',
                'charge_percentage' => '0.13',
                'charge_fixed' => '1.00',
                'subtotal' => '3.88',
                'amount' => '5.00',
                'total' => '5.05',
                'status' => 'Success',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'user_id' => getUserByEmail('irish@gmail.com'),
                'agent_id' => getAgentIdByEmail('agent@techvill.net'),
                'agent_package_id' => getAgentDefaultPackageId(),
                'currency_id' => getCurrencyId('USD'),
                'payment_method_id' => getPaymentMethodId('Cash'),
                'uuid' => '52EB4B2E8C1A4',
                'payment_method_info' => 'irish@gmail.com',
                'agent_percentage' => '0.05',
                'charge_percentage' => '0.13',
                'charge_fixed' => '1.00',
                'subtotal' => '3.88',
                'amount' => '5.00',
                'total' => '5.05',
                'status' => 'Success',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ]
        ]);
    }
}
