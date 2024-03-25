<?php

namespace App\Http\Controllers;

use App\Models\Pdrb;
use App\Models\Period;
use App\Models\Region;
use App\Models\Dataset;
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
        $regions = Region::all();
        $segment = \Request::segment(1);
        $type = ($segment == 'pengeluaran') ? 'Pengeluaran' : 'Lapangan Usaha';
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
        $filter = (array) json_decode($request->filter);
        $sector = explode("-", $filter['subsector']);
        // dd($sector);
        $regions = Region::all();

        $current_period = Period::where('id', $filter['period_id'])->first();
        // return response()->json($current_period);
        if ($current_period->status == 'Aktif') {
            $previous_period = Period::where('type', $filter['type'])->where('year', $filter['year'] - 1)->where('quarter', 4)->latest('id')->first();
        } else {
            $previous_period = Period::where('type', $filter['type'])->where('year', $filter['year'] - 1)->where('quarter', 4)->where('status', '<>', 'Aktif')->latest('id')->first();
        }
        // dd($current_period);
        $notification = [];
        // dd(intval($filter['subsector']));
        if (intval($filter['subsector']) > 0) {
            foreach ($regions as $region) {
                $current_dataset = Dataset::where('period_id', $filter['period_id'])->where('region_id', $region->id)->first();
                $previous_dataset = Dataset::where('period_id', $previous_period->id)->where('region_id', $region->id)->first();
                // dd($current_dataset);
                // dd($previous_dataset);
                if (isset($current_dataset)) {
                    for ($index = 1; $index <= 4; $index++) {
                        if ($index <= $filter['quarter']) {
                            $query = Pdrb::select('id', 'adhb', 'adhk')
                                ->where('dataset_id', $current_dataset->id)
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
                    }
                } else {

                    $message = [
                        'type' => 'warning',
                        'title' => 'Warning',
                        'text' => 'Data ' . $region->name . ' periode ini tidak ditemukan'
                    ];
                    array_push($notification, $message);
                }

                if (isset($previous_dataset)) {
                    for ($index = 1; $index <= 4; $index++) {
                        $query = PDRB::select('id', 'adhb', 'adhk')
                            ->where('dataset_id', $previous_dataset->id)
                            ->where('quarter', $index)
                            ->where('subsector_id', $filter['subsector'])
                            ->get()->toArray();
                        $data['previous'][$region->id][$index] = $query[0];

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

                            $data['previous'][$region->id][$index]['adjust_adhb'] = $adjustment['adhb'];
                            $data['previous'][$region->id][$index]['adjust_adhk'] = $adjustment['adhk'];
                        } else {
                            $data['previous'][$region->id][$index]['adjust_adhb'] = $adjustment[0]['adhb'];
                            $data['previous'][$region->id][$index]['adjust_adhk'] = $adjustment[0]['adhk'];
                        }
                    }
                } else {
                    $message = [
                        'type' => 'warning',
                        'title' => 'Warning',
                        'text' => 'Data ' . $region->name . ' periode sebelumnya tidak ditemukan'
                    ];
                    array_push($notification, $message);
                }
            }
        } else {
            foreach ($regions as $region) {
                $current_dataset = Dataset::where('period_id', $filter['period_id'])->where('region_id', $region->id)->first();
                $previous_dataset = Dataset::where('period_id', $previous_period->id)->where('region_id', $region->id)->first();

                if (isset($current_dataset)) {
                    for ($index = 1; $index <= 4; $index++) {
                        if ($index <= $filter['quarter']) {
                            if (sizeof($sector) > 1) {
                                # code...
                                if ($sector[0] == 'sector') {
                                    # code...
                                    # if sector = net export-import do this! uhuy
                                    if ($sector[1] == '54') {
                                        # code...
                                        $query = Pdrb::selectRaw('subsector_id as identifier, pdrbs.adhb AS adhb, pdrbs.adhk AS adhk, adjustments.adhb AS adjust_adhb, adjustments.adhk AS adjust_adhk')
                                            ->leftJoin('adjustments', 'pdrbs.id', '=', 'adjustments.pdrb_id')
                                            ->leftJoin('subsectors as s', 's.id', '=', 'pdrbs.subsector_id')
                                            ->where('pdrbs.dataset_id', $current_dataset->id)
                                            ->where('pdrbs.quarter', $index)
                                            ->where('s.sector_id', $sector[1])
                                            ->get()->toArray();
                                        // dd($query[0]);
                                        $exports = [];
                                        $imports = [];
                                        foreach ($query as $item) {
                                            if ($item['identifier'] == "68") {
                                                $exports = $item;
                                            } elseif ($item['identifier'] == "69") {
                                                $imports = $item;
                                            }
                                        }
                                        $query[0]['adhb'] = (string)($exports['adhb'] - $imports['adhb']);
                                        $query[0]['adhk'] = (string)($exports['adhk'] - $imports['adhk']);
                                        $query[0]['adjust_adhb'] = (string)($exports['adjust_adhb'] - $imports['adjust_adhb']);
                                        $query[0]['adjust_adhk'] = (string)($exports['adjust_adhb'] - $imports['adjust_adhb']);
                                    } else {
                                        $query = Pdrb::selectRaw('SUM(pdrbs.adhb) AS adhb, SUM(pdrbs.adhk) AS adhk, SUM(adjustments.adhb) AS adjust_adhb, SUM(adjustments.adhk) AS adjust_adhk')
                                            ->leftJoin('adjustments', 'pdrbs.id', '=', 'adjustments.pdrb_id')
                                            ->leftJoin('subsectors as s', 's.id', '=', 'pdrbs.subsector_id')
                                            ->where('pdrbs.dataset_id', $current_dataset->id)
                                            ->where('pdrbs.quarter', $index)
                                            ->where('s.sector_id', $sector[1])
                                            ->get()->toArray();
                                    }
                                } else {
                                    $query = Pdrb::selectRaw('SUM(pdrbs.adhb) AS adhb, SUM(pdrbs.adhk) AS adhk, SUM(adjustments.adhb) AS adjust_adhb, SUM(adjustments.adhk) AS adjust_adhk')
                                        ->leftJoin('adjustments', 'pdrbs.id', '=', 'adjustments.pdrb_id')
                                        ->leftJoin('subsectors as s', 's.id', '=', 'pdrbs.subsector_id')
                                        ->leftJoin('sectors as ss', 'ss.id', '=', 's.sector_id')
                                        ->where('pdrbs.dataset_id', $current_dataset->id)
                                        ->where('pdrbs.quarter', $index)
                                        ->where('ss.category_id', $sector[1])
                                        ->get()->toArray();
                                }
                            } else {
                                $query = Pdrb::selectRaw('SUM(pdrbs.adhb) AS adhb, SUM(pdrbs.adhk) AS adhk, SUM(adjustments.adhb) AS adjust_adhb, SUM(adjustments.adhk) AS adjust_adhk')
                                    ->leftJoin('adjustments', 'pdrbs.id', '=', 'adjustments.pdrb_id')
                                    ->where('pdrbs.dataset_id', $current_dataset->id)
                                    ->where('pdrbs.quarter', $index)
                                    ->get()->toArray();
                            }
                            $data['current'][$region->id][$index] = $query[0];

                            if ($filter['type'] == 'Pengeluaran' && sizeof($sector) == 1) {
                                $impor = Pdrb::selectRaw('SUM(pdrbs.adhb) AS adhb, SUM(pdrbs.adhk) AS adhk, SUM(adjustments.adhb) AS adjust_adhb, SUM(adjustments.adhk) AS adjust_adhk')
                                    ->leftJoin('adjustments', 'pdrbs.id', '=', 'adjustments.pdrb_id')
                                    ->where('pdrbs.dataset_id', $current_dataset->id)
                                    ->where('pdrbs.quarter', $index)
                                    ->where('subsector_id', 69)
                                    ->get()->toArray();

                                $data['current'][$region->id][$index]['adhb'] = (string)($data['current'][$region->id][$index]['adhb'] - (2 * $impor[0]['adhb']));
                                $data['current'][$region->id][$index]['adhk'] = (string)($data['current'][$region->id][$index]['adhk'] - (2 * $impor[0]['adhk']));
                                $data['current'][$region->id][$index]['adjust_adhb'] = (string)($data['current'][$region->id][$index]['adjust_adhb'] - (2 * $impor[0]['adjust_adhb']));
                                $data['current'][$region->id][$index]['adjust_adhk'] = (string)($data['current'][$region->id][$index]['adjust_adhk'] - (2 * $impor[0]['adjust_adhk']));
                            }
                        }
                    }
                } else {

                    $message = [
                        'type' => 'warning',
                        'title' => 'Warning',
                        'text' => 'Data ' . $region->name . ' periode ini tidak ditemukan'
                    ];
                    array_push($notification, $message);
                }

                if (isset($previous_dataset)) {
                    for ($index = 1; $index <= 4; $index++) {
                        if (sizeof($sector) > 1) {
                            # code...
                            if ($sector[0] == 'sector') {
                                # code...
                                # if sector = net export-import do this! uhuy
                                if ($sector[1] == '54') {
                                    # code...
                                    $query = Pdrb::selectRaw('subsector_id as identifier, pdrbs.adhb AS adhb, pdrbs.adhk AS adhk, adjustments.adhb AS adjust_adhb, adjustments.adhk AS adjust_adhk')
                                        ->leftJoin('adjustments', 'pdrbs.id', '=', 'adjustments.pdrb_id')
                                        ->leftJoin('subsectors as s', 's.id', '=', 'pdrbs.subsector_id')
                                        ->where('pdrbs.dataset_id', $previous_dataset->id)
                                        ->where('pdrbs.quarter', $index)
                                        ->where('s.sector_id', $sector[1])
                                        ->get()->toArray();
                                    // dd($query[0]);
                                    $exports = [];
                                    $imports = [];
                                    foreach ($query as $item) {
                                        if ($item['identifier'] == "68") {
                                            $exports = $item;
                                        } elseif ($item['identifier'] == "69") {
                                            $imports = $item;
                                        }
                                    }
                                    $query[0]['adhb'] = (string)($exports['adhb'] - $imports['adhb']);
                                    $query[0]['adhk'] = (string)($exports['adhk'] - $imports['adhk']);
                                    $query[0]['adjust_adhb'] = (string)($exports['adjust_adhb'] - $imports['adjust_adhb']);
                                    $query[0]['adjust_adhk'] = (string)($exports['adjust_adhb'] - $imports['adjust_adhb']);
                                } else {
                                    $query = Pdrb::selectRaw('SUM(pdrbs.adhb) AS adhb, SUM(pdrbs.adhk) AS adhk, SUM(adjustments.adhb) AS adjust_adhb, SUM(adjustments.adhk) AS adjust_adhk')
                                        ->leftJoin('adjustments', 'pdrbs.id', '=', 'adjustments.pdrb_id')
                                        ->leftJoin('subsectors as s', 's.id', '=', 'pdrbs.subsector_id')
                                        ->where('pdrbs.dataset_id', $previous_dataset->id)
                                        ->where('pdrbs.quarter', $index)
                                        ->where('s.sector_id', $sector[1])
                                        ->get()->toArray();
                                }
                            } else {
                                $query = Pdrb::selectRaw('SUM(pdrbs.adhb) AS adhb, SUM(pdrbs.adhk) AS adhk, SUM(adjustments.adhb) AS adjust_adhb, SUM(adjustments.adhk) AS adjust_adhk')
                                    ->leftJoin('adjustments', 'pdrbs.id', '=', 'adjustments.pdrb_id')
                                    ->leftJoin('subsectors as s', 's.id', '=', 'pdrbs.subsector_id')
                                    ->leftJoin('sectors as ss', 'ss.id', '=', 's.sector_id')
                                    ->where('pdrbs.dataset_id', $previous_dataset->id)
                                    ->where('pdrbs.quarter', $index)
                                    ->where('ss.category_id', $sector[1])
                                    ->get()->toArray();
                            }
                        } else {
                            $query = $query = Pdrb::selectRaw('SUM(pdrbs.adhb) AS adhb, SUM(pdrbs.adhk) AS adhk, SUM(adjustments.adhb) AS adjust_adhb, SUM(adjustments.adhk) AS adjust_adhk')
                                ->leftJoin('adjustments', 'pdrbs.id', '=', 'adjustments.pdrb_id')
                                ->where('pdrbs.dataset_id', $previous_dataset->id)
                                ->where('pdrbs.quarter', $index)
                                ->get()->toArray();
                        }
                        $data['previous'][$region->id][$index] = $query[0];

                        if ($filter['type'] == 'Pengeluaran' && sizeof($sector) == 1) {
                            $impor = Pdrb::selectRaw('SUM(pdrbs.adhb) AS adhb, SUM(pdrbs.adhk) AS adhk, SUM(adjustments.adhb) AS adjust_adhb, SUM(adjustments.adhk) AS adjust_adhk')
                                ->leftJoin('adjustments', 'pdrbs.id', '=', 'adjustments.pdrb_id')
                                ->where('pdrbs.dataset_id', $previous_dataset->id)
                                ->where('pdrbs.quarter', $index)
                                ->where('subsector_id', 69)
                                ->get()->toArray();

                            $data['previous'][$region->id][$index]['adhb'] = (string)($data['previous'][$region->id][$index]['adhb'] - (2 * $impor[0]['adhb']));
                            $data['previous'][$region->id][$index]['adhk'] = (string)($data['previous'][$region->id][$index]['adhk'] - (2 * $impor[0]['adhk']));
                            $data['previous'][$region->id][$index]['adjust_adhb'] = (string)($data['previous'][$region->id][$index]['adjust_adhb'] - (2 * $impor[0]['adjust_adhb']));
                            $data['previous'][$region->id][$index]['adjust_adhk'] = (string)($data['previous'][$region->id][$index]['adjust_adhk'] - (2 * $impor[0]['adjust_adhk']));
                        }
                    }
                } else {
                    $message = [
                        'type' => 'warning',
                        'title' => 'Warning',
                        'text' => 'Data ' . $region->name . ' periode sebelumnya tidak ditemukan'
                    ];
                    array_push($notification, $message);
                }
            }
        }

        array_push($notification, [
            'type' => 'success',
            'title' => 'Berhasil',
            'text' => 'Data berhasil diunduh'
        ]);

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
        foreach ($adjustment as $data) {
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
