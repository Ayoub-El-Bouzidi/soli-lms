<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Modules\Pkg_CahierText\Database\Seeders\DatabaseSeederCahieText;
use Illuminate\Database\Seeder;
use Modules\Pkg_CahierText\Database\Seeders\FormateurSeeder;
use Modules\Pkg_CahierText\Database\Seeders\GroupeFormateurSeeder;
use Modules\Pkg_CahierText\Database\Seeders\GroupeModuleSeeder;
use Modules\Pkg_CahierText\Database\Seeders\GroupeSeeder;
use Modules\Pkg_CahierText\Database\Seeders\ModuleSeeder;
use Modules\Pkg_CahierText\Database\Seeders\ResponsableSeeder;
use Modules\Pkg_CahierText\Database\Seeders\SeanceSeeder;
use Modules\Pkg_Emploi\Database\Seeders\EmploiSeeder;
use Modules\Pkg_Emploi\Database\Seeders\SalleSeeder;
use Modules\Pkg_Emploi\Database\Seeders\SeanceEmploieSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            // DatabaseSeederCahieText::class,
            // DatabaseSeederEmploi::class,
            ResponsableSeeder::class,
            FormateurSeeder::class,
            GroupeSeeder::class,
            // FormateurSeeder::class,
            GroupeFormateurSeeder::class,
            ModuleSeeder::class,
            GroupeModuleSeeder::class,
            SalleSeeder::class,
            EmploiSeeder::class,
            SeanceEmploieSeeder::class,
            SeanceSeeder::class,

            // Add other seeders here if needed
        ]);

        // You can also call other seeders directly if needed
        // $this->call(OtherSeeder::class);
    }
}
