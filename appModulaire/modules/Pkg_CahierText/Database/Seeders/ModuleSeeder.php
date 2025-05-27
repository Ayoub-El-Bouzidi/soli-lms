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
            [
                'nom' => 'PHP',
                'masse_horaire_totale' => 0,
            ],
            [
                'nom' => 'JavaScript',
                'masse_horaire_totale' => 0,
            ],
            [
                'nom' => 'Python',
                'masse_horaire_totale' => 35,
            ],
            [
                'nom' => 'Java',
                'masse_horaire_totale' => 45,
            ],
            [
                'nom' => 'C#',
                'masse_horaire_totale' => 50,
            ],
            [
                'nom' => 'Ruby',
                'masse_horaire_totale' => 5,
            ],
            [
                'nom' => 'Go',
                'masse_horaire_totale' => 20,
            ],
            [
                'nom' => 'Swift',
                'masse_horaire_totale' => 0,
            ],
        ];

        foreach ($modules as $module) {
            Module::create($module);
        }
    }
}
