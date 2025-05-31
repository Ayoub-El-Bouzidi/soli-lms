<?php

namespace Modules\Pkg_Emploi\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Pkg_CahierText\Models\Formateur;
use Modules\Pkg_CahierText\Models\Module;
use Modules\Pkg_CahierText\Models\Seance;
use Modules\Pkg_Emploi\Models\Emploi;
use Modules\Pkg_Emploi\Models\Salle;
use Modules\Pkg_Emploi\Models\SeanceEmploi;

class SeanceEmploieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Fetch existing records
        $modules = Module::pluck('id', 'nom')->toArray();
        $formateurs = Formateur::pluck('id', 'nom')->toArray();
        $salles = Salle::pluck('id', 'nom')->toArray();
        $seances = Seance::pluck('id')->toArray();

        

        $emploieId = 1;

        // Schedule data based on the image
        $schedule = [
            'Lundi' => [
                ['heur_debut' => '09:00:00', 'heur_fin' => '10:00:00', 'module' => 'Soft Skills', 'formateur' => 'Firdaous'],
                ['heur_debut' => '10:00:00', 'heur_fin' => '11:00:00', 'module' => 'Web Development', 'formateur' => 'Fatin'],
                ['heur_debut' => '14:00:00', 'heur_fin' => '15:00:00', 'module' => 'Soft Skills', 'formateur' => 'Firdaous'],
            ],
            'Mardi' => [
                ['heur_debut' => '09:00:00', 'heur_fin' => '10:00:00', 'module' => 'Web Development', 'formateur' => 'Fatin'],
                ['heur_debut' => '14:00:00', 'heur_fin' => '15:00:00', 'module' => 'Web Development', 'formateur' => 'Fatin'],
            ],
            'Mercredi' => [
                ['heur_debut' => '09:00:00', 'heur_fin' => '10:00:00', 'module' => 'Web Development', 'formateur' => 'Fatin'],
                ['heur_debut' => '14:00:00', 'heur_fin' => '15:00:00', 'module' => 'Web Development', 'formateur' => 'Fatin'],
            ],
            'Jeudi' => [
                ['heur_debut' => '09:00:00', 'heur_fin' => '10:00:00', 'module' => 'Web Development', 'formateur' => 'Fatin'],
                ['heur_debut' => '14:00:00', 'heur_fin' => '15:00:00', 'module' => 'Web Development', 'formateur' => 'Fatin'],
            ],
            'Vendredi' => [
                ['heur_debut' => '09:00:00', 'heur_fin' => '10:00:00', 'module' => 'English Communication', 'formateur' => 'Amin'],
                ['heur_debut' => '14:00:00', 'heur_fin' => '15:00:00', 'module' => 'English Communication', 'formateur' => 'Amin'],
            ]
        ];

        // Create SeanceEmploie records
        foreach ($schedule as $weekday => $sessions) {
            foreach ($sessions as $session) {
                SeanceEmploi::create([
                    'heur_debut' => $session['heur_debut'],
                    'heur_fin' => $session['heur_fin'],
                    'jours' => $weekday,
                    'module_id' => $modules[$session['module']],
                    'formateur_id' => $formateurs[$session['formateur']],
                    'salle_id' => $salles['Salle 4'],
                    'emploie_id' => $emploieId,
                ]);
            }
        }
    }
}
