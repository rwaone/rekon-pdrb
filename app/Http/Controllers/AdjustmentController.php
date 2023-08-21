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
            for ($index = 1; $index <= 4; $index++) {
                if ($index <= $filter['quarter']) {
                    $query = Pdrb::select('id', 'adhb', 'adhk')
                        ->where('region_id', $region->id)
                        ->where('period_id', $filter['period_id'])
                        ->where('quarter', $index)
                        ->where('subsector_id', $filter['subsector'])
                        ->get()->toArray();
                    $data['current'][$region->id][$index] = $query[0];
                    $adjustment = Adjustment::select('adhb', 'adhk')
                        ->where('pdrb_id', $query[0]['id'])
                        ->get()->toArray();
                    if(sizeof($adjustment) == 0){
                        $adjustment = [
                            'pdrb_id' => $query[0]['id'],
                            'adhb' => '0',
                            'adhk' => '0',
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ];
                        $data['current'][$region->id][$index]['adjust_adhb'] = $adjustment['adhb'];
                        $data['current'][$region->id][$index]['adjust_adhk'] = $adjustment['adhk'];
                    } else {
                        $data['current'][$region->id][$index]['adjust_adhb'] = $adjustment['adhb'];
                        $data['current'][$region->id][$index]['adjust_adhk'] = $adjustment['adhk'];  
                    }
                }

                $query = PDRB::select('id', 'adhb', 'adhk')
                    ->where('region_id', $region->id)
                    ->where('period_id', $previous_period)
                    ->where('quarter', $index)
                    ->where('subsector_id', $filter['subsector'])
                    ->get()->toArray();
                $data['previous'][$region->id][$index] = $query[0];
            }
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
    public function update(Request $request)
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
