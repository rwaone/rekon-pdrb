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
use Illuminate\Support\Facades\Auth;

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

    public function monitoring()
    {
        $quarter = ['F', 1, 2, 3, 4];
        $regions = Region::getMyRegion();
        $daftar_quarters = Period::select('id', 'year', 'type', 'description')->where('year', 2017)->whereIn('quarter', $quarter)->where('status', 'Aktif')->get();
        $data_regions = [];
        foreach ($regions as $index => $item) {
            $datas = [];
            foreach ($daftar_quarters as $quarter) {
                $data = Pdrb::select('adhk', 'adhb')->where('region_id', $item->id)->where('period_id', $quarter->id)->first('adhk');
                if (!$data){
                    $data = '0';
                } else {
                    $data = '1';
                }
                array_push($datas, $data);
            }
            $data_regions[$index] = $datas;
        }
        $daftar_years = Period::select('year', 'type')->where('quarter', 'Y')->where('status', 'Aktif')->get();
        return view('rekonsiliasi.monitoring', [
            'daftar_quarters' => $daftar_quarters,
            'daftar_years' => $daftar_years,
            'regions' => $regions,
            'data_regions' => $data_regions
        ]);
    }

    public function getFullData(Request $request)
    {
        $filter = $request->filter;
        $subsectors = Subsector::where('type', $filter['type'])->get();
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
