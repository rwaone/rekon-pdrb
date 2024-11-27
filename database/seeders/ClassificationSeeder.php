<?php

namespace Database\Seeders;

use App\Models\Classification;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classifications = [
            [
                'type' => 'Lapangan Usaha',
                'code' => 'i',
                'name' => 'Primer'
            ],
            [
                'type' => 'Lapangan Usaha',
                'code' => 'ii',
                'name' => 'Sekunder'
            ],
            [
                'type' => 'Lapangan Usaha',
                'code' => 'iii',
                'name' => 'Tersier'
            ],
            [
                'type' => 'Pengeluaran',
                'code' => 'i',
                'name' => 'Konsumsi Akhir Non Publik'
            ],
            [
                'type' => 'Pengeluaran',
                'code' => 'ii',
                'name' => 'Konsumsi Akhir Publik'
            ],
            [
                'type' => 'Pengeluaran',
                'code' => 'iii',
                'name' => 'Permintaan Akhir Institusi'
            ],
            [
                'type' => 'Pengeluaran',
                'code' => 'iv',
                'name' => 'Lainnya'
            ],
        ];

        foreach ($classifications as $classification) {
            Classification::create($classification);
        }
    }
}
