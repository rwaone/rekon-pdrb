<?php

namespace App\Http\Controllers;

use App\Models\Pdrb;
use App\Models\Period;
use App\Models\Region;
use App\Models\Subsector;
use App\Models\Adjustment;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAdjustmentRequest;
use App\Http\Requests\UpdateAdjustmentRequest;

class AdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $regions = Region::getMyRegion();
        $type = 'Lapangan Usaha';
        $subsectors = Subsector::where('type', 'Lapangan Usaha')->get();
        return view('adjustment.view', [
            'regions' => $regions,
            'subsectors' => $subsectors,
            'type' => $type,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdjustmentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $filter = $request->filter;
        $regions = Region::all();
        $previous_period = Period::where('type', $filter['type'])->where('year', $filter['year'] - 1)->where('quarter', 4)->where('status', 'Final')->first()->id;
        foreach ($regions as $region) {
            $data['current'][$region->id] = Pdrb::select('id', 'adhb', 'adhk')
                ->where('region_id', $region->id)
                ->where('period_id', $filter['period_id'])
                ->where('subsector_id', $filter['subsector'])
                ->get();

            $data['previous'][$region->id] = PDRB::select('id', 'adhb', 'adhk')
                ->where('region_id', $region->id)
                ->where('period_id', $previous_period)
                ->where('subsector_id', $filter['subsector'])
                ->get();
        }

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Adjustment $adjustment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdjustmentRequest $request, Adjustment $adjustment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Adjustment $adjustment)
    {
        //
    }
}
