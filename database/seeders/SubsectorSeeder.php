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
                'type' => 'Lapangan Usaha',
                'code' => 'a',
                'name' => 'Tanaman Pangan'
            ],
            [
                'sector_id' => 1,
                'type' => 'Lapangan Usaha',
                'code' => 'b',
                'name' => 'Tanaman Hortikultura Semusim'
            ],
            [
                'sector_id' => 1,
                'type' => 'Lapangan Usaha',
                'code' => 'c',
                'name' => 'Perkebunan Semusim'
            ],
            [
                'sector_id' => 1,
                'type' => 'Lapangan Usaha',
                'code' => 'd',
                'name' => 'Tanaman Hortikultura Tahunan dan Lainnya'
            ],
            [
                'sector_id' => 1,
                'type' => 'Lapangan Usaha',
                'code' => 'e',
                'name' => 'Perkebunan Tahunan'
            ],
            [
                'sector_id' => 1,
                'type' => 'Lapangan Usaha',
                'code' => 'f',
                'name' => 'Peternakan'
            ],
            [
                'sector_id' => 1,
                'type' => 'Lapangan Usaha',
                'code' => 'g',
                'name' => 'Jasa Pertanian dan Perburuan'
            ],
            [
                'sector_id' => 2,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Kehutanan dan Penebangan Kayu'
            ],
            [
                'sector_id' => 3,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Perikanan'
            ],
            [
                'sector_id' => 4,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Pertambangan Minyak, Gas dan Panas Bumi'
            ],
            [
                'sector_id' => 5,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Pertambangan Batubara dan Lignit'
            ],
            [
                'sector_id' => 6,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Pertambangan Bijih Logam'
            ],
            [
                'sector_id' => 7,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Pertambangan dan Penggalian Lainnya'
            ],
            [
                'sector_id' => 8,
                'type' => 'Lapangan Usaha',
                'code' => 'a',
                'name' => 'Industri Batubara'
            ],
            [
                'sector_id' => 8,
                'type' => 'Lapangan Usaha',
                'code' => 'b',
                'name' => 'Pengilangan Migas'
            ],
            [
                'sector_id' => 9,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Industri Makanan dan Minuman'
            ],
            [
                'sector_id' => 10,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Pengolahan Tembakau'
            ],
            [
                'sector_id' => 11,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Industri Tekstil dan Pakaian Jadi'
            ],
            [
                'sector_id' => 12,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Industri Kulit, Barang dari Kulit dan Alas Kaki'
            ],
            [
                'sector_id' => 13,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Industri Kayu, Barang dari Kayu dan Gabus dan Barang Anyaman dari Bambu, Rotan dan Sejenisnya'
            ],
            [
                'sector_id' => 14,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Industri Kertas dan Barang dari Kertas, Percetakan dan Reproduksi Media Rekaman'
            ],
            [
                'sector_id' => 15,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Industri Kimia, Farmasi dan Obat Tradisional'
            ],
            [
                'sector_id' => 16,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Industri Karet, Barang dari Karet dan Plastik'
            ],
            [
                'sector_id' => 17,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Industri Barang Galian bukan Logam'
            ],
            [
                'sector_id' => 18,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Industri Logam Dasar'
            ],
            [
                'sector_id' => 19,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Industri Barang dari Logam, Komputer, Barang Elektronik, Optik dan Peralatan Listrik'
            ],
            [
                'sector_id' => 20,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Industri Mesin dan Perlengkapan YTDL'
            ],
            [
                'sector_id' => 21,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Industri Alat Angkutan'
            ],
            [
                'sector_id' => 22,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Industri Furnitur'
            ],
            [
                'sector_id' => 23,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Industri pengolahan lainnya, jasa reparasi dan pemasangan mesin dan peralatan'
            ],
            [
                'sector_id' => 24,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Ketenagalistrikan'
            ],
            [
                'sector_id' => 25,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => ' Pengadaan Gas dan Produksi Es'
            ],
            [
                'sector_id' => 26,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Pengadaan Air, Pengelolaan Sampah, Limbah dan Daur Ulang'
            ],
            [
                'sector_id' => 27,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Konstruksi'
            ],
            [
                'sector_id' => 28,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Perdagangan Mobil, Sepeda Motor dan Reparasinya'
            ],
            [
                'sector_id' => 29,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => ' Perdagangan Besar dan Eceran, Bukan Mobil dan Sepeda Motor'
            ],
            [
                'sector_id' => 30,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Angkutan Rel'
            ],
            [
                'sector_id' => 31,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Angkutan Darat'
            ],
            [
                'sector_id' => 32,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Angkutan Laut'
            ],
            [
                'sector_id' => 33,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Angkutan Sungai Danau dan Penyeberangan'
            ],
            [
                'sector_id' => 34,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Angkutan Udara'
            ],
            [
                'sector_id' => 35,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Pergudangan dan Jasa Penunjang Angkutan, Pos dan Kurir'
            ],
            [
                'sector_id' => 36,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Penyediaan Akomodasi'
            ],
            [
                'sector_id' => 37,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Penyediaan Makan Minum'
            ],
            [
                'sector_id' => 38,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Informasi dan Komunikasi'
            ],
            [
                'sector_id' => 39,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Jasa Perantara Keuangan'
            ],
            [
                'sector_id' => 40,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Asuransi dan Dana Pensiun'
            ],
            [
                'sector_id' => 41,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Jasa Keuangan Lainnya'
            ],
            [
                'sector_id' => 42,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Jasa Penunjang Keuangan'
            ],
            [
                'sector_id' => 43,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Real Estate'
            ],
            [
                'sector_id' => 44,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Jasa Perusahaan'
            ],
            [
                'sector_id' => 45,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Administrasi Pemerintahan, Pertahanan dan Jaminan Sosial Wajib'
            ],
            [
                'sector_id' => 46,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Jasa Pendidikan'
            ],
            [
                'sector_id' => 47,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Jasa Kesehatan dan Kegiatan Sosial'
            ],
            [
                'sector_id' => 48,
                'type' => 'Lapangan Usaha',
                'code' => NULL,
                'name' => 'Jasa Lainnya'
            ],
        ];

        foreach ($subsectors as $subsector) {
            Subsector::create($subsector);
        }
    }
}
