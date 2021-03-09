<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'create_company']);
        Permission::create(['name' => 'edit_company']);
        Permission::create(['name' => 'delete_company']);
        Permission::create(['name' => 'create_project']);
        Permission::create(['name' => 'edit_project']);
        Permission::create(['name' => 'delete_project']);
        Permission::create(['name' => 'create_task']);
        Permission::create(['name' => 'edit_task']);
        Permission::create(['name' => 'delete_task']);

        $role = Role::create(['name' => 'admin'])
            ->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'manager'])
            ->givePermissionTo(['create_project', 'edit_project', 'delete_project', 'create_task', 'edit_task', 'delete_task']);

        $role = Role::create(['name' => 'user'])
            ->givePermissionTo(['create_task', 'edit_task', 'delete_task']);
    }
}