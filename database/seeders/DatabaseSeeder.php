<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Creare roluri
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);

        // Creare permisiuni
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
        Permission::create(['name' => 'create event-categories']);
        Permission::create(['name' => 'edit event-categories']);
        Permission::create(['name' => 'delete event-categories']);
        Permission::create(['name' => 'view event-categories']);
        Permission::create(['name' => 'create injury-categories']);
        Permission::create(['name' => 'edit injury-categories']);
        Permission::create(['name' => 'delete injury-categories']);
        Permission::create(['name' => 'view injury-categories']);
        Permission::create(['name' => 'create events']);
        Permission::create(['name' => 'edit events']);
        Permission::create(['name' => 'delete events']);
        Permission::create(['name' => 'view events']);
        Permission::create(['name' => 'create injuries']);
        Permission::create(['name' => 'edit injuries']);
        Permission::create(['name' => 'delete injuries']);
        Permission::create(['name' => 'view injuries']);
Permission::create(['name' => 'create detinuti']);
Permission::create(['name' => 'edit detinuti']);
Permission::create(['name' => 'delete detinuti']);
Permission::create(['name' => 'view detinuti']);
Permission::create(['name' => 'create objects']);
Permission::create(['name' => 'edit objects']);
Permission::create(['name' => 'delete objects']);
Permission::create(['name' => 'view objects']);


        // Asignare permisiuni rolului Admin
        $admin->syncPermissions([
            'create roles', 'edit roles', 'delete roles', 'view roles',
            'create users', 'edit users', 'delete users', 'view users',
            'create permissions', 'edit permissions', 'delete permissions', 'view permissions',
            'create institutions', 'edit institutions', 'delete institutions', 'view institutions',
            'create event-categories', 'edit event-categories', 'delete event-categories', 'view event-categories',
            'create injury-categories', 'edit injury-categories', 'delete injury-categories', 'view injury-categories',
            'create events', 'edit events', 'delete events', 'view events',
            'create injuries', 'edit injuries', 'delete injuries', 'view injuries',
            'create detinuti', 'edit detinuti', 'delete detinuti', 'view detinuti',
            'create objects', 'edit objects', 'delete objects', 'view objects',
        ]);

        // Asignare tuturor permisiunilor pentru Super Admin
        $superAdmin->syncPermissions(Permission::all());
    }
}