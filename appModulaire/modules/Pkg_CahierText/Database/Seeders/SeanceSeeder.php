<?php

namespace Modules\Pkg_CahierText\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Pkg_CahierText\Models\Formateur;
use Modules\Pkg_Emploi\Models\Seance;
use Modules\Pkg_CahierText\Models\Module;

class SeanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $formateur = Formateur::first();
        $module = Module::first();

        Seance::create([
            'date' => now()->toDateString(),
            'heure_debut' => '10:00:00',
            'heure_fin' => '12:00:00',
            'duree' => 120,
            'formateur_id' => $formateur->id,
            'module_id' => $module->id,
            'jours' => 'lundi',         // valeur pour le champ enum
            'seance_emploi_id' => 1, // Assurez-vous que cette valeur existe dans la table seance_emploies
        ]);
    }
}
