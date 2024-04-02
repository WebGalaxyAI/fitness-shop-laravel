<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'super admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'writer']);
        Role::create(['name' => 'manager']);
        $actions = ['create', 'edit', 'delete', 'view', 'view any'];

        $modelFiles = scandir(app_path('Models'));
        foreach ($modelFiles as $modelFile) {
            if (!is_file(app_path('Models/' . $modelFile))) {
                continue;
            }
            $modelName = str(pathinfo($modelFile, PATHINFO_FILENAME))
                ->pluralStudly()
                ->kebab()
                ->replace('-', ' ');
            foreach ($actions as $action) {
                Permission::create(['name' => $action . ' ' . $modelName]);
            }
        }
    }
}
