<?php

namespace App\Http\Controllers;

use App\Models\Fenomena;
use App\Http\Requests\StorefenomenaRequest;
use App\Http\Requests\UpdatefenomenaRequest;
use App\Models\Category;
use App\Models\Region;
use App\Models\Sector;
use App\Models\Subsector;
use Illuminate\Http\Request;

class FenomenaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regions = Region::all();
        $category = Category::all();
        $sector = Sector::all();
        $subsector = Subsector::all();

        return view('fenomena.view', [
            'regions' => $regions,
            'category' => $category,
            'sector' => $sector,
            'subsector' => $subsector,
        ]);
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
     * @param  \App\Http\Requests\StorefenomenaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorefenomenaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\fenomena  $fenomena
     * @return \Illuminate\Http\Response
     */
    public function show(fenomena $fenomena)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\fenomena  $fenomena
     * @return \Illuminate\Http\Response
     */
    public function edit(fenomena $fenomena)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatefenomenaRequest  $request
     * @param  \App\Models\fenomena  $fenomena
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatefenomenaRequest $request, fenomena $fenomena)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\fenomena  $fenomena
     * @return \Illuminate\Http\Response
     */
    public function destroy(fenomena $fenomena)
    {
        //
    }

    public function viewAll()
    {
        $filter = [
            'type' => '',
            'year' => '',
            'quarter' => '',
            'price_base' => '',
        ];

        $regions = Region::where('id', '>', 1)->get();
        $cat = Category::pluck('code')->toArray();
        $catString = implode(", ", $cat);
        $subsectors = Subsector::all();
        return view('fenomena.view-all', [
            'regions' => $regions,
            'subsectors' => $subsectors,
            'cat' => $catString,
            'years' => isset($years) ? $years : NULL,
            'quarters'  => isset($quarters) ? $quarters : NULL,
            'filter' => isset($filter) ? $filter : ['type' => ''],
        ]);
    }

    public function getData(Request $request)
    {
        $types = $request->query('type');
        $years = $request->query('year');
        $quarters = $request->query('quarter');

        $regions = Region::select('id')->where('id', '>', 1)->get();
        $datas = [];
        foreach ($regions as $region) {
            $datas['fenomena-' . $region->id] = Fenomena::where('region_id', $region->id)
                ->where('type', $types)
                ->where('year', $years)
                ->where('quarter', $quarters)->get();
        }
        $parameter = [
            'type' => $types,
            'years' => $years,
            'quarter' => $quarters
        ];
        return response()->json($datas);
    }

    public function getFenomena(Request $request)
    {
        $filter = $request->filter;
        $subsectors = Subsector::where('type', $filter['type'])->get();
        $fenomena_data = Fenomena::where('type', $filter['type'])->where('year', $filter['year'])->where('quarter', $filter['quarter'])->where('region_id', $filter['region_id'])->orderBy('id')->get();
        if (sizeof($fenomena_data) != 0) {
            return response()->json($fenomena_data);
        } else {
            $inputData = [];
            $timestamp = date('Y-m-d H:i:s');
            foreach ($subsectors as $subsector) {
                if (($subsector->code != null && $subsector->code == 'a' && $subsector->sector->code == '1') || ($subsector->code == null && $subsector->sector->code == '1')) {
                    $singleData['type'] = $filter['type'];
                    $singleData['year'] = $filter['year'];
                    $singleData['quarter'] = $filter['quarter'];
                    $singleData['region_id'] = $filter['region_id'];
                    $singleData['category_id'] = $subsector->sector->category->id;
                    $singleData['sector_id'] = NULL;
                    $singleData['subsector_id'] = NULL;
                    $singleData['description'] = '-';
                    $singleData['created_at'] = $timestamp;
                    $singleData['updated_at'] = $timestamp;
                    array_push($inputData, $singleData);
                }

                if ($subsector->code != null && $subsector->code == 'a') {
                    $singleData['type'] = $filter['type'];
                    $singleData['year'] = $filter['year'];
                    $singleData['quarter'] = $filter['quarter'];
                    $singleData['region_id'] = $filter['region_id'];
                    $singleData['category_id'] = $subsector->sector->category->id;
                    $singleData['sector_id'] = $subsector->sector->id;
                    $singleData['subsector_id'] = NULL;
                    $singleData['description'] = '-';
                    $singleData['created_at'] = $timestamp;
                    $singleData['updated_at'] = $timestamp;
                    array_push($inputData, $singleData);
                }

                $singleData['type'] = $filter['type'];
                $singleData['year'] = $filter['year'];
                $singleData['quarter'] = $filter['quarter'];
                $singleData['region_id'] = $filter['region_id'];
                $singleData['category_id'] = $subsector->sector->category->id;
                $singleData['sector_id'] = $subsector->sector->id;
                $singleData['subsector_id'] = $subsector->id;
                $singleData['description'] = '-';
                $singleData['created_at'] = $timestamp;
                $singleData['updated_at'] = $timestamp;
                array_push($inputData, $singleData);
            }
            Fenomena::insert($inputData);

            $fenomena_data = Fenomena::where('type', $filter['type'])->where('year', $filter['year'])->where('quarter', $filter['quarter'])->where('region_id', $filter['region_id'])->orderBy('id')->get();
            return response()->json($fenomena_data);
        }
    }

    public function saveFenomena(Request $request)
    {
        $filter = $request->filter;
        $fenomena = $request->fenomena;
        $subsectors = Subsector::where('type', $filter['type'])->orderBy('id')->get();

        foreach ($subsectors as $subsector) {
            if (($subsector->code != null && $subsector->code == 'a' && $subsector->sector->code == '1') || ($subsector->code == null && $subsector->sector->code == '1')) {
                $id = $fenomena['id_' . $subsector->sector->category->id . '_NULL_NULL'];
                $value = $fenomena['value_' . $subsector->sector->category->id . '_NULL_NULL'];
                Fenomena::where('id', $id)->update(['description' => $value]);
            }

            if ($subsector->code != null && $subsector->code == 'a') {
                $id = $fenomena['id_' . $subsector->sector->category->id . '_' . $subsector->sector->id . '_NULL'];
                $value = $fenomena['value_' . $subsector->sector->category->id . '_' . $subsector->sector->id . '_NULL'];
                Fenomena::where('id', $id)->update(['description' => $value]);
            }

            $id = $fenomena['id_' . $subsector->sector->category->id . '_' . $subsector->sector->id . '_' . $subsector->id];
            $value = $fenomena['value_' . $subsector->sector->category->id . '_' . $subsector->sector->id . '_' . $subsector->id];
            Fenomena::where('id', $id)->update(['description' => $value]);
        }

        return response()->json();
    }

    public function monitoring()
    {
        $filter = [
            'type' => '',
            'year' => '',
            'quarter' => '',
        ];
        $regions = Region::getMyRegion();
        return view('fenomena.monitoring', [
            'regions' => $regions,
            'years' => isset($years) ? $years : NULL,
            'filter' => isset($filter) ? $filter : ['type' => ''],
        ]);
    }

    public function getMonitoring()
    {
        $regions = Region::getMyRegion();
        $year_active = Fenomena::distinct()->get('year');
        $monitoring_quarter = [];
        foreach ($year_active as $year) {
            $quarter_active = Fenomena::distinct()->get('quarter');
            foreach ($quarter_active as $quarters) {
                foreach ($regions as $region) {
                    $data = Fenomena::where('region_id', $region->id)
                        ->where('quarter', $quarters->quarter)
                        ->where('year', $year->year)->pluck('description');
                    if ($data->contains(null)) {
                        $data = 0;
                    } else {
                        $data = 1;
                    }
                    $monitoring_quarter[$year->year][$quarters->quarter][$region->name]['description'] = $data;
                }
            }
        }

        return view('fenomena.monitoring', [
            'monitoring_quarter' => $monitoring_quarter
        ]);
    }
}
