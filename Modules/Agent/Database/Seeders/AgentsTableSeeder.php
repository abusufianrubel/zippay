<?php

namespace Modules\Agent\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgentsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('agents')->delete();
        
        DB::table('agents')->insert([
            [
                'agent_package_id' => getAgentDefaultPackageId(),
                'country_id' => getCountryId('CV'),
                'first_name' => 'Agent',
                'last_name' => 'Techvill',
                'email' => 'agent@techvill.net',
                'password' => '$2y$10$67hFXST/4lU6kwcfkllowuAsWvSnyEQcMgiZvq17bIR1k7tezxqpa',
                'iso2' => 'bd',
                'dial_code' => '880',
                'phone' => '1883307179',
                'formatted_phone' => '+8801883307179',
                'photo' => null,
                'address' => 'Dolore quia nostrum laudantium',
                'city' => 'Dolore sapiente nesc',
                'state' => 'Odit itaque et velit',
                'timezone' => 'Asia/Dhaka',
                'status' => 'Active',
                'business_name' => 'Hedwig Oneal',
                'type' => 'Agent',
                'remember_token' => null,
                'deleted_at' => null,
                'created_at' => Carbon::now()->subDays(7),
                'updated_at' => Carbon::now()->subDays(7),
            ]
        ]);
    }
}
