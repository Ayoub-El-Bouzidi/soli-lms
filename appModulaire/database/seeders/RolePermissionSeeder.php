<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $responsableRole = Role::create(['name' => 'responsable']);
        $formateurRole = Role::create(['name' => 'formateur']);

        // Create permissions
        Permission::create(['name' => 'create_modules']);
        Permission::create(['name' => 'view_modules']);

        // Assign permissions to roles
        $responsableRole->givePermissionTo(['create_modules', 'view_modules']);
        $formateurRole->givePermissionTo('view_modules');
    }
}
