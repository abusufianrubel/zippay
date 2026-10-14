<?php

namespace Modules\Agent\Database\Seeders;

use Illuminate\Database\Seeder;

class OtpCodesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('otp_codes')->delete();
    }
}
