<?php

namespace Modules\Agent\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CashinsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('cashins')->delete();
        
        DB::table('cashins')->insert([
            [
                'user_id' => getUserByEmail('kyla@gmail.com'),
                'agent_id' => getAgentIdByEmail('agent@techvill.net'),
                'agent_package_id' => getAgentDefaultPackageId(),
                'currency_id' => getCurrencyId('USD'),
                'payment_method_id' => getPaymentMethodId('Cash'),
                'uuid' => 'E0400EA9F10D5',
                'agent_percentage' => '0.10',
                'charge_percentage' => '0.25',
                'charge_fixed' => '2.00',
                'subtotal' => '12.25',
                'amount' => '10.00',
                'total' => '12.15',
                'status' => 'Success',
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'user_id' => getUserByEmail('irish@gmail.com'),
                'agent_id' => getAgentIdByEmail('agent@techvill.net'),
                'agent_package_id' => getAgentDefaultPackageId(),
                'currency_id' => getCurrencyId('USD'),
                'payment_method_id' => getPaymentMethodId('Cash'),
                'uuid' => '929353787154C',
                'agent_percentage' => '0.10',
                'charge_percentage' => '0.25',
                'charge_fixed' => '2.00',
                'subtotal' => '12.25',
                'amount' => '10.00',
                'total' => '12.15',
                'status' => 'Success',
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4),
            ]
        ]);
    }
}
