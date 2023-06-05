<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategorySeeder::class,
            PdrbSeeder::class,
            PeriodSeeder::class,
            RegionSeeder::class,
            SatkerSeeder::class,
            SectorSeeder::class,
            SubsectorSeeder::class,
            UserSeeder::class
        ]);
    }
}
