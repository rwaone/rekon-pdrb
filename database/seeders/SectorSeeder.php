<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\sector;

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
                'category_id' => 1,
                'code' => '1',
                'name' => 'Pertanian, Peternakan, Perburuan dan Jasa'
            ],
            [
                'category_id' => 1,
                'code' => '2',
                'name' => 'Kehutanan dan Penebangan Kayu'
            ],
            [
                'category_id' => 1,
                'code' => '3',
                'name' => 'Perikanan'
            ],
            [
                'category_id' => 2,
                'code' => '1',
                'name' => 'Pertambangan Minyak, Gas dan Panas Bumi'
            ],
            [
                'category_id' => 2,
                'code' => '2',
                'name' => 'Pertambangan Batubara dan Lignit'
            ],
            [
                'category_id' => 2,
                'code' => '3',
                'name' => 'Pertambangan Bijih Logam'
            ],
            [
                'category_id' => 2,
                'code' => '4',
                'name' => 'Pertambangan dan Penggalian Lainnya'
            ],
            [
                'category_id' => 3,
                'code' => '1',
                'name' => 'Industri Batubara dan Pengilangan Migas'
            ],
            [
                'category_id' => 3,
                'code' => '2',
                'name' => 'Industri Makanan dan Minuman'
            ],
            [
                'category_id' => 3,
                'code' => '3',
                'name' => 'Pengolahan Tembakau'
            ],
            [
                'category_id' => 3,
                'code' => '4',
                'name' => 'Industri Tekstil dan Pakaian Jadi'
            ],
            [
                'category_id' => 3,
                'code' => '5',
                'name' => 'Industri Kulit, Barang dari Kulit dan Alas Kaki'
            ],
            [
                'category_id' => 3,
                'code' => '6',
                'name' => 'Industri Kayu, Barang dari Kayu dan Gabus dan Barang Anyaman dari Bambu, Rotan dan Sejenisnya'
            ],
            [
                'category_id' => 3,
                'code' => '7',
                'name' => 'Industri Kertas dan Barang dari Kertas, Percetakan dan Reproduksi Media Rekaman'
            ],
            [
                'category_id' => 3,
                'code' => '8',
                'name' => 'Industri Kimia, Farmasi dan Obat Tradisional'
            ],
            [
                'category_id' => 3,
                'code' => '9',
                'name' => 'Industri Karet, Barang dari Karet dan Plastik'
            ],
            [
                'category_id' => 3,
                'code' => '10',
                'name' => 'Industri Barang Galian bukan Logam'
            ],
            [
                'category_id' => 3,
                'code' => '11',
                'name' => 'Industri Logam Dasar'
            ],
            [
                'category_id' => 3,
                'code' => '12',
                'name' => 'Industri Barang dari Logam, Komputer, Barang Elektronik, Optik dan Peralatan Listrik'
            ],
            [
                'category_id' => 3,
                'code' => '13',
                'name' => 'Industri Mesin dan Perlengkapan YTDL'
            ],
            [
                'category_id' => 3,
                'code' => '14',
                'name' => 'Industri Alat Angkutan'
            ],
            [
                'category_id' => 3,
                'code' => '15',
                'name' => 'Industri Furnitur'
            ],
            [
                'category_id' => 3,
                'code' => '16',
                'name' => 'Industri pengolahan lainnya, jasa reparasi dan pemasangan mesin dan peralatan'
            ],
            [
                'category_id' => 4,
                'code' => '1',
                'name' => 'Ketenagalistrikan'
            ],
            [
                'category_id' => 4,
                'code' => '2',
                'name' => ' Pengadaan Gas dan Produksi Es'
            ],
            [
                'category_id' => 5,
                'code' => NULL,
                'name' => 'Pengadaan Air, Pengelolaan Sampah, Limbah dan Daur Ulang'
            ],
            [
                'category_id' => 6,
                'code' => NULL,
                'name' => 'Konstruksi'
            ],
            [
                'category_id' => 7,
                'code' => '1',
                'name' => 'Perdagangan Mobil, Sepeda Motor dan Reparasinya'
            ],
            [
                'category_id' => 7,
                'code' => '2',
                'name' => ' Perdagangan Besar dan Eceran, Bukan Mobil dan Sepeda Motor'
            ],
            [
                'category_id' => 8,
                'code' => '1',
                'name' => 'Angkutan Rel'
            ],
            [
                'category_id' => 8,
                'code' => '2',
                'name' => 'Angkutan Darat'
            ],
            [
                'category_id' => 8,
                'code' => '3',
                'name' => 'Angkutan Laut'
            ],
            [
                'category_id' => 8,
                'code' => '4',
                'name' => 'Angkutan Sungai Danau dan Penyeberangan'
            ],
            [
                'category_id' => 8,
                'code' => '5',
                'name' => 'Angkutan Udara'
            ],
            [
                'category_id' => 8,
                'code' => '6',
                'name' => 'Pergudangan dan Jasa Penunjang Angkutan, Pos dan Kurir'
            ],
            [
                'category_id' => 9,
                'code' => '1',
                'name' => 'Penyediaan Akomodasi'
            ],
            [
                'category_id' => 9,
                'code' => '2',
                'name' => 'Penyediaan Makan Minum'
            ],
            [
                'category_id' => 10,
                'code' => NULL,
                'name' => 'Informasi dan Komunikasi'
            ],
            [
                'category_id' => 11,
                'code' => '1',
                'name' => 'Jasa Perantara Keuangan'
            ],
            [
                'category_id' => 11,
                'code' => '2',
                'name' => 'Asuransi dan Dana Pensiun'
            ],
            [
                'category_id' => 11,
                'code' => '3',
                'name' => 'Jasa Keuangan Lainnya'
            ],
            [
                'category_id' => 11,
                'code' => '4',
                'name' => 'Jasa Penunjang Keuangan'
            ],
            [
                'category_id' => 12,
                'code' => NULL,
                'name' => 'Real Estate'
            ],
            [
                'category_id' => 13,
                'code' => NULL,
                'name' => 'Jasa Perusahaan'
            ],
            [
                'category_id' => 14,
                'code' => NULL,
                'name' => 'Administrasi Pemerintahan, Pertahanan dan Jaminan Sosial Wajib'
            ],
            [
                'category_id' => 15,
                'code' => NULL,
                'name' => 'Jasa Pendidikan'
            ],
            [
                'category_id' => 16,
                'code' => NULL,
                'name' => 'Jasa Kesehatan dan Kegiatan Sosial'
            ],
            [
                'category_id' => 17,
                'code' => NULL,
                'name' => 'Jasa Lainnya'
            ],
        ];

        foreach($sectors as $sector){
            Sector::create($sector);
        }
    }
}
