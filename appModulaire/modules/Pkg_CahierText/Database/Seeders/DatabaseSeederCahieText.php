<?php

namespace Modules\Pkg_CahierText\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Laravel\SerializableClosure\SerializableClosure;

class DatabaseSeederCahieText extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            FormateurSeeder::class,
            ResponsableSeeder::class,
            ModuleSeeder::class,
            // SeanceSeeder::class,
            GroupeSeeder::class,
        ]);
    }
}
