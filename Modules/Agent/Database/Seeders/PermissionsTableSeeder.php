<?php

namespace Modules\Agent\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert(array (
            array (
                'group' => 'Agent',
                'name' => 'view_agent',
                'display_name' => 'View Agent',
                'description' => 'View Agent',
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Agent',
                'name' => 'add_agent',
                'display_name' => 'Add Agent',
                'description' => 'Add Agent',
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Agent',
                'name' => 'edit_agent',
                'display_name' => 'Edit Agent',
                'description' => 'Edit Agent',
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Agent',
                'name' => 'delete_agent',
                'display_name' => 'Delete Agent',
                'description' => 'Delete Agent',
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Agent Package',
                'name' => 'view_package',
                'display_name' => 'View Package',
                'description' => 'View Package',
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Agent Package',
                'name' => 'add_package',
                'display_name' => 'Add Package',
                'description' => 'Add Package',
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Agent Package',
                'name' => 'edit_package',
                'display_name' => 'Edit Package',
                'description' => 'Edit Package',
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Agent Package',
                'name' => 'delete_package',
                'display_name' => 'Delete Package',
                'description' => 'Delete Package',
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Agent Revenue',
                'name' => 'view_agent_revenue',
                'display_name' => 'View Agent Revenue',
                'description' => 'View Agent Revenue',
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Agent Revenue',
                'name' => 'add_agent_revenue',
                'display_name' => null,
                'description' => null,
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Agent Revenue',
                'name' => 'edit_agent_revenue',
                'display_name' => null,
                'description' => null,
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Agent Revenue',
                'name' => 'delete_agent_revenue',
                'display_name' => null,
                'description' => null,
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Agent',
                'name' => 'manage_agent',
                'display_name' => null,
                'description' => null,
                'user_type' => 'Agent',
            ),
            array (
                'group' => 'Cashin',
                'name' => 'view_cashin',
                'display_name' => 'View Cashin',
                'description' => 'View Cashin',
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Cashin',
                'name' => 'add_cashin',
                'display_name' => null,
                'description' => null,
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Cashin',
                'name' => 'edit_cashin',
                'display_name' => 'Edit Cashin',
                'description' => 'Edit Cashin',
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Cashin',
                'name' => 'delete_cashin',
                'display_name' => null,
                'description' => null,
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Cashin',
                'name' => 'manage_cashin',
                'display_name' => null,
                'description' => null,
                'user_type' => 'Agent',
            ),
            array (
                'group' => 'Cashout',
                'name' => 'view_cashout',
                'display_name' => 'View Cashout',
                'description' => 'View Cashout',
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Cashout',
                'name' => 'add_cashout',
                'display_name' => null,
                'description' => null,
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Cashout',
                'name' => 'edit_cashout',
                'display_name' => 'Edit Cashout',
                'description' => 'Edit Cashout',
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Cashout',
                'name' => 'delete_cashout',
                'display_name' => null,
                'description' => null,
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Cashout',
                'name' => 'manage_cashout',
                'display_name' => null,
                'description' => null,
                'user_type' => 'Agent',
            ),
            array (
                'group' => 'Agent feeslimit',
                'name' => 'view_agent_feeslimit',
                'display_name' => 'View Agent feeslimit',
                'description' => 'View Agent feeslimit',
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Agent feeslimit',
                'name' => 'add_agent_feeslimit',
                'display_name' => null,
                'description' => null,
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Agent feeslimit',
                'name' => 'edit_agent_feeslimit',
                'display_name' => 'Edit Agent feeslimit',
                'description' => 'Edit Agent feeslimit',
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Agent feeslimit',
                'name' => 'delete_agent_feeslimit',
                'display_name' => null,
                'description' => null,
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Agent Deposit',
                'name' => 'deposit_agent',
                'display_name' => 'Deposit agent',
                'description' => 'Deposit agent',
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Agent Deposit',
                'name' => 'view_agent_deposit',
                'display_name' => null,
                'description' => null,
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Agent Deposit',
                'name' => 'edit_agent_deposit',
                'display_name' => null,
                'description' => null,
                'user_type' => 'Admin',
            ),
            array (
                'group' => 'Agent Deposit',
                'name' => 'delete_agent_deposit',
                'display_name' => null,
                'description' => null,
                'user_type' => 'Admin',
            ),
        ));
    }
}
