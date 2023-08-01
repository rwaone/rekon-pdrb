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
        $quarter = [ 1, 2, 3, 4];
        $regions = Region::getMyRegion();
        // $this_year = date('Y');
        $year_active = Period::where('status', 'Aktif')->get('year');
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
            'year_active' => $year_active,
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

        for ($index = 1; $index <= $copy['quarterCopy']; $index++) {
            $data[$index] = Pdrb::where('period_id', $copy['periodCopy'])->where('region_id', $filter['region_id'])->where('quarter', $index)->orderBy('subsector_id')->get();
        }
        return response()->json($data);
    }

    public function getFullData(Request $request)
    {
        $filter = $request->filter;
        $subsectors = Subsector::where('type', $filter['type'])->get();
        $previous_periodId = Period::where('type', $filter['type'])->where('year', $filter['year'] - 1)->where('quarter', 4)->where('status', 'Final')->first()->id;
        $current_data = [];
        $previous_data = [];

        for ($index = 1; $index <= 4; $index++) {
            $previous_data[$index] = Pdrb::where('period_id', $previous_periodId)->where('region_id', $filter['region_id'])->where('quarter', $index)->orderBy('subsector_id')->get();
            if ($index <= $filter['quarter']) {
                $query_data[$index] = Pdrb::where('period_id', $filter['period_id'])->where('region_id', $filter['region_id'])->where('quarter', $index)->orderBy('subsector_id')->get();
                if (sizeof($query_data[$index]) == 0) {
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
                    $current_data[$index] = Pdrb::where('period_id', $filter['period_id'])->where('region_id', $filter['region_id'])->where('quarter', $index)->orderBy('subsector_id')->get();
                } else {
                    $current_data[$index] = $query_data[$index];
                }
            }
        }

        return response()->json(['current_data' => $current_data, 'previous_data' => $previous_data]);
    }

    public function saveFullData(Request $request)
    {
        $filter = $request->filter;
        $adhb = $request->adhb;
        $adhk = $request->adhk;
        $subsectors = Subsector::where('type', $filter['type'])->orderBy('id')->get();
        $data = [];

        for ($index = 1; $index <= $filter['quarter']; $index++) {
            foreach ($subsectors as $subsector) {
                $adhb_data = (float) str_replace(',', '.', str_replace('.', '', str_replace('Rp. ', '', $adhb['adhb_value_' . $index . '_' . $subsector->id])));
                $adhk_data = (float) str_replace(',', '.', str_replace('.', '', str_replace('Rp. ', '', $adhk['adhk_value_' . $index . '_' . $subsector->id])));

                Pdrb::where('id', $adhb['id_' . $index . '_' . $subsector->id])->update(['adhb' => $adhb_data, 'adhk' => $adhk_data]);

                array_push($data, ['adhb' => $adhb_data, 'adhk' => $adhk_data]);
            }
        }

        return response()->json($data);
    }
}
