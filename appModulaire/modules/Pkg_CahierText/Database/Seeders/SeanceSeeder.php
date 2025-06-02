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
        $seanceEmploies = SeanceEmploi::with('module')->get();
        $formateurs = Formateur::pluck('id')->toArray();

        foreach ($seanceEmploies as $seanceEmploi) {
            Seance::create([
                'etat_validation' => $faker->randomElement(['pending', 'approved', 'rejected']),
                'seance_emploie_id' => $seanceEmploi->id,
                'module_id' => $seanceEmploi->module_id,
                'formateur_id' => $faker->randomElement($formateurs),
            ]);
        }
    }
}
