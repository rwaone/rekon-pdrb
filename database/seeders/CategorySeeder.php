<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'code' => 'A',
                'name' => 'Pertanian, Kehutanan, dan Perikanan'
            ],
            [
                'code' => 'B',
                'name' => 'Pertambangan dan Penggalian'
            ],
            [
                'code' => 'C',
                'name' => 'Industri Pengolahan'
            ],
            [
                'code' => 'D',
                'name' => 'Pengadaan Listrik dan Gas'
            ],
            [
                'code' => 'E',
                'name' => 'Pengadaan Air, Pengelolaan Sampah, Limbah, dan Daur Ulang'
            ],
            [
                'code' => 'F',
                'name' => 'Konstruksi'
            ],
            [
                'code' => 'G',
                'name' => 'Perdagangan Besar dan Eceran; Reparasi Mobil dan Sepeda Motor'
            ],
            [
                'code' => 'H',
                'name' => 'Transportasi dan Pergudangan'
            ],
            [
                'code' => 'I',
                'name' => 'Penyediaan Akomodasi dan Makan Minum'
            ],
            [
                'code' => 'J',
                'name' => 'Informasi dan Komunikasi'
            ],
            [
                'code' => 'K',
                'name' => 'Jasa Keuangan dan Asuransi'
            ],
            [
                'code' => 'L',
                'name' => 'Real Estate'
            ],
            [
                'code' => 'M,N',
                'name' => 'Jasa Perusahaan'
            ],
            [
                'code' => 'O',
                'name' => 'Administrasi Pemerintahan, Pertahanan dan Jaminan Sosial Wajib'
            ],
            [
                'code' => 'P',
                'name' => 'Jasa Pendidikan'
            ],
            [
                'code' => 'Q',
                'name' => 'Jasa Kesehatan dan Kegiatan Sosial'
            ],
            [
                'code' => 'R,S,T,U',
                'name' => 'Jasa Lainnya'
            ],
        ];

        foreach($categories as $category){
            Category::create($category)
        }
    }
}
