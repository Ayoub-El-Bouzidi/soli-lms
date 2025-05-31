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
               ['nom' => 'Web Development', 'masse_horaire' => 60],
               ['nom' => 'Database Management', 'masse_horaire' => 40],
               ['nom' => 'English Communication', 'masse_horaire' => 20],
               ['nom' => 'Soft Skills', 'masse_horaire' => 20],
               ['nom' => 'API Development', 'masse_horaire' => 30],
           ];

           foreach ($modules as $module) {
               Module::create($module);
           }
    }
}
