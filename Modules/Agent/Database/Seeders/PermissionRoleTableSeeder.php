<?php

namespace Modules\Agent\Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::whereIn('group', config('agent.permission_group'))->get(['id', 'user_type']);

        foreach ($permissions as $permission) {
            $roleData[] = [
                'role_id' => $permission->user_type == "Admin" ? 1 : 2,
                'permission_id' => $permission->id,
            ];
        }

        DB::table('permission_role')->insert($roleData);
    }
}