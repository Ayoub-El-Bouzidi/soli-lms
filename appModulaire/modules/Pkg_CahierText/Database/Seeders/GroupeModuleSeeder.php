<?php

namespace Modules\Pkg_CahierText\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Pkg_CahierText\Models\Groupe;
use Modules\Pkg_CahierText\Models\Module;

class GroupeModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = Groupe::pluck('id', 'nom')->toArray();
           $modules = Module::pluck('id', 'nom')->toArray();

           // Assign modules to groups
           $groupModules = [
               'DM101' => ['Web Development', 'Database Management', 'English Communication', 'Soft Skills'],
               'DW101' => ['Web Development', 'English Communication', 'Soft Skills'],
               'DW102' => ['Web Development', 'English Communication', 'Soft Skills'],
               'DW103' => ['Web Development', 'English Communication', 'Soft Skills'],
               'DW104' => ['Web Development', 'English Communication', 'Soft Skills'],
           ];

           foreach ($groupModules as $groupName => $moduleNames) {
               $groupId = $groups[$groupName];
               $moduleIds = array_map(fn($name) => $modules[$name], $moduleNames);
               Groupe::find($groupId)->modules()->attach($moduleIds);
           }
    }
}
