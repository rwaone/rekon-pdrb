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
                'satker_id' => '7100',
                'code' => '7100',
                'name' => 'BPS Provinsi Sulawesi Utara'
            ],
            [
                'satker_id' => '7101',
                'code' => '7101',
                'name' => 'BPS Kab. Bolaang Mongondow'
            ],
            [
                'satker_id' => '7102',
                'code' => '7102',
                'name' => 'BPS Kab. Minahasa'
            ],
            [
                'satker_id' => '7103',
                'code' => '7103',
                'name' => 'BPS Kab. Kepulauan Sangihe'
            ],
            [
                'satker_id' => '7104',
                'code' => '7104',
                'name' => 'BPS Kab. Kepulauan Talaud'
            ],
            [
                'satker_id' => '7105',
                'code' => '7105',
                'name' => 'BPS Kab. Minahasa Selatan'
            ],
            [
                'satker_id' => '7106',
                'code' => '7106',
                'name' => 'BPS Kab. Minahasa Utara'
            ],
            [
                'satker_id' => '7107',
                'code' => '7107',
                'name' => 'BPS Kab. Bolaang Mongondow Utara'
            ],
            [
                'satker_id' => '7108',
                'code' => '7108',
                'name' => 'BPS Kab. Kepulauan Siau Tagulandang Biaro'
            ],
            [
                'satker_id' => '7105',
                'code' => '7109',
                'name' => 'BPS Kab. Minahasa Tenggara'
            ],
            [
                'satker_id' => '7101',
                'code' => '7110',
                'name' => 'BPS Kab. Bolaang Mongondow Selatan'
            ],
            [
                'satker_id' => '7174',
                'code' => '7111',
                'name' => 'BPS Kab. Bolaang Mongondow Timur'
            ],
            [
                'satker_id' => '7171',
                'code' => '7171',
                'name' => 'BPS Kota Manado'
            ],
            [
                'satker_id' => '7172',
                'code' => '7172',
                'name' => 'BPS Kota Bitung'
            ],
            [
                'satker_id' => '7173',
                'code' => '7173',
                'name' => 'BPS Kota Tomohon'
            ],
            [
                'satker_id' => '7174',
                'code' => '7174',
                'name' => 'BPS Kota Kotamobagu'
            ],
        ];

        foreach($regions as $region){
            Region::create($region);
        }
    }
}
