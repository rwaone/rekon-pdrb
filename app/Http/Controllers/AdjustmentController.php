<?php

namespace App\Http\Controllers;

use App\Models\Subsector;
use App\Models\Region;
use App\Models\Adjustment;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAdjustmentRequest;
use App\Http\Requests\UpdateAdjustmentRequest;
use App\Models\Pdrb;

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
        $data = [];
        foreach ($regions as $region) {
            $data[$region->code] = Pdrb::select('id', 'adhb', 'adhk')
                                        ->where('region_id', $region->id)
                                        ->where('period_id', $filter['period_id'])
                                        ->where('subsector_id', $filter['subsector'])
                                        ->get()->toArray();
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
