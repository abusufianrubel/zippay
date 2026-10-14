<?php

namespace Modules\Agent\Database\Seeders;

use Illuminate\Database\Seeder;

class AgentDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(AgentPackagesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PermissionRoleTableSeeder::class);
        $this->call(TransactionTypesTableSeeder::class);
        $this->call(AgentPaymentMethodTableSeeder::class);
        $this->call(AgentEmailTemplatesTableSeeder::class);
        $this->call(AgentFeesLimitsSeeder::class);
        $this->call(MetasTableSeeder::class);
        $this->call(NotificationTableSeeder::class);
        $this->call(OauthClientsTableSeeder::class);

        if (checkDemoEnvironment()) {
            $this->call(AgentsTableSeeder::class);
            $this->call(OtpCodesTableSeeder::class);
            $this->call(AgentWalletsTableSeeder::class);
            $this->call(CashinsTableSeeder::class);
            $this->call(CashoutsTableSeeder::class);
            $this->call(TransactionsTableSeeder::class);
        }
    }
}
