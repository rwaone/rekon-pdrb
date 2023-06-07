<?php

namespace App\Http\Controllers;

use App\Models\Pdrb;
use App\Models\Period;
use App\Models\Region;
use App\Models\Category;
use App\Models\Subsector;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{
    //
    public function getKonserda($period_id)
    {
        $regions = Region::select('id')->get();
        $period_now = Period::where('id', $period_id)->first();
        $quarter_check = Pdrb::select('quarter')->where('type', 'Pengeluaran')->where('period_id', $period_id)->first();
        $quarters = [1, 2, 3, 4];
        if ($quarter_check->quarter == 'Y') {
            $year_ = $period_now->year - 1;
            $period_before = Period::where('year', $year_)->where('quarter', 'Y')->first();
        } elseif (in_array($quarter_check->quarter, $quarters)) {
            $quarter_before = $quarter_check->quarter - 1;
            $period_before = Period::where('year', $period_now->year)->where('quarter', $quarter_before)->first();
        }
        $datas = [];
        foreach ($regions as $region) {
            $datas['pdrb-' . $region->id] = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('type', 'Pengeluaran')->where('period_id', $period_id)->where('region_id', $region->id)->orderBy('subsector_id')->get();
        }
        $befores = [];
        if ($period_before) {
            foreach ($regions as $region) {
                $befores['pdrb-' . $region->id] = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('type', 'Pengeluaran')->where('period_id', $period_before->id)->where('region_id', $region->id)->orderBy('subsector_id')->get();
            }
        }

        return response()->json([
            'data' => $datas,
            'before' => $befores
        ]);
    }

    public function daftarPokok()
    {
        $number = 1;
        $daftar_1 = Pdrb::select('region_id', 'period_id', 'quarter')->where('quarter', 'Y')->groupBy('region_id', 'period_id', 'quarter')->orderByDesc('year')->orderBy('region_id')->get();
        foreach ($daftar_1 as $item) {
            $item->number = $number;
            $number++;
        }
        $number = 1;
        if (Auth::user()->satker_id == 1) {
            $daftar_2 = Pdrb::select('region_id', 'period_id', 'quarter')->where('region_id', '1')->whereNotIn('quarter', ['Y'])->groupBy('region_id', 'period_id', 'quarter')->get();
            foreach ($daftar_2 as $item) {
                $item->number = $number;
                $number++;
            }
        } else {
            $daftar_2 = Pdrb::select('region_id', 'period_id', 'quarter')->whereNotIn('region_id', ['1'])->whereNotIn('quarter', ['Y'])->groupBy('region_id', 'period_id', 'quarter')->get();
            foreach ($daftar_2 as $item) {
                $item->number = $number;
                $number++;
            }
        }
        return view('pengeluaran.tabel-pokok', [
            'daftar_1' => $daftar_1,
            'daftar_2' => $daftar_2,
        ]);
    }

    public function detailPokok($period_id, $region_id, $quarter)
    {
        $subsectors = Subsector::where('type', 'Pengeluaran')->get();
        $period = Period::where('id', $period_id)->first();
        $year_ = $period->year;
        $quarters = [1, 2, 3, 4];
        $cat = Category::pluck('code')->toArray();
        $catString = implode(", ", $cat);
        if ($quarter === 'Y') {
            $years = [];
            array_push($years, $year_);
            for ($i = 1; $i <= 4; $i++) {
                array_push($years, $year_ - $i);
            }
            $periods = [];
            foreach ($years as $item) {
                $per = Period::select('id')->where('quarter', 'Y')->where('year', $item)->first();
                if ($per) {
                    array_push($periods, $per->id);
                } else {
                    array_push($periods, 0);
                }
            }
            $pdrb_1 = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $periods[4])->where('region_id', $region_id)->orderBy('subsector_id')->get();
            $pdrb_2 = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $periods[3])->where('region_id', $region_id)->orderBy('subsector_id')->get();
            $pdrb_3 = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $periods[2])->where('region_id', $region_id)->orderBy('subsector_id')->get();
            $pdrb_4 = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $periods[1])->where('region_id', $region_id)->orderBy('subsector_id')->get();
            $pdrb = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $period_id)->where('region_id', $region_id)->orderBy('subsector_id')->get();

            $datas = [
                'pdrb-1' => $pdrb_1,
                'pdrb-2' => $pdrb_2,
                'pdrb-3' => $pdrb_3,
                'pdrb-4' => $pdrb_4,
                'pdrb-5' => $pdrb,
            ];
            $adhk = [];
            $adhb = [];
            foreach ($datas as $key => $item) {
                $adhk[$key] = $item->pluck('adhk')->toArray();
                $adhb[$key] = $item->pluck('adhb')->toArray();
            }
            $adhk = json_encode($adhk);
            $adhb = json_encode($adhb);
            return view('pengeluaran.detail-pokok', [
                'subsectors' => $subsectors,
                'cat' => $catString,
                'adhk' => $adhk,
                'adhb' => $adhb,
                'pdrb_1' => $pdrb_1,
                'pdrb_2' => $pdrb_2,
                'pdrb_3' => $pdrb_3,
                'pdrb_4' => $pdrb_4,
                'years' => $years,
                'pdrb' => $pdrb,
            ]);
        } elseif (in_array($quarter, $quarters)) {
            $periods = [];
            foreach ($quarters as $item) {
                $per = Period::select('id')->where('quarter', $item)->where('year', $year_)->first();
                if ($per) {
                    array_push($periods, $per->id);
                } else {
                    array_push($periods, 0);
                }
            }
            $pdrb_1 = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $periods[0])->where('region_id', $region_id)->orderBy('subsector_id')->get();
            $pdrb_2 = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $periods[1])->where('region_id', $region_id)->orderBy('subsector_id')->get();
            $pdrb_3 = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $periods[2])->where('region_id', $region_id)->orderBy('subsector_id')->get();
            $pdrb_4 = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $periods[3])->where('region_id', $region_id)->orderBy('subsector_id')->get();

            $datas = [
                'pdrb-1' => $pdrb_1,
                'pdrb-2' => $pdrb_2,
                'pdrb-3' => $pdrb_3,
                'pdrb-4' => $pdrb_4,
            ];
            $adhk = [];
            $adhb = [];
            foreach ($datas as $key => $item) {
                $adhk[$key] = $item->pluck('adhk')->toArray();
                $adhb[$key] = $item->pluck('adhb')->toArray();
            }
            $adhk = json_encode($adhk);
            $adhb = json_encode($adhb);
            return view('pengeluaran.detail-pokok-quarter', [
                'subsectors' => $subsectors,
                'cat' => $catString,
                'adhk' => $adhk,
                'adhb' => $adhb,
                'pdrb_1' => $pdrb_1,
                'pdrb_2' => $pdrb_2,
                'pdrb_3' => $pdrb_3,
                'pdrb_4' => $pdrb_4,
            ]);
        }
    }

    public function konserda()
    {
        $filter = [
            'type' => '',
            'year' => '',
            'quarter' => '',
            'period_id' => '',
            'region_id' => '',
            'price_base' => '',
        ];

        $regions = Region::all();
        $cat = Category::pluck('code')->toArray();
        $catString = implode(", ", $cat);
        $subsectors = Subsector::where('type', 'Pengeluaran')->get();
        return view('pengeluaran.konserda', [
            'regions' => $regions,
            'subsectors' => $subsectors,
            'cat' => $catString,
            'years' => isset($years) ? $years : NULL,
            'quarters'  => isset($quarters) ? $quarters : NULL,
            'periods' => isset($periods) ? $periods : NULL,
            'filter' => isset($filter) ? $filter : ['type' => ''],
        ]);
    }
}
