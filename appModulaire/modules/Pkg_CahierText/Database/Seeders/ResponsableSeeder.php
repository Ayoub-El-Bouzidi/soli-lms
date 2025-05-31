<?php

namespace Modules\Pkg_CahierText\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Pkg_CahierText\Models\Responsable;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResponsableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Manager',
            'email' => 'responsable@example.com',
            'password' => bcrypt('password'),
        ]);
        Responsable::create([
            'user_id' => $user->id,
            'nom' => 'Manager',
            'prenom' => 'Responsable',
            'email' => 'responsable@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
