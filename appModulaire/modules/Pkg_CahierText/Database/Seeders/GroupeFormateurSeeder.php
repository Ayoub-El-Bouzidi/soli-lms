<?php

namespace Modules\Pkg_CahierText\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Pkg_CahierText\Models\Formateur;
use Modules\Pkg_CahierText\Models\Groupe;

class GroupeFormateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = Groupe::pluck('id', 'nom')->toArray();
        $tutors = Formateur::pluck('id', 'nom')->toArray();

           // Assign main tutors to groups for the year
           $assignments = [
               'DM101' => 'Fouad',
               'DW101' => 'Imane',
               'DW102' => 'Abdeouahab',
               'DW103' => 'Fatin',
               'DW104' => 'Abdeltif',
           ];

           foreach ($assignments as $groupName => $tutorName) {
               $groupId = $groups[$groupName];
               $tutorId = $tutors[$tutorName];
               Groupe::find($groupId)->formateurs()->attach($tutorId);
           }

           // Assign English and Soft Skills tutors to all groups
           $additionalTutors = ['Firdaous', 'Amin'];
           foreach ($groups as $groupId) {
               foreach ($additionalTutors as $tutorName) {
                   Groupe::find($groupId)->formateurs()->attach($tutors[$tutorName]);
               }
           }
    }
}
