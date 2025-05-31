<?php

namespace Modules\Pkg_Emploi\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Pkg_CahierText\Models\Groupe;
use Modules\Pkg_CahierText\Models\Responsable;
use Modules\Pkg_Emploi\Models\Emploi;

class EmploiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $responsableId = Responsable::first()->id;
        $groups = Groupe::pluck('id', 'nom')->toArray();

        // Create multiple Emploie records for each group
        $groupNames = ['DM101', 'DW101', 'DW102', 'DW103', 'DW104'];

        foreach ($groupNames as $groupName) {
            $groupId = $groups[$groupName] ?? null;
            if (!$groupId) continue;

            // Create 2 Emploie records per group (e.g., for different weeks or periods)
            for ($i = 0; $i < 2; $i++) {
                Emploi::create([
                    'date_debut' => Carbon::create(2025, 5, 1)->addWeeks($i * 2),
                    'date_fin' => Carbon::create(2025, 5, 7)->addWeeks($i * 2),
                    'groupe_id' => $groupId,
                    
                ]);
            }
        }
    }
}
