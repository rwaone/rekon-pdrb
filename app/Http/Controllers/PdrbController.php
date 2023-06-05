<?php

namespace App\Http\Controllers;

use App\Models\Pdrb;
use App\Models\Period;
use App\Models\Region;
use App\Models\Satker;
use App\Models\Sector;
use App\Models\Category;
use App\Models\Subsector;
use Illuminate\Http\Request;
use App\Http\Requests\StorepdrbRequest;
use App\Http\Requests\UpdatepdrbRequest;
use App\Http\Requests\StoreFilterRequest;

class PdrbController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorepdrbRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorepdrbRequest $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pdrb  $pdrb
     * @return \Illuminate\Http\Response
     */
    public function show(pdrb $pdrb)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pdrb  $pdrb
     * @return \Illuminate\Http\Response
     */
    public function edit(pdrb $pdrb)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepdrbRequest  $request
     * @param  \App\Models\pdrb  $pdrb
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatepdrbRequest $request, pdrb $pdrb)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pdrb  $pdrb
     * @return \Illuminate\Http\Response
     */
    public function destroy(pdrb $pdrb)
    {
        //
    }

    public function getKonserda($period_id)
    {
        // $pdrb = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $period_id)->where('region_id', '1')->orderBy('subsector_id')->get();
        $regions = Region::select('id')->get();
        $period_now = Period::where('id', $period_id)->first();
        $year_ = $period_now->year - 1;
        $period_before = Period::where('year', $year_)->where('quarter', 'Y')->first();
        $datas = [];
        foreach ($regions as $region) {
            $datas['pdrb-' . $region->id] = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $period_id)->where('quarter', 'Y')->where('region_id', $region->id)->orderBy('subsector_id')->get();
        }
        $befores = [];
        if ($period_before){
            foreach ($regions as $region) {
                $befores['pdrb-' . $region->id] = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $period_before->id)->where('quarter', 'Y')->where('region_id', $region->id)->orderBy('subsector_id')->get();
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
        $daftar_1 = Pdrb::select('region_id', 'period_id', 'quarter')->where('quarter', 'Y')->groupBy('region_id', 'period_id', 'quarter')->get();
        foreach ($daftar_1 as $item) {
            $item->number = $number;
            $number++;
        }
        $number = 1;
        $daftar_2 = Pdrb::select('region_id', 'period_id', 'quarter')->whereNotIn('region_id', ['1'])->whereNotIn('quarter', ['Y'])->groupBy('region_id', 'period_id', 'quarter')->get();
        foreach ($daftar_2 as $item) {
            $item->number = $number;
            $number++;
        }
        return view('rekonsiliasi.tabel-pokok', [
            'daftar_1' => $daftar_1,
            'daftar_2' => $daftar_2,
        ]);
    }

    public function detailPokok(Request $request, $period_id, $region_id, $quarter)
    {
        $subsectors = Subsector::all();
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
            return view('rekonsiliasi.detail-pokok', [
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
            return view('rekonsiliasi.detail-pokok-quarter', [
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

    public function konserda(Request $request)
    {

        $filter = [
            'type' => '',
            'year' => '',
            'quarter' => '',
            'period_id' => '',
            'region_id' => '',
            'price_base' => '',
        ];

        if ($request->filter) {
            $filter = [
                'type' => $request->filter['type'],
                'year' => $request->filter['year'],
                'quarter' => $request->filter['quarter'],
                'period_id' => $request->filter['period_id'],
                'region_id' => $request->filter['region_id'],
                'price_base' => $request->filter['price_base'],
            ];
            $years = Period::where('type', $filter['type'])->groupBy('year')->get('year');
            $quarters = Period::where('year', $filter['year'])->groupBy('quarter')->get('quarter');
            $periods = Period::where('type', $filter['type'])->where('year', $filter['year'])->where('quarter', $filter['quarter'])->get();
        }

        $regions = Region::all();
        $cat = Category::pluck('code')->toArray();
        $catString = implode(", ", $cat);
        $subsectors = Subsector::all();
        return view('rekonsiliasi.konserda', [
            'regions' => $regions,
            'subsectors' => $subsectors,
            'cat' => $catString,
            'years' => isset($years) ? $years : NULL,
            'quarters'  => isset($quarters) ? $quarters : NULL,
            'periods' => isset($periods) ? $periods : NULL,
            'filter' => isset($filter) ? $filter : ['type' => ''],
        ]);
    }

    public function rekonsiliasi(Request $request)
    {
        $cat = Category::pluck('code')->toArray();
        $catString = implode(", ", $cat);
        $regions = Region::all();
        $categories = Category::all();
        $sectors = Sector::all();
        $subsectors = Subsector::all();
        return view('rekonsiliasi.view', [
            'cat' => $catString,
            'regions' => $regions,
            'categories' => $categories,
            'sectors' => $sectors,
            'subsectors' => $subsectors,
        ]);
    }

    public function getFullData(Request $request)
    {
        $filter = $request->filter;
        $subsectors = Subsector::all();
        $dataSeries['1'] = Pdrb::where('period_id', $filter['period_id'])->where('region_id', $filter['region_id'])->where('quarter', 1)->orderBy('subsector_id')->get();
        $dataSeries['2'] = Pdrb::where('period_id', $filter['period_id'])->where('region_id', $filter['region_id'])->where('quarter', 2)->orderBy('subsector_id')->get();
        $dataSeries['3'] = Pdrb::where('period_id', $filter['period_id'])->where('region_id', $filter['region_id'])->where('quarter', 3)->orderBy('subsector_id')->get();
        $dataSeries['4'] = Pdrb::where('period_id', $filter['period_id'])->where('region_id', $filter['region_id'])->where('quarter', 4)->orderBy('subsector_id')->get();
        $dataSeries['Y'] = Pdrb::where('period_id', $filter['period_id'])->where('region_id', $filter['region_id'])->where('quarter', 'Y')->orderBy('subsector_id')->get();

        $fullData = [];

        foreach ($dataSeries as $key => $data) {
            if (sizeof($data) == 0) {
                $inputData = [];
                $timestamp = date('Y-m-d H:i:s');
                foreach ($subsectors as $subsector) {
                    $singleData = [
                        'subsector_id' => $subsector->id,
                        'type' => $filter['type'],
                        'year' => $filter['year'],
                        'quarter' => $key,
                        'period_id' => $filter['period_id'],
                        'region_id' => $filter['region_id'],
                        'created_at' => $timestamp,
                        'updated_at' => $timestamp,
                    ];
                    array_push($inputData, $singleData);
                }
                Pdrb::insert($inputData);
                $fullData[$key] = Pdrb::where('period_id', $filter['period_id'])->where('region_id', $filter['region_id'])->where('quarter', $key)->orderBy('subsector_id')->get();
            } else {
                $fullData[$key] = $data;
            }
        }

        return response()->json($fullData);
    }

    public function getSingleData(Request $request)
    {
        $filter = $request->filter;
        $subsectors = Subsector::where('type', $filter['type'])->orderBy('id')->get();
        $data = Pdrb::where('period_id', $filter['period_id'])->where('region_id', $filter['region_id'])->orderBy('subsector_id')->get();
        //    return response()->json($data);
        if (sizeof($data) != 0) {
            return response()->json($data);
        } else {
            $inputData = [];
            $timestamp = date('Y-m-d H:i:s');
            foreach ($subsectors as $subsector) {
                $singleData = [
                    'subsector_id' => $subsector->id,
                    'type' => $filter['type'],
                    'year' => $filter['year'],
                    'quarter' => $filter['quarter'],
                    'period_id' => $filter['period_id'],
                    'region_id' => $filter['region_id'],
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
                array_push($inputData, $singleData);
            }
            Pdrb::insert($inputData);
            // Pdrb::create($inputData);
            $data = Pdrb::where('period_id', $filter['period_id'])->where('region_id', $filter['region_id'])->orderBy('subsector_id')->get();
            return response()->json($data);
        }
    }

    public function saveSingleData(Request $request)
    {
        $filter = $request->filter;
        $input = $request->input;
        $subsectors = Subsector::where('type', $filter['type'])->orderBy('id')->get();
        $data = [];

        foreach ($subsectors as $subsector) {
            $inputData = (float) str_replace(',', '.', str_replace('.', '', str_replace('Rp. ', '', $input['value_' . $subsector->id])));
            Pdrb::where('id', $input['id_' . $subsector->id])->update([$filter['price_base'] => $inputData]);
        }
        return response()->json($request);
    }

    public function saveFullData(Request $request)
    {
        $filter = $request->filter;
        $input = $request->input;
        $subsectors = Subsector::where('type', $filter['type'])->orderBy('id')->get();
        $data = [];
        $dataSeries = [
            '1',
            '2',
            '3',
            '4',
        ];

        foreach ($dataSeries as $key) {
            foreach ($subsectors as $subsector) {
                $inputData = (float) str_replace(',', '.', str_replace('.', '', str_replace('Rp. ', '', $input['value_' . $key . '_' . $subsector->id])));
                // return response()->json($inputData);

                Pdrb::where('id', $input['id_' . $key . '_' . $subsector->id])->update([$filter['price_base'] => $inputData]);
                // $inputData['id'] = $input['id_'.$x];
                array_push($data, $inputData);
            }
        }

        return response()->json($data);
    }
}
