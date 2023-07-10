<?php

namespace App\Http\Controllers;

use App\Models\Pdrb;
use App\Models\Period;
use App\Models\Region;
use App\Models\Category;
use App\Models\Subsector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{
    //
    public function getKonserda(Request $request)
    {
        $period_id = $request->query('period_id');
        $typeof = $request->query('type');
        if ($typeof == 'show') {
            $typeof = 'quarter';
        }
        $regions = Region::select('id')->get();
        $period_now = Period::where('id', $period_id)->first();
        $quarter_check = Pdrb::select('quarter')->where('type', 'Pengeluaran')->where('period_id', $period_id)->first();
        $quarters = [1, 2, 3, 4];

        if ($typeof == 'quarter') {
            if (in_array($quarter_check->quarter, $quarters)) {
                $quarter_before = $quarter_check->quarter - 1;
                if ($quarter_before == 0) {
                    $quarter_before = 4;
                    $period_before = Period::where('status', 'Final')->where('type', 'Pengeluaran')->where('year', $period_now->year - 1)->where('quarter', $quarter_before)->first();
                } else {
                    $period_before = Period::where('status', 'Final')->where('type', 'Pengeluaran')->where('year', $period_now->year)->where('quarter', $quarter_before)->first();
                }
            }
            $datas = [];
            foreach ($regions as $region) {
                $datas['pdrb-' . $region->id] = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $period_id)->where('region_id', $region->id)->orderBy('subsector_id')->get();
            }
            $befores = [];
            if ($period_before) {
                foreach ($regions as $region) {
                    $befores['pdrb-' . $region->id] = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $period_before->id)->where('region_id', $region->id)->orderBy('subsector_id')->get();
                }
            }
        } elseif ($typeof == 'year') {
            $period_before = Period::where('status', 'Final')->where('type', 'Pengeluaran')->where('year', $period_now->year - 1)->where('quarter', $quarter_check->quarter)->first();
            $datas = [];
            foreach ($regions as $region) {
                $datas['pdrb-' . $region->id] = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $period_id)->where('region_id', $region->id)->orderBy('subsector_id')->get();
            }
            $befores = [];
            if ($period_before) {
                foreach ($regions as $region) {
                    $befores['pdrb-' . $region->id] = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $period_before->id)->where('region_id', $region->id)->orderBy('subsector_id')->get();
                }
            }
        } elseif ($typeof == 'cumulative') {
            $period_before = Period::where('status', 'Final')->where('type', 'Pengeluaran')->where('year', $period_now->year - 1)->where('quarter', '<=', $quarter_check->quarter)->pluck('id')->toArray();
            $period_cumulative_now = Period::where('year', $period_now->year)->where('quarter', '<=', $quarter_check->quarter)->pluck('id')->toArray();
            $datas = [];
            foreach ($regions as $region) {
                $datas['pdrb-' . $region->id] = Pdrb::selectRaw('subsector_id, sum(adhb) as adhb, sum(adhk) as adhk')
                    ->whereIn('period_id', $period_cumulative_now)
                    ->where('region_id', $region->id)
                    ->groupBy('subsector_id')
                    ->get();
            }

            $befores = [];
            if ($period_before) {
                foreach ($regions as $region) {
                    $befores['pdrb-' . $region->id] = Pdrb::selectRaw('subsector_id, sum(adhb) as adhb, sum(adhk) as adhk')
                        ->whereIn('period_id', $period_before)
                        ->where('region_id', $region->id)
                        ->groupBy('subsector_id')
                        ->get();
                }
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
        $daftar_1 = Pdrb::select('region_id', 'period_id', 'quarter')->where('type', 'Pengeluaran')->where('quarter', 'Y')->groupBy('region_id', 'period_id', 'quarter')->orderByDesc('year')->orderBy('region_id')->get();
        foreach ($daftar_1 as $item) {
            $item->number = $number;
            $number++;
        }
        $number = 1;
        if (Auth::user()->satker_id == 1) {
            $daftar_2 = Pdrb::select('region_id', 'period_id', 'quarter')->where('type', 'Pengeluaran')->where('region_id', '1')->whereNotIn('quarter', ['Y'])->groupBy('region_id', 'period_id', 'quarter')->get();
            foreach ($daftar_2 as $item) {
                $item->number = $number;
                $number++;
            }
        } else {
            $daftar_2 = Pdrb::select('region_id', 'period_id', 'quarter')->where('type', 'Pengeluaran')->whereNotIn('region_id', ['1'])->whereNotIn('quarter', ['Y'])->groupBy('region_id', 'period_id', 'quarter')->get();
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

    public function rekonsiliasi()
    {
        $cat = Category::pluck('code')->toArray();
        $catString = implode(", ", $cat);
        $regions = Region::getMyRegion();
        $subsectors = Subsector::where('type', 'Pengeluaran')->get();
        $type = 'Pengeluaran';
        return view('rekonsiliasi.view', [
            'cat' => $catString,
            'subsectors' => $subsectors,
            'regions' => $regions,
            'type' => $type,
        ]);
    }

    public function fenomena()
    {
        $type = 'Pengeluaran';
        $cat = Category::pluck('code')->toArray();
        $catString = implode(", ", $cat);
        $regions = Region::getMyRegion();
        $category = Category::where('type', $type)->get();
        $subsectors = Subsector::where('type', $type)->get();
        return view('fenomena.view', [
            'cat' => $catString,
            'subsectors' => $subsectors,
            'regions' => $regions,
            'type' => $type,
            'category' => $category,
        ]);
    }

    public function detailPokok(Request $request)
    {
        $period_id = $request->query('period_id');
        $region_id = $request->query('region_id');
        $quarter = $request->query('quarter');

        $subsectors = Subsector::where('type', 'Pengeluaran')->get();
        $cat = Category::pluck('code')->toArray();
        $catString = implode(", ", $cat);

        return view('pengeluaran.detail-pokok-quarter', [
            'subsectors' => $subsectors,
            'cat' => $catString,
        ]);
    }

    public function getDetail(Request $request)
    {
        $period_id = $request->query('period_id');
        $region_id = $request->query('region_id');
        $quarter = $request->query('quarter');
        $period = Period::where('id', $period_id)->first();
        $year_ = $period->year;
        // var_dump($year_);
        $quarters = [1, 2, 3, 4];
        $periods = [];
        foreach ($quarters as $item) {
            $per = Period::select('id')->where('quarter', $item)->where('type', 'Pengeluaran')->where('year', $year_)->first();
            if ($per) {
                array_push($periods, $per->id);
            } else {
                array_push($periods, 0);
            }
        }
        foreach ($periods as $key => $item) {
            $datas['pdrb-' . ($key + 1)] = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $item)->where('region_id', $region_id)->orderBy('subsector_id')->get();
        }
        return response()->json([
            'data' => $datas,
            // 'periodes' => $periods
        ]);
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
