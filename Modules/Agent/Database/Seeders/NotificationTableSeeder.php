<?php

namespace Modules\Agent\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class NotificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        \App\Models\NotificationType::insert([
            [
                'name'       => 'Cashin',
                'alias'      => 'cashin',
                'status'     => 'Active',
            ],
            [
                'name'       => 'Cashout',
                'alias'      => 'cashout',
                'status'     => 'Active',
            ]
        ]);

        $cashinId = \App\Models\NotificationType::where('name', 'Cashin')->value('id');
        $cashoutId = \App\Models\NotificationType::where('name', 'Cashout')->value('id');

        \App\Models\NotificationSetting::insert([
            [
                'notification_type_id' => $cashinId,
                'recipient_type'       => 'email',
                'recipient'            => checkDemoEnvironment() ? 'admin@techvill.net' : null,
                'status'               => checkDemoEnvironment() ? 'Yes' : 'No',
            ],
            [
                'notification_type_id' => $cashinId,
                'recipient_type'       => 'sms',
                'recipient'            => null,
                'status'               => 'No',
            ],
            [
                'notification_type_id' => $cashoutId,
                'recipient_type'       => 'email',
                'recipient'            => checkDemoEnvironment() ? 'admin@techvill.net' : null,
                'status'               => checkDemoEnvironment() ? 'Yes' : 'No',
            ],
            [
                'notification_type_id' => $cashoutId,
                'recipient_type'       => 'sms',
                'recipient'            => null,
                'status'               => 'No',
            ],
        ]);

    }
}
