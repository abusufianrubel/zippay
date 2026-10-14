<?php

namespace Modules\Agent\Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class OauthClientsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->insert([
            [
                'user_id' => null,
                'name' => 'Agent Personal Access Client',
                'secret' => 'agkL4ISxlzHE5z2zS2vwqZqqoF7ker3HMXo7De4v',
                'provider' => 'agent',
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => null,
                'updated_at' => null,
            ]
            
        ]);
    }
}
