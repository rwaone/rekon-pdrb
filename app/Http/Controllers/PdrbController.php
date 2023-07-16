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
        // $this_year = date('Y');
        $this_year = 2017;
        $daftar_quarters = Period::select('id', 'year', 'type', 'description')->where('year', $this_year)->whereIn('status', ['Selesai', 'Aktif'])->whereIn('quarter', $quarter)->get();
        $data_regions_quarters = [];
        foreach ($regions as $index => $item) {
            $datas = [];
            foreach ($daftar_quarters as $quarter) {
                $data = Pdrb::select('adhk', 'adhb')->where('region_id', $item->id)->where('period_id', $quarter->id)->first('adhk');
                if (!$data) {
                    $data = '0';
                } else {
                    $data = '1';
                }
                array_push($datas, $data);
            }
            $data_regions_quarters[$index] = $datas;
        }
        $daftar_years = Period::select('id', 'year', 'type', 'description')->where('year', $this_year)->where('quarter', 'Y')->whereIn('status', ['Selesai', 'Aktif'])->get();
        $data_regions_years = [];
        foreach ($regions as $index => $item) {
            $datas = [];
            foreach ($daftar_years as $year) {
                $data = Pdrb::select('adhk', 'adhb')->where('region_id', $item->id)->where('period_id', $year)->first('adhk');
                if (!$data) {
                    $data = '0';
                } else {
                    $data = '1';
                }
                array_push($datas, $data);
            }
            $data_regions_years[$index] = $datas;
        }

        return view('rekonsiliasi.monitoring', [
            'daftar_quarters' => $daftar_quarters,
            'daftar_years' => $daftar_years,
            'regions' => $regions,
            'data_regions_quarters' => $data_regions_quarters,
            'data_regions_years' => $data_regions_years
        ]);
    }

    public function copyData(Request $request)
    {
        $filter = $request->filter;
        $copy = $request->copy;
        $fullData = [];
    
        for ($index = 1; $index <= $copy['quarterCopy']; $index++) {
            $data[$index] = Pdrb::where('period_id', $copy['periodCopy'])->where('region_id', $filter['region_id'])->where('quarter', $index)->orderBy('subsector_id')->get();
        }
        return response()->json($data);
    }

    public function getFullData(Request $request)
    {
        $filter = $request->filter;
        $subsectors = Subsector::where('type', $filter['type'])->get();
        $fullData = [];
    
        for ($index = 1; $index <= $filter['quarter']; $index++) {
            $data[$index] = Pdrb::where('period_id', $filter['period_id'])->where('region_id', $filter['region_id'])->where('quarter', $index)->orderBy('subsector_id')->get();
            if (sizeof($data[$index]) == 0) {
                $inputData = [];
                $timestamp = date('Y-m-d H:i:s');
                foreach ($subsectors as $subsector) {
                    $singleData = [
                        'subsector_id' => $subsector->id,
                        'type' => $filter['type'],
                        'year' => $filter['year'],
                        'quarter' => $index,
                        'period_id' => $filter['period_id'],
                        'region_id' => $filter['region_id'],
                        'created_at' => $timestamp,
                        'updated_at' => $timestamp,
                    ];
                    array_push($inputData, $singleData);
                }

                Pdrb::insert($inputData);
                $fullData[$index] = Pdrb::where('period_id', $filter['period_id'])->where('region_id', $filter['region_id'])->where('quarter', $index)->orderBy('subsector_id')->get();
            } else {
                $fullData[$index] = $data[$index];
            }
            $fullData['Y'] = PDRB::where('region_id', $filter['region_id'])->where('quarter', 'Y')->orderBy('subsector_id')->get();
        }
        return response()->json($fullData);
    }

    public function getSingleData(Request $request)
    {
        $filter = $request->filter;
        $subsectors = Subsector::where('type', $filter['type'])->orderBy('id')->get();
        $data = Pdrb::where('period_id', $filter['period_id'])->where('region_id', $filter['region_id'])->orderBy('subsector_id')->get();
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

        for ($index = 1; $index <= $filter['quarter']; $index++) {
            foreach ($subsectors as $subsector) {
                $inputData = (float) str_replace(',', '.', str_replace('.', '', str_replace('Rp. ', '', $input['value_' . $index . '_' . $subsector->id])));
                
                Pdrb::where('id', $input['id_' . $index . '_' . $subsector->id])->update([$filter['price_base'] => $inputData]);
               
                array_push($data, $inputData);
            }
        }

        return response()->json('Data berhasil disimpan');
    }
}
