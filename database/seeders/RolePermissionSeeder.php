<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role_Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::all()->count();
        for ($i = 1; $i <= $permissions; $i++) {
            Role_Permission::create([
                'role_id' => 1,
                'permission_id' => $i,
            ]);
        }
    }
}
