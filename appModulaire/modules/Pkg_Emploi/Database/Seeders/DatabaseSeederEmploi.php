<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeederEmploi extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            SalleSeeder::class,
            EmploieSeeder::class,
            SeanceEmploieSeeder::class,
        ]);
    }
}
