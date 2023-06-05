<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\region;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = [
            [
                'satker_id' => '1',
                'code' => '7100',
                'name' => 'Provinsi Sulawesi Utara'
            ],
            [
                'satker_id' => '2',
                'code' => '7101',
                'name' => 'Kab. Bolaang Mongondow'
            ],
            [
                'satker_id' => '3',
                'code' => '7102',
                'name' => 'Kab. Minahasa'
            ],
            [
                'satker_id' => '4',
                'code' => '7103',
                'name' => 'Kab. Kepulauan Sangihe'
            ],
            [
                'satker_id' => '5',
                'code' => '7104',
                'name' => 'Kab. Kepulauan Talaud'
            ],
            [
                'satker_id' => '6',
                'code' => '7105',
                'name' => 'Kab. Minahasa Selatan'
            ],
            [
                'satker_id' => '7',
                'code' => '7106',
                'name' => 'Kab. Minahasa Utara'
            ],
            [
                'satker_id' => '8',
                'code' => '7107',
                'name' => 'Kab. Bolaang Mongondow Utara'
            ],
            [
                'satker_id' => '9',
                'code' => '7108',
                'name' => 'Kab. Kepulauan Siau Tagulandang Biaro'
            ],
            [
                'satker_id' => '6',
                'code' => '7109',
                'name' => 'Kab. Minahasa Tenggara'
            ],
            [
                'satker_id' => '1',
                'code' => '7110',
                'name' => 'Kab. Bolaang Mongondow Selatan'
            ],
            [
                'satker_id' => '13',
                'code' => '7111',
                'name' => 'Kab. Bolaang Mongondow Timur'
            ],
            [
                'satker_id' => '10',
                'code' => '7171',
                'name' => 'Kota Manado'
            ],
            [
                'satker_id' => '11',
                'code' => '7172',
                'name' => 'Kota Bitung'
            ],
            [
                'satker_id' => '12',
                'code' => '7173',
                'name' => 'Kota Tomohon'
            ],
            [
                'satker_id' => '13',
                'code' => '7174',
                'name' => 'Kota Kotamobagu'
            ],
        ];

        foreach($regions as $region){
            Region::create($region);
        }
    }
}
