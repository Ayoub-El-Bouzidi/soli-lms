<?php

namespace Modules\Pkg_CahierText\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Pkg_CahierText\Models\Responsable;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ResponsableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'responsable@example.com'],
            [
                'name' => 'Manager',
                'password' => bcrypt('password'),
            ]
        );

        // Assign the 'responsable' role to the user
        $responsableRole = Role::findByName('responsable');
        if (!$user->hasRole('responsable')) {
            $user->assignRole($responsableRole);
        }

        $responsable = Responsable::firstOrCreate(
            ['user_id' => $user->id],
            [
                'nom' => 'Manager',
                'prenom' => 'Responsable',
                'email' => 'responsable@example.com',
                'password' => Hash::make('password'),
            ]
        );

        // Also assign the 'responsable' role to the Responsable model
        if (!$responsable->hasRole('responsable')) {
            $responsable->assignRole($responsableRole);
        }
    }
}
