<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\category;

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
                'type' => 'Lapangan Usaha',
                'code' => 'A',
                'name' => 'Pertanian, Kehutanan, dan Perikanan'
            ],
            [
                'type' => 'Lapangan Usaha',
                'code' => 'B',
                'name' => 'Pertambangan dan Penggalian'
            ],
            [
                'type' => 'Lapangan Usaha',
                'code' => 'C',
                'name' => 'Industri Pengolahan'
            ],
            [
                'type' => 'Lapangan Usaha',
                'code' => 'D',
                'name' => 'Pengadaan Listrik dan Gas'
            ],
            [
                'type' => 'Lapangan Usaha',
                'code' => 'E',
                'name' => 'Pengadaan Air, Pengelolaan Sampah, Limbah, dan Daur Ulang'
            ],
            [
                'type' => 'Lapangan Usaha',
                'code' => 'F',
                'name' => 'Konstruksi'
            ],
            [
                'type' => 'Lapangan Usaha',
                'code' => 'G',
                'name' => 'Perdagangan Besar dan Eceran; Reparasi Mobil dan Sepeda Motor'
            ],
            [
                'type' => 'Lapangan Usaha',
                'code' => 'H',
                'name' => 'Transportasi dan Pergudangan'
            ],
            [
                'type' => 'Lapangan Usaha',
                'code' => 'I',
                'name' => 'Penyediaan Akomodasi dan Makan Minum'
            ],
            [
                'type' => 'Lapangan Usaha',
                'code' => 'J',
                'name' => 'Informasi dan Komunikasi'
            ],
            [
                'type' => 'Lapangan Usaha',
                'code' => 'K',
                'name' => 'Jasa Keuangan dan Asuransi'
            ],
            [
                'type' => 'Lapangan Usaha',
                'code' => 'L',
                'name' => 'Real Estate'
            ],
            [
                'type' => 'Lapangan Usaha',
                'code' => 'M,N',
                'name' => 'Jasa Perusahaan'
            ],
            [
                'type' => 'Lapangan Usaha',
                'code' => 'O',
                'name' => 'Administrasi Pemerintahan, Pertahanan dan Jaminan Sosial Wajib'
            ],
            [
                'type' => 'Lapangan Usaha',
                'code' => 'P',
                'name' => 'Jasa Pendidikan'
            ],
            [
                'type' => 'Lapangan Usaha',
                'code' => 'Q',
                'name' => 'Jasa Kesehatan dan Kegiatan Sosial'
            ],
            [
                'type' => 'Lapangan Usaha',
                'code' => 'R,S,T,U',
                'name' => 'Jasa Lainnya'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
