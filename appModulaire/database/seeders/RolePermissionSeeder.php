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
        // Get or create roles
        $responsableRole = Role::firstOrCreate(['name' => 'responsable']);
        $formateurRole = Role::firstOrCreate(['name' => 'formateur']);

        // Create permissions
        $permissions = [
            'create_modules',
            'view_modules',
            'edit_modules',
            'delete_modules'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $responsableRole->syncPermissions($permissions);
        $formateurRole->syncPermissions(['view_modules']);
    }
}
