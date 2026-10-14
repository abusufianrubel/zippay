<?php

namespace Modules\Agent\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgentPackagesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('agent_packages')->delete();

        DB::table('agent_packages')->insert([
            [
                'name' => 'Platinum',
                'description' => 'This is the Platinum Agent Package',
                'commission' => '0.50',
                'is_default' => 'No',
            ],
            [
                'name' => 'Premium',
                'description' => 'This is the premium Agent Package',
                'commission' => '1.00',
                'is_default' => 'No',
            ],
            [
                'name' => 'Gold',
                'description' => 'This is the gold Agent Package',
                'commission' => '1.50',
                'is_default' => 'Yes',
            ],
            [
                'name' => 'Silver',
                'description' => 'This is the silver Agent Package',
                'commission' => '2.00',
                'is_default' => 'No',
            ],
            [
                'name' => 'Bronze',
                'description' => 'This is the bronze Agent Package',
                'commission' => '2.50',
                'is_default' => 'No',
            ],
        ]);
    }
}
