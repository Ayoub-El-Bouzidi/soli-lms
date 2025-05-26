<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Modules\Pkg_CahierText\Database\Seeders\DatabaseSeederCahieText;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            DatabaseSeederCahieText::class,
            // Add other seeders here if needed
        ]);

        // You can also call other seeders directly if needed
        // $this->call(OtherSeeder::class);
    }
}
