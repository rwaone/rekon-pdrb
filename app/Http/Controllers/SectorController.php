<?php

namespace App\Http\Controllers;

use App\Models\sector;
use App\Http\Requests\StoresectorRequest;
use App\Http\Requests\UpdatesectorRequest;

class SectorController extends Controller
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
     * @param  \App\Http\Requests\StoresectorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoresectorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function show(sector $sector)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function edit(sector $sector)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatesectorRequest  $request
     * @param  \App\Models\sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatesectorRequest $request, sector $sector)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function destroy(sector $sector)
    {
        //
    }
}
