<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Region;
use App\Models\Dataset;
use App\Http\Requests\StoreDatasetRequest;
use App\Http\Requests\UpdateDatasetRequest;
use App\Models\Pdrb;

class DatasetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreDatasetRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Dataset $dataset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dataset $dataset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDatasetRequest $request, Dataset $dataset)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dataset $dataset)
    {
        //
    }

    public function batchCreate()
    {
        $periods = Period::all();
        $regions = Region::all();

        foreach ($periods as $period) {
            foreach($regions as $region){
                $data = [
                    'type' => $period->type,
                    'period_id' => $period->id,
                    'region_id' => $region->id,
                    'year' => $period->year,
                    'quarter' => $period->quarter,
                    'status' => $period->status == 'Final' ? 'Approved' : 'Submitted',
                ];

                Dataset::create($data);

            }
        }
    }

    public function batchUpdatePdrb()
    {
        $pdrb = Pdrb::all();

        foreach($pdrb)

    }
}
