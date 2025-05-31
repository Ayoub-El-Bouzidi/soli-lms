<?php

namespace Modules\Pkg_CahierText\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// use PHPUnit\Framework\Attributes\Group;
use Modules\Pkg_CahierText\Models\Groupe;


class GroupeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
               ['nom' => 'DM101'], // Second year
               ['nom' => 'DW101'], // First year
               ['nom' => 'DW102'],
               ['nom' => 'DW103'],
               ['nom' => 'DW104'],
           ];

           foreach ($groups as $group) {
               Groupe::create($group);
           }
    }
}
