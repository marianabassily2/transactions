<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
 
        Permission::firstOrCreate(['name' => 'create transactions']);
        Permission::firstOrCreate(['name' => 'view transactions']);
        Permission::firstOrCreate(['name' => 'create payments']);
        Permission::firstOrCreate(['name' => 'view payments']);
        Permission::firstOrCreate(['name' => 'generate reports']);

        $role = Role::firstOrCreate(['name' => 'admin'])
            ->givePermissionTo(['create transactions', 'view transactions', 'create payments','view payments','generate reports']);

        $role = Role::firstOrCreate(['name' => 'customer'])
            ->givePermissionTo(['view transactions','view payments']);

        $role = Role::firstOrCreate(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());
    }
}
