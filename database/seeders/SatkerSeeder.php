<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\satker;

class SatkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $satkers = [
            [
                'code' => '7100',
                'name' => 'BPS Provinsi Sulawesi Utara'
            ],
            [
                'code' => '7101',
                'name' => 'BPS Kab. Bolaang Mongondow'
            ],
            [
                'code' => '7102',
                'name' => 'BPS Kab. Minahasa'
            ],
            [
                'code' => '7103',
                'name' => 'BPS Kab. Kepulauan Sangihe'
            ],
            [
                'code' => '7104',
                'name' => 'BPS Kab. Kepulauan Talaud'
            ],
            [
                'code' => '7105',
                'name' => 'BPS Kab. Minahasa Selatan'
            ],
            [
                'code' => '7106',
                'name' => 'BPS Kab. Minahasa Utara'
            ],
            [
                'code' => '7107',
                'name' => 'BPS Kab. Bolaang Mongondow Utara'
            ],
            [
                'code' => '7108',
                'name' => 'BPS Kab. Kepulauan Siau Tagulandang Biaro'
            ],
            [
                'code' => '7171',
                'name' => 'BPS Kota Manado'
            ],
            [
                'code' => '7172',
                'name' => 'BPS Kota Bitung'
            ],
            [
                'code' => '7173',
                'name' => 'BPS Kota Tomohon'
            ],
            [
                'code' => '7174',
                'name' => 'BPS Kota Kotamobagu'
            ],
        ];

        foreach($satkers as $satker){
            Satker::create($satker);
        }
    }
}
