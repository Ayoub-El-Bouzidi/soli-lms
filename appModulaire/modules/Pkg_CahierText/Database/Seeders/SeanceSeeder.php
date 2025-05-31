<?php

namespace Modules\Pkg_CahierText\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Pkg_CahierText\Models\Formateur;
use Modules\Pkg_CahierText\Models\Seance;
use Modules\Pkg_CahierText\Models\Module;
use Faker\Factory as Faker;
use Modules\Pkg_Emploi\Models\SeanceEmploi;

class SeanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $seanceEmploies = SeanceEmploi::pluck('id')->toArray();

        for ($i = 0; $i < 50; $i++) {
            Seance::create([
                'etat_validation' => $faker->randomElement(['pending', 'approved', 'rejected']),
                'seance_emploie_id' => $faker->randomElement($seanceEmploies),
            ]);
        }
    }
}
