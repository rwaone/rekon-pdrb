<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\subsector;

class SubsectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subsectors = [
            [
                'sector_id' => 1,
                'code' => 'a',
                'name' => 'Tanaman Pangan'
            ],
            [
                'sector_id' => 1,
                'code' => 'b',
                'name' => 'Tanaman Hortikultura Semusim'
            ],
            [
                'sector_id' => 1,
                'code' => 'c',
                'name' => 'Perkebunan Semusim'
            ],
            [
                'sector_id' => 1,
                'code' => 'd',
                'name' => 'Tanaman Hortikultura Tahunan dan Lainnya'
            ],
            [
                'sector_id' => 1,
                'code' => 'e',
                'name' => 'Perkebunan Tahunan'
            ],
            [
                'sector_id' => 1,
                'code' => 'f',
                'name' => 'Peternakan'
            ],
            [
                'sector_id' => 1,
                'code' => 'g',
                'name' => 'Jasa Pertanian dan Perburuan'
            ],
            [
                'sector_id' => 2,
                'code' => NULL,
                'name' => 'Kehutanan dan Penebangan Kayu'
            ],
            [
                'sector_id' => 3,
                'code' => NULL,
                'name' => 'Perikanan'
            ],
            [
                'sector_id' => 4,
                'code' => NULL,
                'name' => 'Pertambangan Minyak, Gas dan Panas Bumi'
            ],
            [
                'sector_id' => 5,
                'code' => NULL,
                'name' => 'Pertambangan Batubara dan Lignit'
            ],
            [
                'sector_id' => 6,
                'code' => NULL,
                'name' => 'Pertambangan Bijih Logam'
            ],
            [
                'sector_id' => 7,
                'code' => NULL,
                'name' => 'Pertambangan dan Penggalian Lainnya'
            ],
            [
                'sector_id' => 8,
                'code' => 'a',
                'name' => 'Industri Batubara'
            ],
            [
                'sector_id' => 8,
                'code' => 'b',
                'name' => 'Pengilangan Migas'
            ],
            [
                'sector_id' => 9,
                'code' => NULL,
                'name' => 'Industri Makanan dan Minuman'
            ],
            [
                'sector_id' => 10,
                'code' => NULL,
                'name' => 'Pengolahan Tembakau'
            ],
            [
                'sector_id' => 11,
                'code' => NULL,
                'name' => 'Industri Tekstil dan Pakaian Jadi'
            ],
            [
                'sector_id' => 12,
                'code' => NULL,
                'name' => 'Industri Kulit, Barang dari Kulit dan Alas Kaki'
            ],
            [
                'sector_id' => 13,
                'code' => NULL,
                'name' => 'Industri Kayu, Barang dari Kayu dan Gabus dan Barang Anyaman dari Bambu, Rotan dan Sejenisnya'
            ],
            [
                'sector_id' => 14,
                'code' => NULL,
                'name' => 'Industri Kertas dan Barang dari Kertas, Percetakan dan Reproduksi Media Rekaman'
            ],
            [
                'sector_id' => 15,
                'code' => NULL,
                'name' => 'Industri Kimia, Farmasi dan Obat Tradisional'
            ],
            [
                'sector_id' => 16,
                'code' => NULL,
                'name' => 'Industri Karet, Barang dari Karet dan Plastik'
            ],
            [
                'sector_id' => 17,
                'code' => NULL,
                'name' => 'Industri Barang Galian bukan Logam'
            ],
            [
                'sector_id' => 18,
                'code' => NULL,
                'name' => 'Industri Logam Dasar'
            ],
            [
                'sector_id' => 19,
                'code' => NULL,
                'name' => 'Industri Barang dari Logam, Komputer, Barang Elektronik, Optik dan Peralatan Listrik'
            ],
            [
                'sector_id' => 20,
                'code' => NULL,
                'name' => 'Industri Mesin dan Perlengkapan YTDL'
            ],
            [
                'sector_id' => 21,
                'code' => NULL,
                'name' => 'Industri Alat Angkutan'
            ],
            [
                'sector_id' => 22,
                'code' => NULL,
                'name' => 'Industri Furnitur'
            ],
            [
                'sector_id' => 23,
                'code' => NULL,
                'name' => 'Industri pengolahan lainnya, jasa reparasi dan pemasangan mesin dan peralatan'
            ],
            [
                'sector_id' => 24,
                'code' => NULL,
                'name' => 'Ketenagalistrikan'
            ],
            [
                'sector_id' => 25,
                'code' => NULL,
                'name' => ' Pengadaan Gas dan Produksi Es'
            ],
            [
                'sector_id' => 26,
                'code' => NULL,
                'name' => 'Pengadaan Air, Pengelolaan Sampah, Limbah dan Daur Ulang'
            ],
            [
                'sector_id' => 27,
                'code' => NULL,
                'name' => 'Konstruksi'
            ],
            [
                'sector_id' => 28,
                'code' => NULL,
                'name' => 'Perdagangan Mobil, Sepeda Motor dan Reparasinya'
            ],
            [
                'sector_id' => 29,
                'code' => NULL,
                'name' => ' Perdagangan Besar dan Eceran, Bukan Mobil dan Sepeda Motor'
            ],
            [
                'sector_id' => 30,
                'code' => NULL,
                'name' => 'Angkutan Rel'
            ],
            [
                'sector_id' => 31,
                'code' => NULL,
                'name' => 'Angkutan Darat'
            ],
            [
                'sector_id' => 32,
                'code' => NULL,
                'name' => 'Angkutan Laut'
            ],
            [
                'sector_id' => 33,
                'code' => NULL,
                'name' => 'Angkutan Sungai Danau dan Penyeberangan'
            ],
            [
                'sector_id' => 34,
                'code' => NULL,
                'name' => 'Angkutan Udara'
            ],
            [
                'sector_id' => 35,
                'code' => NULL,
                'name' => 'Pergudangan dan Jasa Penunjang Angkutan, Pos dan Kurir'
            ],
            [
                'sector_id' => 36,
                'code' => NULL,
                'name' => 'Penyediaan Akomodasi'
            ],
            [
                'sector_id' => 37,
                'code' => NULL,
                'name' => 'Penyediaan Makan Minum'
            ],
            [
                'sector_id' => 38,
                'code' => NULL,
                'name' => 'Informasi dan Komunikasi'
            ],
            [
                'sector_id' => 39,
                'code' => NULL,
                'name' => 'Jasa Perantara Keuangan'
            ],
            [
                'sector_id' => 40,
                'code' => NULL,
                'name' => 'Asuransi dan Dana Pensiun'
            ],
            [
                'sector_id' => 41,
                'code' => NULL,
                'name' => 'Jasa Keuangan Lainnya'
            ],
            [
                'sector_id' => 42,
                'code' => NULL,
                'name' => 'Jasa Penunjang Keuangan'
            ],
            [
                'sector_id' => 43,
                'code' => NULL,
                'name' => 'Real Estate'
            ],
            [
                'sector_id' => 44,
                'code' => NULL,
                'name' => 'Jasa Perusahaan'
            ],
            [
                'sector_id' => 45,
                'code' => NULL,
                'name' => 'Administrasi Pemerintahan, Pertahanan dan Jaminan Sosial Wajib'
            ],
            [
                'sector_id' => 46,
                'code' => NULL,
                'name' => 'Jasa Pendidikan'
            ],
            [
                'sector_id' => 47,
                'code' => NULL,
                'name' => 'Jasa Kesehatan dan Kegiatan Sosial'
            ],
            [
                'sector_id' => 48,
                'code' => NULL,
                'name' => 'Jasa Lainnya'
            ],
        ];

        foreach($subsectors as $subsector){
            Subsector::create($subsector);
        }
    }
}
