<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $text = Route::getRoutes()->getRoutes();
        foreach ($text as $route) {
            if (array_key_exists('as', $route->action)) {
                Permission::create([
                    'name' => $route->action['as'],
                ]);
            }
        }
        Permission::create([
            'name' => 'admins_page',
        ]);
        Permission::create([
            'name' => 'category_page',
        ]);
        Permission::create([
            'name' => 'createPost_page',
        ]);
        Permission::create([
            'name' => 'fileManager_page',
        ]);
        Permission::create([
            'name' => 'rolePermissions_page',
        ]);
        Permission::create([
            'name' => 'postList_page',
        ]);
        Permission::create([
            'name' => 'siteindex_page',
        ]);
        Permission::create([
            'name' => 'dashboard_page',
        ]);
    }
}
