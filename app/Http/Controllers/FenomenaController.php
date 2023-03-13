<?php

namespace App\Http\Controllers;

use App\Models\fenomena;
use App\Http\Requests\StorefenomenaRequest;
use App\Http\Requests\UpdatefenomenaRequest;

class FenomenaController extends Controller
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
}
