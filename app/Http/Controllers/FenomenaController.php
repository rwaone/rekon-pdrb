<?php

namespace App\Http\Controllers;

use App\Models\Fenomena;
use App\Http\Requests\StorefenomenaRequest;
use App\Http\Requests\UpdatefenomenaRequest;
use App\Models\Category;
use App\Models\Region;
use App\Models\Sector;
use App\Models\Subsector;
use Illuminate\Http\Request;

class FenomenaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regions = Region::all();
        $category = Category::all();
        $sector = Sector::all();
        $subsector = Subsector::all();

        return view('fenomena.view',[
            'regions' => $regions,
            'category' => $category,
            'sector' => $sector,
            'subsector' => $subsector,
        ]);
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

    public function getFenomena(Request $request)
    {
        $filter = $request->filter;        
        $fenomena = Fenomena::where('period_id', $filter['period_id'])->where('region_id', $filter['region_id'])->orderBy('subsector_id')->get();
    }
}
