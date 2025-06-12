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
    public function run()
    {
        $users = User::pluck('id')->toArray();
        if (empty($users)) {
            return; // Exit if no users exist
        }

        $tutors = [
            ['nom' => 'Imane', 'prenom' => 'Bouziane', 'email' => 'imane@example.com', 'password' => bcrypt('password')],
            ['nom' => 'Fouad', 'prenom' => 'Esseraj', 'email' => 'fouad@example.com', 'password' => bcrypt('password')],
            ['nom' => 'Abdeouahab', 'prenom' => 'Souklabi', 'email' => 'abdeouahab@example.com', 'password' => bcrypt('password')],
            ['nom' => 'Fatin', 'prenom' => 'Chebab', 'email' => 'fatin@example.com', 'password' => bcrypt('password')],
            ['nom' => 'Abdeltif', 'prenom' => 'Souklabi', 'email' => 'abdeltif@example.com', 'password' => bcrypt('password')],
            ['nom' => 'Firdaous', 'prenom' => 'John', 'email' => 'john.smith@example.com', 'password' => bcrypt('password')], // English tutor
            ['nom' => 'Amin', 'prenom' => 'Jane', 'email' => 'jane.doe@example.com', 'password' => bcrypt('password')], // Soft Skills tutor
        ];

        foreach ($tutors as $tutor) {
            Formateur::create([
                'user_id' => $users[array_rand($users)],
                'nom' => $tutor['nom'],
                'prenom' => $tutor['prenom'],
                'email' => $tutor['email'],
                'password' => $tutor['password'],
            ]);
        }
    }
}
