<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sectors = [
            [
                'code' => 'A',
                'name' => 'Pertanian, Kehutanan, dan Perikanan'
            ],
        ];

        foreach($sectors as $sector){
            Category::create($sector);
        }
    }
}
