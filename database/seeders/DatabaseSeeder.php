<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);

        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'delete roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'edit permissions']);
        Permission::create(['name' => 'delete permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create institutions']);
        Permission::create(['name' => 'edit institutions']);
        Permission::create(['name' => 'delete institutions']);
        Permission::create(['name' => 'view institutions']);
        Permission::create(['name' => 'create categories']);
        Permission::create(['name' => 'edit categories']);
        Permission::create(['name' => 'delete categories']);
        Permission::create(['name' => 'view categories']);

        $admin->syncPermissions([
            'create roles', 'edit roles', 'delete roles', 'view roles',
            'create users', 'edit users', 'delete users', 'view users',
            'create permissions', 'edit permissions', 'delete permissions', 'view permissions',
            'create institutions', 'edit institutions', 'delete institutions', 'view institutions',
            'create categories', 'edit categories', 'delete categories', 'view categories'
        ]);
    }
}