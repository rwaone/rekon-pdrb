<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Http\Requests\StoreregionRequest;
use App\Http\Requests\UpdateregionRequest;

class RegionController extends Controller
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
     * @param  \App\Http\Requests\StoreregionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreregionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\region  $region
     * @return \Illuminate\Http\Response
     */
    public function show(region $region)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\region  $region
     * @return \Illuminate\Http\Response
     */
    public function edit(region $region)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateregionRequest  $request
     * @param  \App\Models\region  $region
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateregionRequest $request, region $region)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\region  $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(region $region)
    {
        //
    }

}
