<?php

namespace Modules\Pkg_CahierText\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Pkg_CahierText\Models\Formateur;
use App\Models\User;

class FormateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $user = User::create([
        'name' => 'John Doe',
        'email' => 'johndoe@example.com',
        'password' => bcrypt('password'),
        ]);

        Formateur::create([
            'user_id' => $user->id,
            'nom' => 'Doe',
            'prenom' => 'John',
            'email' => 'formateur@example.com',
            'password' => bcrypt('password'),
        ]);
    }
}
