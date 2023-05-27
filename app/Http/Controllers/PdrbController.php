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

    public function getKonserda(Request $request, $period_id)
    {
        $pdrb = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $period_id)->orderBy('subsector_id')->get();
        return response()->json($pdrb);
    }

    public function daftarPokok()
    {
        $daftar = Pdrb::select('region_id', 'period_id')->groupBy('region_id', 'period_id')->get();
        $json_daftar = json_encode($daftar);
        return view('rekonsiliasi.tabel-pokok', [
            'daftar' => $daftar,
            'json' => $json_daftar,
        ]);
    }

    public function detailPokok(Request $request, $period_id)
    {
        $subsectors = Subsector::all();
        $period = Period::where('id', $period_id)->first();
        if ($period->quarter === 'Y') {
            $year_ = $period->year;
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
            $pdrb_1 = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $periods[4])->orderBy('subsector_id')->get();
            $pdrb_2 = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $periods[3])->orderBy('subsector_id')->get();
            $pdrb_3 = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $periods[2])->orderBy('subsector_id')->get();
            $pdrb_4 = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $periods[1])->orderBy('subsector_id')->get();
            $pdrb = Pdrb::select('subsector_id', 'adhk', 'adhb')->where('period_id', $period_id)->orderBy('subsector_id')->get();

            $adhks = [
                'pdrb-1' => $pdrb_1,
                'pdrb-2' => $pdrb_2,
                'pdrb-3' => $pdrb_3,
                'pdrb-4' => $pdrb_4,
                'pdrb-5' => $pdrb,
            ];
            $adhk = [];
            $adhb = [];
            foreach ($adhks as $key => $item) {
                $adhk[$key] = $item->pluck('adhk')->toArray();
                $adhb[$key] = $item->pluck('adhb')->toArray();
            }
        }
        $adhk = json_encode($adhk);
        $adhb = json_encode($adhb);
        $cat = Category::pluck('code')->toArray();
        $catString = implode(", ", $cat);
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

        $pdrb = Pdrb::all();
        $year = Period::select('year')->distinct()->get();
        $cat = Category::pluck('code')->toArray();
        $catString = implode(", ", $cat);
        $subsectors = Subsector::all();
        return view('rekonsiliasi.konserda', [
            'pdrb' => $pdrb,
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
                'type' => $request->type,
                'year' => $request->year,
                'quarter' => $request->quarter,
                'period_id' => $request->period_id,
                'region_id' => $request->region_id,
                'price_base' => $request->price_base,
            ];
            $years = Period::where('type', $filter['type'])->groupBy('year')->get('year');
            $quarters = Period::where('year', $filter['year'])->groupBy('quarter')->get('quarter');
            $periods = Period::where('type', $filter['type'])->where('year', $filter['year'])->where('quarter', $filter['quarter'])->get();
            $data = Pdrb::where('period_id', $filter['period_id'])->where('region_id', $filter['region_id'])->get();
        } else {

            $filter = [
                'type' => '',
                'year' => '',
                'quarter' => '',
                'period_id' => '',
                'region_id' => '',
                'price_base' => '',
            ];
            $years = NULL;
            $quarters = NULL;
            $periods = NULL;
        }

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
            'years' => $years,
            'quarters'  => $quarters,
            'periods' => $periods,
            'filter' => $filter,
        ]);
    }

    public function getFullData(Request $request)
    {
        //
    }

    public function getSingleData(Request $request)
    {
        $filter = $request->filter;
        $subsectors = Subsector::all();
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
            $data = Pdrb::where('period_id', $filter['period_id'])->where('region_id', $filter['region_id'])->orderBy('subsector_id')->get();
            return response()->json($data);
        }
    }

    public function saveSingleData(Request $request)
    {
        $filter = $request->filter;
        $input = $request->input;
        $data = [];

        for ($x = 1; $x <= 55; $x++) {
            $inputData = (float) str_replace(',','.',str_replace('.','',str_replace('Rp. ','',$input['value_' . $x])));
            // return response()->json($inputData);
            Pdrb::where('id', $input['id_'.$x])->update([$filter['price_base'] => $inputData]);
            // $inputData['id'] = $input['id_'.$x];
            // array_push($data, $inputData);
        }
        return response()->json();
    }

    public function saveFullData(Request $request)
    {
        $filter = $request->filter;
        $input = $request->input;
        return response()->json($input);
    }
}
