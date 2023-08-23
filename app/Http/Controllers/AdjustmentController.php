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
        $segment = \Request::segment(1);
        $type = ( $segment == 'pengeluaran') ? 'Pengeluaran' : 'Lapangan Usaha';
        $subsectors = Subsector::where('type', $type)->get();
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

        $previous_period = Period::where('type', $filter['type'])->where('year', $filter['year'] - 1)->where('quarter', 4)->where('status', 'Final')->first();
        $notification = [];

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

                    if (sizeof($adjustment) == 0) {
                        $adjustment = [
                            'pdrb_id' => $query[0]['id'],
                            'adhb' => '0',
                            'adhk' => '0',
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ];

                        Adjustment::insert($adjustment);

                        $data['current'][$region->id][$index]['adjust_adhb'] = $adjustment['adhb'];
                        $data['current'][$region->id][$index]['adjust_adhk'] = $adjustment['adhk'];
                    } else {
                        $data['current'][$region->id][$index]['adjust_adhb'] = $adjustment[0]['adhb'];
                        $data['current'][$region->id][$index]['adjust_adhk'] = $adjustment[0]['adhk'];
                    }
                }
                
                if (isset($previous_period)) {
                    $query = PDRB::select('id', 'adhb', 'adhk')
                        ->where('region_id', $region->id)
                        ->where('period_id', $previous_period->id)
                        ->where('quarter', $index)
                        ->where('subsector_id', $filter['subsector'])
                        ->get()->toArray();
                    $data['previous'][$region->id][$index] = $query[0];

                } else {                    
                    $dummy = [
                        'id' => 0,
                        'adhb' => 0,
                        'adhk' => 0,
                    ];
                    $data['previous'][$region->id][$index] = $dummy;
                }
            }
        }

        array_push($notification, [
            'type' => 'success',
            'title' => 'Berhasil',
            'text' => 'Data berhasil diunduh'
        ]);
        
        if (!isset($previous_period)){
            $message = [
                'type' => 'warning',
                'title' => 'Warning',
                'text' => 'Data periode sebelumnya tidak ada / belum final, summary tidak dapat ditampilkan'
            ];
            array_push($notification, $message);
        }

        return response()->json(['data' => $data, 'messages' => $notification]);
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
        $adjustment = json_decode($request->adjustment);
        foreach($adjustment as $data){
            Adjustment::where('pdrb_id', $data->pdrb_id)->update(['adhb' => $data->adhb, 'adhk' => $data->adhk]);
        }
        return response()->json('berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Adjustment $adjustment)
    {
        //
    }
}
