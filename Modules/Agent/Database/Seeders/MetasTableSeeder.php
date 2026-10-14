<?php

namespace Modules\Agent\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('metas')->insert([
            [
                'url' => 'agent/dashboard',
                'title' => 'Agent Dashboard',
                'description' => 'Agent Dashboard',
                'keywords' => '',
            ],
            [
                'url' => 'agent/login',
                'title' => 'Agent Login',
                'description' => 'Agent Login',
                'keywords' => '',
            ],
            [
                'url' => 'agent/forgot-password',
                'title' => 'Agent Forgot Password',
                'description' => 'Agent Forgot Password',
                'keywords' => '',
            ],
            [
                'url' => 'agent/reset-password',
                'title' => 'Agent reset password',
                'description' => 'Agent reset password',
                'keywords' => '',
            ],
            [
                'url' => 'agent/profile',
                'title' => 'Agent profile',
                'description' => 'Agent profile',
                'keywords' => '',
            ],
            [
                'url' => 'agent/profile/image',
                'title' => 'Agent profile image',
                'description' => 'Agent profile image',
                'keywords' => '',
            ],
            [
                'url' => 'agent/profile/wallet',
                'title' => 'Agent wallet list',
                'description' => 'Agent wallet list',
                'keywords' => '',
            ],
            [
                'url' => 'agent/cashin/create',
                'title' => 'Agent cashin create',
                'description' => 'Agent cashin create',
                'keywords' => '',
            ],
            [
                'url' => 'agent/cashin/confirm',
                'title' => 'Agent cashin confirm',
                'description' => 'Agent cashin confirm',
                'keywords' => '',
            ],
            [
                'url' => 'agent/cashin/success',
                'title' => 'Agent cashin success',
                'description' => 'Agent cashin success',
                'keywords' => '',
            ],
            [
                'url' => 'agent/cashin/print',
                'title' => 'Agent cashin print',
                'description' => 'Agent cashin print',
                'keywords' => '',
            ],
            [
                'url' => 'agent/cashout/create',
                'title' => 'Agent cashout create',
                'description' => 'Agent cashout create',
                'keywords' => '',
            ],
            [
                'url' => 'agent/cashout/confirm',
                'title' => 'Agent cashout confirm',
                'description' => 'Agent cashout confirm',
                'keywords' => '',
            ],
            [
                'url' => 'agent/cashout/success',
                'title' => 'Agent cashout success',
                'description' => 'Agent cashout success',
                'keywords' => '',
            ],
            [
                'url' => 'agent/cashout/print',
                'title' => 'Agent cashout print',
                'description' => 'Agent cashout print',
                'keywords' => '',
            ],
            [
                'url' => 'agent/transaction',
                'title' => 'Agent transaction list',
                'description' => 'Agent transaction list',
                'keywords' => '',
            ],
            [
                'url' => 'agent/check-agent-status',
                'title' => 'Agent Suspended',
                'description' => 'Agent Suspended',
                'keywords' => '',
            ],
            [
                'url' => 'reset-password/{token}',
                'title' => 'Reset Password',
                'description' => 'Reset Password',
                'keywords' => '',
            ]
        ]);
    }
}
