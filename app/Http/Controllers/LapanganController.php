<?php

namespace App\Http\Controllers;

use App\Models\Pdrb;
use App\Models\Period;
use App\Models\Region;
use App\Models\Dataset;
use App\Models\Category;
use App\Models\Subsector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LapanganController extends Controller
{
    //
    public function rekonsiliasi()
    {
        $cat = Category::pluck('id')->toArray();
        $catString = implode(", ", $cat);
        $regions = Region::getMyRegion();
        $type = 'Lapangan Usaha';
        $subsectors = Subsector::where('type', 'Lapangan Usaha')->get();
        return view('rekonsiliasi.view', [
            'cat' => $catString,
            'regions' => $regions,
            'subsectors' => $subsectors,
            'type' => $type,
        ]);
    }

    public function fenomena()
    {
        $type = 'Lapangan Usaha';
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

    public function getKonserda(Request $request)
    {
        $period_id = $request->query('period_id');
        $typeof = $request->query('type');
        if ($typeof == 'show') {
            $typeof = 'quarter';
        }
        $regions = Region::select('id')->get();
        $period_now = Period::where('id', $period_id)->first();
        $quarter_check = $request->query('data_quarter');
        $quarters = [1, 2, 3, 4];

        if ($typeof == 'quarter') {
            if (in_array($quarter_check, $quarters)) {
                $quarter_before = $quarter_check - 1;
                if ($quarter_before == 0) {
                    $quarter_before = 4;
                    $period_before = Period::where('status', 'Final')->where('type', 'Lapangan Usaha')->where('year', $period_now->year - 1)->where('quarter', $quarter_before)->first();
                } else {
                    // $period_before = Period::where('status', 'Final')->where('type', 'Lapangan Usaha')->where('year', $period_now->year)->where('quarter', $quarter_before)->first();
                    $period_before = $period_now;
                }
            }
            $datas = [];
            foreach ($regions as $region) {
                $datas['pdrb-' . $region->id] = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $period_id)->where('region_id', $region->id)->where('quarter', $quarter_check)->orderBy('subsector_id')->get();
            }
            $befores = [];
            if ($period_before) {
                foreach ($regions as $region) {
                    $befores['pdrb-' . $region->id] = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $period_before->id)->where('quarter', $quarter_before)->where('region_id', $region->id)->orderBy('subsector_id')->get();
                }
            }
            // APA ITU HARUS CEK KUARTER NYA?!
        } elseif ($typeof == 'year') {
            $period_before = Period::where('status', 'Final')->where('type', 'Lapangan Usaha')->where('year', $period_now->year - 1)->where('quarter', 4)->first();
            // $period_before = Period::where('status', 'Final')->where('type', 'Lapangan Usaha')->where('year', $period_now->year - 1)->where('quarter', $quarter_check->quarter)->first();
            $datas = [];
            foreach ($regions as $region) {
                $datas['pdrb-' . $region->id] = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $period_id)->where('quarter', $quarter_check)->where('region_id', $region->id)->orderBy('subsector_id')->get();
            }
            $befores = [];
            if ($period_before) {
                foreach ($regions as $region) {
                    $befores['pdrb-' . $region->id] = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $period_before->id)->where('quarter', $quarter_check)->where('region_id', $region->id)->orderBy('subsector_id')->get();
                }
            }
            //KACAU KUMULATIFNYA!!
        } elseif ($typeof == 'cumulative') {
            // $period_before = Period::where('status', 'Final')->where('type', 'Lapangan Usaha')->where('year', $period_now->year - 1)->where('quarter', '<=', $quarter_check->quarter)->pluck('id')->toArray();
            $period_before = Period::where('status', 'Final')->where('type', 'Lapangan Usaha')->where('year', $period_now->year - 1)->where('quarter', 4)->pluck('id')->toArray();
            // $period_cumulative_now = Period::where('year', $period_now->year)->where('quarter', '<=', $quarter_check->quarter)->pluck('id')->toArray();
            switch ($quarter_check) {
                case 4:
                    $quarter_cumulative = range(1, 4);
                    break;
                case 3:
                    $quarter_cumulative = range(1, 3);
                    break;
                case 2:
                    $quarter_cumulative = range(1, 2);
                    break;
                default:
                    $quarter_cumulative = [1];
                    break;
            }

            $datas = [];
            // foreach ($regions as $region) {
            //     $datas['pdrb-' . $region->id] = Pdrb::selectRaw('subsector_id, sum(adhb) as adhb, sum(adhk) as adhk')
            //         ->whereIn('period_id', $period_cumulative_now)
            //         ->where('region_id', $region->id)
            //         ->groupBy('subsector_id')
            //         ->get();
            // }
            foreach ($regions as $region) {
                $datas['pdrb-' . $region->id] = Pdrb::selectRaw('subsector_id, sum(adhb) as adhb, sum(adhk) as adhk')
                    ->where('period_id', $period_id)
                    ->whereIn('quarter', $quarter_cumulative)
                    ->where('region_id', $region->id)
                    ->groupBy('subsector_id')
                    ->get();
            }

            $befores = [];
            // if ($period_before) {
            //     foreach ($regions as $region) {
            //         $befores['pdrb-' . $region->id] = Pdrb::selectRaw('subsector_id, sum(adhb) as adhb, sum(adhk) as adhk')
            //             ->whereIn('period_id', $period_before)
            //             ->where('region_id', $region->id)
            //             ->groupBy('subsector_id')
            //             ->get();
            //     }
            // }
            if ($period_before) {
                foreach ($regions as $region) {
                    $befores['pdrb-' . $region->id] = Pdrb::selectRaw('subsector_id, sum(adhb) as adhb, sum(adhk) as adhk')
                        ->where('period_id', $period_before)
                        ->whereIn('quarter', $quarter_cumulative)
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
        // dd(Region::getMyRegionId());
        $number = 1;
        $daftar = Dataset::select('region_id', 'period_id', 'year')
            ->where('type', 'Lapangan Usaha')
            ->whereIn('region_id', Region::getMyRegionId())
            ->groupBy('region_id', 'period_id', 'year')
            ->orderBy('year', 'desc')
            ->orderBy('quarter', 'desc')
            ->orderBy('region_id')
            ->get();
        foreach ($daftar as $item) {
            $item->number = $number;
            $number++;
        }

        return view('lapangan.tabel-pokok', [
            'daftar_2' => $daftar,
        ]);
    }

    // public function detailPokok($period_id, $region_id, $quarter)
    public function detailPokok(Request $request)
    {
        $period_id = $request->query('period_id');
        $region_id = $request->query('region_id');
        $quarter = $request->query('quarter');
        $subsectors = Subsector::where('type', 'Lapangan Usaha')->get();
        $cat = Category::pluck('code')->toArray();
        $catString = implode(", ", $cat);

        return view('lapangan.detail-pokok-quarter', [
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

        $period_before = Period::where('year', $period->year - 1)
            ->where('quarter', 4)
            ->where('type', 'Lapangan Usaha')
            ->latest('id')
            ->first();

        $previous_dataset = Dataset::where('period_id', $period_before->id)
            ->where('region_id', $region_id)
            ->first();
        
        
            // return response()->json($previous_dataset);

        $current_dataset = Dataset::where('period_id', $period_id)
            ->where('region_id', $region_id)
            ->first();

        $befores = [];

        for ($index = 1; $index <= 4; $index++) {
            if ($period_before) {
                $befores['pdrb-' . $index] = Pdrb::select('subsector_id', 'adhk', 'adhb')
                    ->where('dataset_id', $previous_dataset->id)
                    ->where('quarter', $index)
                    ->orderBy('subsector_id')
                    ->get();
            }
            $datas['pdrb-' . $index] = Pdrb::select('subsector_id', 'adhk', 'adhb')
                ->where('quarter', $index)
                ->where('dataset_id', $current_dataset->id)
                ->orderBy('subsector_id')
                ->get();

            if (count($datas['pdrb-' . $index]) == 0) {
                $defaultValues = [
                    'subsector_id' => null,
                    'adhk' => '-',
                    'adhb' => '-',
                ];
                $datas['pdrb-' . $index] = array_fill(0, 55, $defaultValues);
            }
            // }
        }
        return response()->json([
            'data' => $datas,
            'before' => $befores,
            'current' => $current_dataset,
            'previous' => $previous_dataset,
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
        $subsectors = Subsector::where('type', 'Lapangan Usaha')->get();
        return view('lapangan.konserda', [
            'regions' => $regions,
            'subsectors' => $subsectors,
            'cat' => $catString,
            'years' => isset($years) ? $years : NULL,
            'quarters'  => isset($quarters) ? $quarters : NULL,
            'periods' => isset($periods) ? $periods : NULL,
            'filter' => isset($filter) ? $filter : ['type' => ''],
        ]);
    }
    public function monitoring()
    {
        $quarter = [1, 2, 3, 4];
        $regions = Region::getMyRegion();
        $year_active = Period::where('type', 'Lapangan Usaha')->where('status', 'Aktif')->get('year');
        $max_year = $year_active->max('year');
        $monitoring_quarter = [];
        foreach ($year_active as $year) {
            $quarter_active = Period::select('id', 'quarter', 'description')->where('year', $year->year)->where('type', 'Lapangan Usaha')->whereIn('status', ['Selesai', 'Aktif'])->get();
            foreach ($quarter_active as $quarters) {
                foreach ($regions as $region) {
                    $data = Pdrb::where('region_id', $region->id)->where('period_id', $quarters->id)->where('quarter', $quarters->quarter)->get(['adhk', 'adhb']);
                    $data_adhb = $data->pluck('adhb');
                    $data_adhk = $data->pluck('adhk');
                    if ($data_adhb->contains(null)) {
                        $data_adhb = 0;
                    } else {
                        $data_adhb = 1;
                    }
                    if ($data_adhk->contains(null)) {
                        $data_adhk = 0;
                    } else {
                        $data_adhk = 1;
                    }
                    $monitoring_quarter[$year->year][$quarters->quarter][$region->name]['description'] = Period::select('description')->where('id', $quarters->id)->pluck('description');
                    $monitoring_quarter[$year->year][$quarters->quarter][$region->name]['adhk'] = $data_adhk;
                    $monitoring_quarter[$year->year][$quarters->quarter][$region->name]['adhb'] = $data_adhb;
                }
            }
        }


        return view('lapangan.monitoring', [
            'max_year' => $max_year,
            'monitoring_quarter' => $monitoring_quarter,
        ]);
    }
}
