<?php

namespace Modules\Pkg_CahierText\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Pkg_CahierText\Models\Formateur;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class FormateurSeeder extends Seeder
{
    public function run(): void
    {
        $tutors = [
            ['nom' => 'Imane', 'prenom' => 'Bouziane', 'email' => 'imane@example.com'],
            ['nom' => 'Fouad', 'prenom' => 'Esseraj', 'email' => 'fouad@example.com'],
            ['nom' => 'Abdeouahab', 'prenom' => 'Souklabi', 'email' => 'abdeouahab@example.com'],
            ['nom' => 'Fatin', 'prenom' => 'Chebab', 'email' => 'fatin@example.com'],
            ['nom' => 'Abdeltif', 'prenom' => 'Souklabi', 'email' => 'abdeltif@example.com'],
            ['nom' => 'Firdaous', 'prenom' => 'John', 'email' => 'john.smith@example.com'],
            ['nom' => 'Amin', 'prenom' => 'Jane', 'email' => 'jane.doe@example.com'],
        ];

        foreach ($tutors as $tutor) {
            // Create or update the user
            $user = User::firstOrCreate(
                ['email' => $tutor['email']],
                [
                    'name' => $tutor['nom'] . ' ' . $tutor['prenom'],
                    'password' => Hash::make('password'),
                ]
            );

            // Assign 'formateur' role
            if (!$user->hasRole('formateur')) {
                $user->assignRole('formateur');
            }

            // Create formateur profile
            Formateur::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nom' => $tutor['nom'],
                    'prenom' => $tutor['prenom'],
                    'email' => $tutor['email'],
                    'password' => $user->password,
                ]
            );
        }
    }
}
