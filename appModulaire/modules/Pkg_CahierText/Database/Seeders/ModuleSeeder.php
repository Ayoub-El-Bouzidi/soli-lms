<?php

namespace Modules\Pkg_CahierText\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Pkg_CahierText\Models\Module;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
               ['nom' => 'Web Development', 'masse_horaire' => 40, 'heures_terminees' => 40, 'heures_restees' => 0, 'etat_validation' => 'terminé'],
               ['nom' => 'Database Management', 'masse_horaire' => 40, 'heures_terminees' => 40, 'heures_restees' => 0, 'etat_validation' => 'terminé'],
               ['nom' => 'English Communication', 'masse_horaire' => 20, 'heures_terminees' => 10, 'heures_restees' => 10, 'etat_validation' => 'en cours'],
               ['nom' => 'Soft Skills', 'masse_horaire' => 20, 'heures_terminees' => 10, 'heures_restees' => 10, 'etat_validation' => 'en cours'],
               ['nom' => 'API Development', 'masse_horaire' => 30, 'heures_terminees' => 20, 'heures_restees' => 10, 'etat_validation' => 'en cours'],
           ];

           foreach ($modules as $module) {
               Module::create($module);
           }
    }
}
