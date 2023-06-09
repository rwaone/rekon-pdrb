<?php

namespace Database\Seeders;

use App\Models\Sector;
use App\Models\Category;
use App\Models\subsector;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PengeluaranSeeder extends Seeder
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
                'category_id' => 18,
                'code' => 1,
                'name' => 'Pengeluaran Konsumsi Rumah Tangga'
            ],
            [
                'category_id' => 18,
                'code' => 2,
                'name' => 'Pengeluaran Konsumsi LNPRT'
            ],
            [
                'category_id' => 18,
                'code' => 3,
                'name' => 'Pengeluaran Konsumsi Pemerintah'
            ],
            [
                'category_id' => 18,
                'code' => 4,
                'name' => 'Pembentukan Modal Tetap Bruto'
            ],
            [
                'category_id' => 18,
                'code' => 5,
                'name' => 'Perubahan Inventori'
            ],
            [
                'category_id' => 18,
                'code' => 6,
                'name' => 'Net Ekspor'
            ],
        ];

        $subsectors = [
            [
                'sector_id' => 49,
                'type' => 'Pengeluaran',
                'code' => 'a',
                'name' => 'Makanan, Minuman dan Rokok'
            ],
            [
                'sector_id' => 49,
                'type' => 'Pengeluaran',
                'code' => 'b',
                'name' => 'Pakaian dan Alas Kaki'
            ],
            [
                'sector_id' => 49,
                'type' => 'Pengeluaran',
                'code' => 'c',
                'name' => 'Perumahan, Perkakas, Perlengkapan dan Penyelenggaraan Rumah Tangga'
            ],
            [
                'sector_id' => 49,
                'type' => 'Pengeluaran',
                'code' => 'd',
                'name' => 'Kesehatan dan Pendidikan'
            ],
            [
                'sector_id' => 49,
                'type' => 'Pengeluaran',
                'code' => 'e',
                'name' => 'Transportasi, Komunikasi, Rekreasi, dan Budaya'
            ],
            [
                'sector_id' => 49,
                'type' => 'Pengeluaran',
                'code' => 'f',
                'name' => 'Hotel dan Restoran'
            ],
            [
                'sector_id' => 49,
                'type' => 'Pengeluaran',
                'code' => 'g',
                'name' => 'Lainnya'
            ],
            [
                'sector_id' => 50,
                'type' => 'Pengeluaran',
                'code' => NULL,
                'name' => 'Pengeluaran Konsumsi LNPRT'
            ],
            [
                'sector_id' => 51,
                'type' => 'Pengeluaran',
                'code' => NULL,
                'name' => 'Pengeluaran Konsumsi Pemerintah'
            ],
            [
                'sector_id' => 52,
                'type' => 'Pengeluaran',
                'code' => 'a',
                'name' => 'Bangunan'
            ],
            [
                'sector_id' => 52,
                'type' => 'Pengeluaran',
                'code' => 'b',
                'name' => 'Non Bangunan'
            ],
            [
                'sector_id' => 53,
                'type' => 'Pengeluaran',
                'code' => NULL,
                'name' => 'Perubahan Inventori'
            ],
            [
                'sector_id' => 54,
                'type' => 'Pengeluaran',
                'code' => 'a',
                'name' => 'Ekspor Antar Daerah'
            ],
            [
                'sector_id' => 54,
                'type' => 'Pengeluaran',
                'code' => 'b',
                'name' => 'Impor Antar Daerah'
            ],
        ];

        foreach ($sectors as $sector) {
            Sector::create($sector);
        }
        foreach ($subsectors as $subsector) {
            Subsector::create($subsector);
        }
        
        Category::create([
            'id' => 18,
            'type' => 'Pengeluaran',
            'code' => 'X',
            'name' => 'Pengeluaran'
        ]);

    }
}
