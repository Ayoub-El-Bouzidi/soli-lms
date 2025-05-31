<?php

namespace Modules\Pkg_Emploi\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Pkg_Emploi\Models\Salle;

class SalleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
               ['nom' => 'Salle 1'],
               ['nom' => 'Salle 2'],
               ['nom' => 'Salle 3'],
               ['nom' => 'Salle 4'],
               ['nom' => 'Salle 5'],
           ];

           foreach ($rooms as $room) {
               Salle::create($room);
           }
    }
}
