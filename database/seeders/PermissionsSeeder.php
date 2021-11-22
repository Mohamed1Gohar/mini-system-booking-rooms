<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $maps = ['create', 'read', 'update', 'delete'];
        $models = ['users', 'rooms'];
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        foreach ($models as $model) {
            foreach ($maps as $map) {
                Permission::create([
                    'name' => $map . ' ' . $model,
                ]);
            }
        }

        $role = Role::create(['name' => 'Admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'Client']);
        $role->givePermissionTo(['read rooms']);
    }
}
