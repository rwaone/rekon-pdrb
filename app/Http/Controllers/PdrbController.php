<?php

namespace App\Http\Controllers;

use App\Models\Pdrb;
use App\Models\Period;
use App\Models\Region;
use App\Models\Satker;
use App\Models\Sector;
use App\Models\Dataset;
use App\Models\Category;
use App\Models\Subsector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function monitoring()
    {
        $quarter = [1, 2, 3, 4];
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
        $dataset = Dataset::where('period_id', $copy['periodCopy'])->where('region_id', $filter['region_id'])->first();
        for ($index = 1; $index <= $copy['quarterCopy']; $index++) {
            $data[$index] = Pdrb::where('dataset_id', $dataset->id)->where('quarter', $index)->orderBy('subsector_id')->get();
        }
        return response()->json($data);
    }

    public function getFullData(Request $request)
    {
        $filter = $request->filter;
        $type = $filter['type'];
        $subsectors = Subsector::where('type', $filter['type'])->get();
        $notification = [];

        $current_dataset = Dataset::where('period_id', $filter['period_id'])
            ->where('region_id', $filter['region_id'])
            ->first();

        $previous_dataset = Dataset::where('type', $filter['type'])
            ->where('region_id', $filter['region_id'])
            ->where('year', $filter['year'] - 1)
            ->where('quarter', 4)
            ->latest('id')
            ->first();


        if (isset($previous_dataset)) {
            $previous_data = [];
            for ($index = 1; $index <= 4; $index++) {
                $previous_data[$index] = Pdrb::where('dataset_id', $previous_dataset->id)
                    ->where('quarter', $index)
                    ->with('subsector.sector')
                    ->orderBy('subsector_id')
                    ->get();
            }

            $previous_period = Period::where('id', $previous_dataset->period_id)->first();
            $message = [
                'type' => 'success',
                'text' => 'Data periode sebelumnya berhasil diunduh, Tahun ' . $previous_period->year . ' ' . $previous_period->description
            ];

            array_push($notification, $message);
        } else {
            for ($index = 1; $index <= 4; $index++) {
                $inputData = [];
                foreach ($subsectors as $subsector) {
                    $singleData = [
                        'subsector_id' => $subsector->id,
                        'type' => $filter['type'],
                        'year' => $filter['year'] - 1,
                        'quarter' => $index,
                        'region_id' => $filter['region_id'],
                        'adhb' => null,
                        'adhk' => null,
                    ];
                    array_push($inputData, $singleData);
                }
                $previous_data[$index] = (object) $inputData;
            }

            $message = [
                'type' => 'warning',
                'text' => 'Data periode sebelumnya tidak ada / belum final, summary tidak dapat ditampilkan'
            ];
            array_push($notification, $message);
        }


        $current_data = [];

        if (isset($current_dataset)) {
            for ($index = 1; $index <= 4; $index++) {
                if ($index <= $filter['quarter']) {
                    $current_data[$index] = Pdrb::where('dataset_id', $current_dataset->id)
                        ->where('quarter', $index)
                        ->orderBy('subsector_id')
                        ->with('subsector.sector')
                        ->get();
                }
            }

            array_push($notification, [
                'type' => 'success',
                'text' => 'Data periode ini berhasil diunduh'
            ]);
        } else {
            $current_dataset = Dataset::create([
                'type' => $filter['type'],
                'period_id' => $filter['period_id'],
                'region_id' => $filter['region_id'],
                'year' => $filter['year'],
                'quarter' => $filter['quarter'],
                'status' => 'Entry',
            ]);

            for ($index = 1; $index <= 4; $index++) {
                if ($index <= $filter['quarter']) {

                    $inputData = [];
                    $timestamp = date('Y-m-d H:i:s');
                    foreach ($subsectors as $subsector) {
                        $singleData = [
                            'subsector_id' => $subsector->id,
                            'dataset_id' => $current_dataset->id,
                            'year' => $filter['year'],
                            'quarter' => $index,
                            'created_at' => $timestamp,
                            'updated_at' => $timestamp,
                        ];
                        array_push($inputData, $singleData);
                    }

                    Pdrb::insert($inputData);
                    $current_data[$index] = Pdrb::where('dataset_id', $current_dataset->id)
                        ->where('quarter', $index)
                        ->orderBy('subsector_id')
                        ->with('subsector.sector')
                        ->get();
                }
            }

            array_push($notification, [
                'type' => 'success',
                'text' => 'Data periode ini berhasil dibuat'
            ]);
        }

        if ($type == 'Lapangan Usaha') {
            $current_result = [];
            foreach ($current_data as $outerKey => $quarter) {
                foreach ($quarter as $innerKey => $lapus) {
                    $quarter[$innerKey] = collect([
                        'adhb' => $lapus->adhb,
                        'adhk' => $lapus->adhk,
                        'adjustment' => [
                            'adhb' => $lapus->adjustment->adhb ?? null,
                            'adhk' => $lapus->adjustment->adhk ?? null,
                        ],
                        'subsector_id' => $lapus->subsector_id,
                        'category_id' => $lapus->subsector->sector->category_id ?? null,
                        'id' => $lapus->id,
                    ]);
                }
                // Define category ranges
                $primer = range(1, 3);
                $sekunder = range(4, 6);
                $tersier = range(7, 17);

                // Initialize aggregates for each category group
                $current_primer = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];
                $current_sekunder = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];
                $current_tersier = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];

                foreach ($quarter as $innerKey => $lapus) {
                    // Process each category group
                    if (in_array($lapus['category_id'], $primer)) {
                        $current_primer['adhb'] += $lapus['adhb'];
                        $current_primer['adhk'] += $lapus['adhk'];
                        $current_primer['adj_adhb'] += $lapus['adjustment']['adhb'];
                        $current_primer['adj_adhk'] += $lapus['adjustment']['adhk'];
                    }

                    if (in_array($lapus['category_id'], $sekunder)) {
                        $current_sekunder['adhb'] += $lapus['adhb'];
                        $current_sekunder['adhk'] += $lapus['adhk'];
                        $current_sekunder['adj_adhb'] += $lapus['adjustment']['adhb'];
                        $current_sekunder['adj_adhk'] += $lapus['adjustment']['adhk'];
                    }

                    if (in_array($lapus['category_id'], $tersier)) {
                        $current_tersier['adhb'] += $lapus['adhb'];
                        $current_tersier['adhk'] += $lapus['adhk'];
                        $current_tersier['adj_adhb'] += $lapus['adjustment']['adhb'];
                        $current_tersier['adj_adhk'] += $lapus['adjustment']['adhk'];
                    }
                }

                // Store aggregated results for each quarter
                $current_result[$outerKey] = collect([
                    'primer' => $current_primer,
                    'sekunder' => $current_sekunder,
                    'tersier' => $current_tersier,
                ]);
            }

            $previous_result = [];
            foreach ($previous_data as $outerKey => $quarter) {
                foreach ($quarter as $innerKey => $lapus) {
                    $quarter[$innerKey] = collect([
                        'adhb' => $lapus->adhb,
                        'adhk' => $lapus->adhk,
                        'adjustment' => [
                            'adhb' => $lapus->adjustment->adhb ?? null,
                            'adhk' => $lapus->adjustment->adhk ?? null,
                        ],
                        'subsector_id' => $lapus->subsector_id,
                        'category_id' => $lapus->subsector->sector->category_id ?? null,
                        'id' => $lapus->id,
                    ]);
                }
                // Define category ranges
                $primer = range(1, 3);
                $sekunder = range(4, 6);
                $tersier = range(7, 17);

                // Initialize aggregates for each category group
                $previous_primer = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];
                $previous_sekunder = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];
                $previous_tersier = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];

                foreach ($quarter as $innerKey => $lapus) {
                    // Process each category group
                    if (in_array($lapus['category_id'], $primer)) {
                        $previous_primer['adhb'] += $lapus['adhb'];
                        $previous_primer['adhk'] += $lapus['adhk'];
                        $previous_primer['adj_adhb'] += $lapus['adjustment']['adhb'];
                        $previous_primer['adj_adhk'] += $lapus['adjustment']['adhk'];
                    }

                    if (in_array($lapus['category_id'], $sekunder)) {
                        $previous_sekunder['adhb'] += $lapus['adhb'];
                        $previous_sekunder['adhk'] += $lapus['adhk'];
                        $previous_sekunder['adj_adhb'] += $lapus['adjustment']['adhb'];
                        $previous_sekunder['adj_adhk'] += $lapus['adjustment']['adhk'];
                    }

                    if (in_array($lapus['category_id'], $tersier)) {
                        $previous_tersier['adhb'] += $lapus['adhb'];
                        $previous_tersier['adhk'] += $lapus['adhk'];
                        $previous_tersier['adj_adhb'] += $lapus['adjustment']['adhb'];
                        $previous_tersier['adj_adhk'] += $lapus['adjustment']['adhk'];
                    }
                }

                // Store aggregated results for each quarter
                $previous_result[$outerKey] = collect([
                    'primer' => $previous_primer,
                    'sekunder' => $previous_sekunder,
                    'tersier' => $previous_tersier,
                ]);
            }
        } else {
            $current_result = [];
            foreach ($current_data as $outerKey => $quarter) {
                foreach ($quarter as $innerKey => $peng) {
                    $quarter[$innerKey] = collect([
                        'adhb' => $peng->adhb,
                        'adhk' => $peng->adhk,
                        'adjustment' => [
                            'adhb' => $peng->adjustment->adhb ?? null,
                            'adhk' => $peng->adjustment->adhk ?? null,
                        ],
                        'subsector_id' => $peng->subsector_id,
                        'sector_id' => $peng->subsector->sector->id ?? null,
                        'id' => $peng->id,
                    ]);
                }
                // Define category ranges
                $kanp = range(49, 50);
                $kap = [51];
                $pai = range(52, 53);
                $lainnya = [54];

                // Initialize aggregates for each category group
                $current_kanp = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];
                $current_kap = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];
                $current_pai = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];
                $current_lainnya = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];

                foreach ($quarter as $innerKey => $peng) {
                    // Process each category group
                    if (in_array($peng['sector_id'], $kanp)) {
                        $current_kanp['adhb'] += $peng['adhb'];
                        $current_kanp['adhk'] += $peng['adhk'];
                        $current_kanp['adj_adhb'] += $peng['adjustment']['adhb'];
                        $current_kanp['adj_adhk'] += $peng['adjustment']['adhk'];
                    }

                    if (in_array($peng['sector_id'], $kap)) {
                        $current_kap['adhb'] += $peng['adhb'];
                        $current_kap['adhk'] += $peng['adhk'];
                        $current_kap['adj_adhb'] += $peng['adjustment']['adhb'];
                        $current_kap['adj_adhk'] += $peng['adjustment']['adhk'];
                    }

                    if (in_array($peng['sector_id'], $pai)) {
                        $current_pai['adhb'] += $peng['adhb'];
                        $current_pai['adhk'] += $peng['adhk'];
                        $current_pai['adj_adhb'] += $peng['adjustment']['adhb'];
                        $current_pai['adj_adhk'] += $peng['adjustment']['adhk'];
                    }
                }

                $sector_68 = collect($quarter)->firstWhere('subsector_id', 68);
                $sector_69 = collect($quarter)->firstWhere('subsector_id', 69);

                // Calculate the difference
                if ($sector_68 && $sector_69) {
                    $current_lainnya['adhb'] = $sector_68['adhb'] - $sector_69['adhb'];
                    $current_lainnya['adhk'] = $sector_68['adhk'] - $sector_69['adhk'];
                    $current_lainnya['adj_adhb'] = $sector_68['adjustment']['adhb'] - $sector_69['adjustment']['adhb'];
                    $current_lainnya['adj_adhk'] = $sector_68['adjustment']['adhk'] - $sector_69['adjustment']['adhk'];
                }

                // Store aggregated results for each quarter
                $current_result[$outerKey] = collect([
                    'kanp' => $current_kanp,
                    'kap' => $current_kap,
                    'pai' => $current_pai,
                    'lainnya' => $current_lainnya,
                ]);
            }

            $previous_result = [];
            foreach ($previous_data as $outerKey => $quarter) {
                foreach ($quarter as $innerKey => $peng) {
                    $quarter[$innerKey] = collect([
                        'adhb' => $peng->adhb,
                        'adhk' => $peng->adhk,
                        'adjustment' => [
                            'adhb' => $peng->adjustment->adhb ?? null,
                            'adhk' => $peng->adjustment->adhk ?? null,
                        ],
                        'subsector_id' => $peng->subsector_id,
                        'sector_id' => $peng->subsector->sector->id ?? null,
                        'id' => $peng->id,
                    ]);
                }
                // Define category ranges
                $kanp = range(49, 50);
                $kap = [51];
                $pai = range(52, 53);
                $lainnya = [54];

                // Initialize aggregates for each category group
                $current_kanp = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];
                $current_kap = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];
                $current_pai = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];
                $current_lainnya = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];

                foreach ($quarter as $innerKey => $peng) {
                    // Process each category group
                    if (in_array($peng['sector_id'], $kanp)) {
                        $current_kanp['adhb'] += $peng['adhb'];
                        $current_kanp['adhk'] += $peng['adhk'];
                        $current_kanp['adj_adhb'] += $peng['adjustment']['adhb'];
                        $current_kanp['adj_adhk'] += $peng['adjustment']['adhk'];
                    }

                    if (in_array($peng['sector_id'], $kap)) {
                        $current_kap['adhb'] += $peng['adhb'];
                        $current_kap['adhk'] += $peng['adhk'];
                        $current_kap['adj_adhb'] += $peng['adjustment']['adhb'];
                        $current_kap['adj_adhk'] += $peng['adjustment']['adhk'];
                    }

                    if (in_array($peng['sector_id'], $pai)) {
                        $current_pai['adhb'] += $peng['adhb'];
                        $current_pai['adhk'] += $peng['adhk'];
                        $current_pai['adj_adhb'] += $peng['adjustment']['adhb'];
                        $current_pai['adj_adhk'] += $peng['adjustment']['adhk'];
                    }
                }

                $sector_68 = collect($quarter)->firstWhere('subsector_id', 68);
                $sector_69 = collect($quarter)->firstWhere('subsector_id', 69);

                // Calculate the difference
                if ($sector_68 && $sector_69) {
                    $current_lainnya['adhb'] = $sector_68['adhb'] - $sector_69['adhb'];
                    $current_lainnya['adhk'] = $sector_68['adhk'] - $sector_69['adhk'];
                    $current_lainnya['adj_adhb'] = $sector_68['adjustment']['adhb'] - $sector_69['adjustment']['adhb'];
                    $current_lainnya['adj_adhk'] = $sector_68['adjustment']['adhk'] - $sector_69['adjustment']['adhk'];
                }

                // Store aggregated results for each quarter
                $previous_result[$outerKey] = collect([
                    'kanp' => $current_kanp,
                    'kap' => $current_kap,
                    'pai' => $current_pai,
                    'lainnya' => $current_lainnya,
                ]);
            }
        }

        return response()->json([
            'dataset' => $current_dataset,
            'current_data' => $current_data,
            'previous_data' => $previous_data,
            'messages' => $notification,
            'current_result' => $current_result,
            'previous_result' => $previous_result,
            'type' => $type
        ]);
    }

    public function getResultForKabkot(Request $request)
    {
        $filter = $request->filter;
        $type = $filter['type'];
        $subsectors = Subsector::where('type', $filter['type'])->get();
        $notification = [];

        $current_dataset = Dataset::where('period_id', $filter['period_id'])
            ->where('region_id', $filter['region_id'])
            ->first();

        $previous_dataset = Dataset::where('type', $filter['type'])
            ->where('region_id', $filter['region_id'])
            ->where('year', $filter['year'] - 1)
            ->where('quarter', 4)
            ->latest('id')
            ->first();


        if (isset($previous_dataset)) {
            $previous_data = [];
            for ($index = 1; $index <= 4; $index++) {
                $previous_data[$index] = Pdrb::where('dataset_id', $previous_dataset->id)
                    ->where('quarter', $index)
                    ->with('subsector.sector')
                    ->orderBy('subsector_id')
                    ->get();
            }

            $previous_period = Period::where('id', $previous_dataset->period_id)->first();
            $message = [
                'type' => 'success',
                'text' => 'Data periode sebelumnya berhasil diunduh, Tahun ' . $previous_period->year . ' ' . $previous_period->description
            ];

            array_push($notification, $message);
        } else {
            for ($index = 1; $index <= 4; $index++) {
                $inputData = [];
                foreach ($subsectors as $subsector) {
                    $singleData = [
                        'subsector_id' => $subsector->id,
                        'type' => $filter['type'],
                        'year' => $filter['year'] - 1,
                        'quarter' => $index,
                        'region_id' => $filter['region_id'],
                        'adhb' => null,
                        'adhk' => null,
                    ];
                    array_push($inputData, $singleData);
                }
                $previous_data[$index] = (object) $inputData;
            }

            $message = [
                'type' => 'warning',
                'text' => 'Data periode sebelumnya tidak ada / belum final, summary tidak dapat ditampilkan'
            ];
            array_push($notification, $message);
        }


        $current_data = [];

        if (isset($current_dataset)) {
            for ($index = 1; $index <= 4; $index++) {
                if ($index <= $filter['quarter']) {
                    $current_data[$index] = Pdrb::where('dataset_id', $current_dataset->id)
                        ->where('quarter', $index)
                        ->orderBy('subsector_id')
                        ->with('subsector.sector')
                        ->get();
                }
            }

            array_push($notification, [
                'type' => 'success',
                'text' => 'Data periode ini berhasil diunduh'
            ]);
        } else {
            $current_dataset = Dataset::create([
                'type' => $filter['type'],
                'period_id' => $filter['period_id'],
                'region_id' => $filter['region_id'],
                'year' => $filter['year'],
                'quarter' => $filter['quarter'],
                'status' => 'Entry',
            ]);

            for ($index = 1; $index <= 4; $index++) {
                if ($index <= $filter['quarter']) {

                    $inputData = [];
                    $timestamp = date('Y-m-d H:i:s');
                    foreach ($subsectors as $subsector) {
                        $singleData = [
                            'subsector_id' => $subsector->id,
                            'dataset_id' => $current_dataset->id,
                            'year' => $filter['year'],
                            'quarter' => $index,
                            'created_at' => $timestamp,
                            'updated_at' => $timestamp,
                        ];
                        array_push($inputData, $singleData);
                    }

                    Pdrb::insert($inputData);
                    $current_data[$index] = Pdrb::where('dataset_id', $current_dataset->id)
                        ->where('quarter', $index)
                        ->orderBy('subsector_id')
                        ->with('subsector.sector')
                        ->get();
                }
            }

            array_push($notification, [
                'type' => 'success',
                'text' => 'Data periode ini berhasil dibuat'
            ]);
        }
        if ($type == 'Lapangan Usaha') {
            $current_result = [];
            foreach ($current_data as $outerKey => $quarter) {
                foreach ($quarter as $innerKey => $lapus) {
                    $quarter[$innerKey] = collect([
                        'adhb' => $lapus->adhb,
                        'adhk' => $lapus->adhk,
                        'adjustment' => [
                            'adhb' => $lapus->adjustment->adhb ?? null,
                            'adhk' => $lapus->adjustment->adhk ?? null,
                        ],
                        'subsector_id' => $lapus->subsector_id,
                        'category_id' => $lapus->subsector->sector->category_id ?? null,
                        'id' => $lapus->id,
                    ]);
                }
                // Define category ranges
                $primer = range(1, 3);
                $sekunder = range(4, 6);
                $tersier = range(7, 17);

                // Initialize aggregates for each category group
                $current_primer = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];
                $current_sekunder = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];
                $current_tersier = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];

                foreach ($quarter as $innerKey => $lapus) {
                    // Process each category group
                    if (in_array($lapus['category_id'], $primer)) {
                        $current_primer['adhb'] += $lapus['adhb'];
                        $current_primer['adhk'] += $lapus['adhk'];
                        $current_primer['adj_adhb'] += $lapus['adjustment']['adhb'];
                        $current_primer['adj_adhk'] += $lapus['adjustment']['adhk'];
                    }

                    if (in_array($lapus['category_id'], $sekunder)) {
                        $current_sekunder['adhb'] += $lapus['adhb'];
                        $current_sekunder['adhk'] += $lapus['adhk'];
                        $current_sekunder['adj_adhb'] += $lapus['adjustment']['adhb'];
                        $current_sekunder['adj_adhk'] += $lapus['adjustment']['adhk'];
                    }

                    if (in_array($lapus['category_id'], $tersier)) {
                        $current_tersier['adhb'] += $lapus['adhb'];
                        $current_tersier['adhk'] += $lapus['adhk'];
                        $current_tersier['adj_adhb'] += $lapus['adjustment']['adhb'];
                        $current_tersier['adj_adhk'] += $lapus['adjustment']['adhk'];
                    }
                }

                // Store aggregated results for each quarter
                $current_result[$outerKey] = collect([
                    'primer' => $current_primer,
                    'sekunder' => $current_sekunder,
                    'tersier' => $current_tersier,
                ]);
            }

            $previous_result = [];
            foreach ($previous_data as $outerKey => $quarter) {
                foreach ($quarter as $innerKey => $lapus) {
                    $quarter[$innerKey] = collect([
                        'adhb' => $lapus->adhb,
                        'adhk' => $lapus->adhk,
                        'adjustment' => [
                            'adhb' => $lapus->adjustment->adhb ?? null,
                            'adhk' => $lapus->adjustment->adhk ?? null,
                        ],
                        'subsector_id' => $lapus->subsector_id,
                        'category_id' => $lapus->subsector->sector->category_id ?? null,
                        'id' => $lapus->id,
                    ]);
                }
                // Define category ranges
                $primer = range(1, 3);
                $sekunder = range(4, 6);
                $tersier = range(7, 17);

                // Initialize aggregates for each category group
                $previous_primer = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];
                $previous_sekunder = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];
                $previous_tersier = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];

                foreach ($quarter as $innerKey => $lapus) {
                    // Process each category group
                    if (in_array($lapus['category_id'], $primer)) {
                        $previous_primer['adhb'] += $lapus['adhb'];
                        $previous_primer['adhk'] += $lapus['adhk'];
                        $previous_primer['adj_adhb'] += $lapus['adjustment']['adhb'];
                        $previous_primer['adj_adhk'] += $lapus['adjustment']['adhk'];
                    }

                    if (in_array($lapus['category_id'], $sekunder)) {
                        $previous_sekunder['adhb'] += $lapus['adhb'];
                        $previous_sekunder['adhk'] += $lapus['adhk'];
                        $previous_sekunder['adj_adhb'] += $lapus['adjustment']['adhb'];
                        $previous_sekunder['adj_adhk'] += $lapus['adjustment']['adhk'];
                    }

                    if (in_array($lapus['category_id'], $tersier)) {
                        $previous_tersier['adhb'] += $lapus['adhb'];
                        $previous_tersier['adhk'] += $lapus['adhk'];
                        $previous_tersier['adj_adhb'] += $lapus['adjustment']['adhb'];
                        $previous_tersier['adj_adhk'] += $lapus['adjustment']['adhk'];
                    }
                }

                // Store aggregated results for each quarter
                $previous_result[$outerKey] = collect([
                    'primer' => $previous_primer,
                    'sekunder' => $previous_sekunder,
                    'tersier' => $previous_tersier,
                ]);
            }
        } else {
            $current_result = [];
            foreach ($current_data as $outerKey => $quarter) {
                foreach ($quarter as $innerKey => $peng) {
                    $quarter[$innerKey] = collect([
                        'adhb' => $peng->adhb,
                        'adhk' => $peng->adhk,
                        'adjustment' => [
                            'adhb' => $peng->adjustment->adhb ?? null,
                            'adhk' => $peng->adjustment->adhk ?? null,
                        ],
                        'subsector_id' => $peng->subsector_id,
                        'sector_id' => $peng->subsector->sector->id ?? null,
                        'id' => $peng->id,
                    ]);
                }
                // Define category ranges
                $kanp = range(49, 50);
                $kap = [51];
                $pai = range(52, 53);
                $lainnya = [54];

                // Initialize aggregates for each category group
                $current_kanp = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];
                $current_kap = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];
                $current_pai = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];
                $current_lainnya = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];

                foreach ($quarter as $innerKey => $peng) {
                    // Process each category group
                    if (in_array($peng['sector_id'], $kanp)) {
                        $current_kanp['adhb'] += $peng['adhb'];
                        $current_kanp['adhk'] += $peng['adhk'];
                        $current_kanp['adj_adhb'] += $peng['adjustment']['adhb'];
                        $current_kanp['adj_adhk'] += $peng['adjustment']['adhk'];
                    }

                    if (in_array($peng['sector_id'], $kap)) {
                        $current_kap['adhb'] += $peng['adhb'];
                        $current_kap['adhk'] += $peng['adhk'];
                        $current_kap['adj_adhb'] += $peng['adjustment']['adhb'];
                        $current_kap['adj_adhk'] += $peng['adjustment']['adhk'];
                    }

                    if (in_array($peng['sector_id'], $pai)) {
                        $current_pai['adhb'] += $peng['adhb'];
                        $current_pai['adhk'] += $peng['adhk'];
                        $current_pai['adj_adhb'] += $peng['adjustment']['adhb'];
                        $current_pai['adj_adhk'] += $peng['adjustment']['adhk'];
                    }
                }

                $sector_68 = collect($quarter)->firstWhere('subsector_id', 68);
                $sector_69 = collect($quarter)->firstWhere('subsector_id', 69);

                // Calculate the difference
                if ($sector_68 && $sector_69) {
                    $current_lainnya['adhb'] = $sector_68['adhb'] - $sector_69['adhb'];
                    $current_lainnya['adhk'] = $sector_68['adhk'] - $sector_69['adhk'];
                    $current_lainnya['adj_adhb'] = $sector_68['adjustment']['adhb'] - $sector_69['adjustment']['adhb'];
                    $current_lainnya['adj_adhk'] = $sector_68['adjustment']['adhk'] - $sector_69['adjustment']['adhk'];
                }

                // Store aggregated results for each quarter
                $current_result[$outerKey] = collect([
                    'kanp' => $current_kanp,
                    'kap' => $current_kap,
                    'pai' => $current_pai,
                    'lainnya' => $current_lainnya,
                ]);
            }

            $previous_result = [];
            foreach ($previous_data as $outerKey => $quarter) {
                foreach ($quarter as $innerKey => $peng) {
                    $quarter[$innerKey] = collect([
                        'adhb' => $peng->adhb,
                        'adhk' => $peng->adhk,
                        'adjustment' => [
                            'adhb' => $peng->adjustment->adhb ?? null,
                            'adhk' => $peng->adjustment->adhk ?? null,
                        ],
                        'subsector_id' => $peng->subsector_id,
                        'sector_id' => $peng->subsector->sector->id ?? null,
                        'id' => $peng->id,
                    ]);
                }
                // Define category ranges
                $kanp = range(49, 50);
                $kap = [51];
                $pai = range(52, 53);
                $lainnya = [54];

                // Initialize aggregates for each category group
                $current_kanp = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];
                $current_kap = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];
                $current_pai = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];
                $current_lainnya = [
                    'adhb' => 0,
                    'adhk' => 0,
                    'adj_adhb' => 0,
                    'adj_adhk' => 0
                ];

                foreach ($quarter as $innerKey => $peng) {
                    // Process each category group
                    if (in_array($peng['sector_id'], $kanp)) {
                        $current_kanp['adhb'] += $peng['adhb'];
                        $current_kanp['adhk'] += $peng['adhk'];
                        $current_kanp['adj_adhb'] += $peng['adjustment']['adhb'];
                        $current_kanp['adj_adhk'] += $peng['adjustment']['adhk'];
                    }

                    if (in_array($peng['sector_id'], $kap)) {
                        $current_kap['adhb'] += $peng['adhb'];
                        $current_kap['adhk'] += $peng['adhk'];
                        $current_kap['adj_adhb'] += $peng['adjustment']['adhb'];
                        $current_kap['adj_adhk'] += $peng['adjustment']['adhk'];
                    }

                    if (in_array($peng['sector_id'], $pai)) {
                        $current_pai['adhb'] += $peng['adhb'];
                        $current_pai['adhk'] += $peng['adhk'];
                        $current_pai['adj_adhb'] += $peng['adjustment']['adhb'];
                        $current_pai['adj_adhk'] += $peng['adjustment']['adhk'];
                    }
                }

                $sector_68 = collect($quarter)->firstWhere('subsector_id', 68);
                $sector_69 = collect($quarter)->firstWhere('subsector_id', 69);

                // Calculate the difference
                if ($sector_68 && $sector_69) {
                    $current_lainnya['adhb'] = $sector_68['adhb'] - $sector_69['adhb'];
                    $current_lainnya['adhk'] = $sector_68['adhk'] - $sector_69['adhk'];
                    $current_lainnya['adj_adhb'] = $sector_68['adjustment']['adhb'] - $sector_69['adjustment']['adhb'];
                    $current_lainnya['adj_adhk'] = $sector_68['adjustment']['adhk'] - $sector_69['adjustment']['adhk'];
                }

                // Store aggregated results for each quarter
                $previous_result[$outerKey] = collect([
                    'kanp' => $current_kanp,
                    'kap' => $current_kap,
                    'pai' => $current_pai,
                    'lainnya' => $current_lainnya,
                ]);
            }
        }

        return response()->json([
            'dataset' => $current_dataset,
            'current_data' => $current_data,
            'previous_data' => $previous_data,
            'messages' => $notification,
            'current_result' => $current_result,
            'previous_result' => $previous_result,
        ]);
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

    public function submitData(Request $request)
    {
        $filter = $request->filter;
        Dataset::where('region_id', $filter['region_id'])->where('period_id', $filter['period_id'])->update(['status' => 'Submitted']);

        $messages = [['type' => 'succcess', 'text' => 'Data berhasil disubmit']];

        return response()->json(['messages' => $messages]);
    }

    public function unsubmitData(Request $request)
    {
        $filter = $request->filter;
        Dataset::where('region_id', $filter['region_id'])->where('period_id', $filter['period_id'])->update(['status' => 'Entry']);

        $messages = [['type' => 'succcess', 'text' => 'Data berhasil batal submit']];

        return response()->json(['messages' => $messages]);
    }

    public function getResultData(Request $request)
    {
        $filter = $request->filter;
        $subsectors = Subsector::where('type', $filter['type'])->get();
        $notification = [];

        $current_dataset = Dataset::where('period_id', $filter['period_id'])->where('region_id', $filter['region_id'])->first();

        $previous_dataset = Dataset::where('type', $filter['type'])
            ->where('region_id', $filter['region_id'])
            ->where('year', $filter['year'] - 1)
            ->where('quarter', 4)
            ->latest('id')
            ->first();


        if (isset($previous_dataset)) {
            $previous_data = [];
            for ($index = 1; $index <= 4; $index++) {
                $previous_data[$index] = Pdrb::where('dataset_id', $previous_dataset->id)->where('quarter', $index)->orderBy('subsector_id')->get();
            }

            $previous_period = Period::where('id', $previous_dataset->period_id)->first();
            $message = [
                'type' => 'success',
                'text' => 'Data periode sebelumnya berhasil diunduh, Tahun ' . $previous_period->year . ' ' . $previous_period->description
            ];

            array_push($notification, $message);
        } else {
            for ($index = 1; $index <= 4; $index++) {
                $inputData = [];
                foreach ($subsectors as $subsector) {
                    $singleData = [
                        'subsector_id' => $subsector->id,
                        'type' => $filter['type'],
                        'year' => $filter['year'] - 1,
                        'quarter' => $index,
                        'region_id' => $filter['region_id'],
                        'adhb' => null,
                        'adhk' => null,
                    ];
                    array_push($inputData, $singleData);
                }
                $previous_data[$index] = (object) $inputData;
            }

            $message = [
                'type' => 'warning',
                'text' => 'Data periode sebelumnya tidak ada / belum final, summary tidak dapat ditampilkan'
            ];
            array_push($notification, $message);
        }

        $current_data = [];

        if (isset($current_dataset)) {
            for ($index = 1; $index <= 4; $index++) {
                if ($index <= $filter['quarter']) {
                    $current_data[$index] = Pdrb::where('dataset_id', $current_dataset->id)->where('quarter', $index)->orderBy('subsector_id')->get();
                }
            }

            array_push($notification, [
                'type' => 'success',
                'text' => 'Data periode ini berhasil diunduh'
            ]);
        } else {
            $current_dataset = Dataset::create([
                'type' => $filter['type'],
                'period_id' => $filter['period_id'],
                'region_id' => $filter['region_id'],
                'year' => $filter['year'],
                'quarter' => $filter['quarter'],
                'status' => 'Entry',
            ]);

            for ($index = 1; $index <= 4; $index++) {
                if ($index <= $filter['quarter']) {

                    $inputData = [];
                    $timestamp = date('Y-m-d H:i:s');
                    foreach ($subsectors as $subsector) {
                        $singleData = [
                            'subsector_id' => $subsector->id,
                            'dataset_id' => $current_dataset->id,
                            'year' => $filter['year'],
                            'quarter' => $index,
                            'created_at' => $timestamp,
                            'updated_at' => $timestamp,
                        ];
                        array_push($inputData, $singleData);
                    }

                    Pdrb::insert($inputData);
                    $current_data[$index] = Pdrb::where('dataset_id', $current_dataset->id)->where('quarter', $index)->orderBy('subsector_id')->get();
                }
            }

            array_push($notification, [
                'type' => 'success',
                'text' => 'Data periode ini berhasil dibuat'
            ]);
        }

        return response()->json(['dataset' => $current_dataset, 'current_data' => $current_data, 'previous_data' => $previous_data, 'messages' => $notification]);
    }
}
