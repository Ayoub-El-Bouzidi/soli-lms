<?php

namespace Modules\Pkg_CahierText\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Pkg_CahierText\Models\SeanceEmploi;
use Illuminate\Support\Carbon;

class SeanceEmploiSeeder extends Seeder
{
    public function run(): void
    {
        // Exemple : on vérifie si les ID existent
        $moduleId = 1;      // Assure-toi que ce module existe
        $formateurId = 1;   // Assure-toi que ce formateur existe
        $salleId = 1;       // Assure-toi que cette salle existe
        $emploieId = 1;     // Assure-toi que cet emploi existe

        $seances = [
            [
                'date' => '2025-05-31',
                'heur_debut' => '2025-05-31 10:00:00',
                'heur_fin' => '2025-05-31 12:00:00',
                'duree' => 120,
                'jours' => 'lundi',
                'module_id' => $moduleId,
                'formateur_id' => $formateurId,
                'salle_id' => $salleId,
                'emploie_id' => $emploieId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => '2025-06-01',
                'heur_debut' => '2025-06-01 14:00:00',
                'heur_fin' => '2025-06-01 16:00:00',
                'duree' => 120,
                'jours' => 'mardi',
                'module_id' => $moduleId,
                'formateur_id' => $formateurId,
                'salle_id' => $salleId,
                'emploie_id' => $emploieId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        SeanceEmploi::insert($seances);
    }
}
