<?php

namespace Modules\Agent\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgentPreferencesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('preferences')->insert(array (
            array (
                'category' => 'preference',
                'field' => 'agent_login_via',
                'value' => 'email_only',
            ),
            array (
                'category' => 'preference',
                'field' => 'agent_verification_mail',
                'value' => 'Enabled',
            ),
            array (
                'category' => 'preference',
                'field' => 'agent_phone_verification',
                'value' => 'Enabled',
            ),
        ));
    }
}
