<?php

namespace App\Http\Controllers;

use App\Models\Pdrb;
use App\Models\Period;
use App\Models\Region;
use App\Models\Satker;
use App\Models\Sector;
use App\Models\Category;
use App\Models\Subsector;
use Illuminate\Http\Request;
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

    public function konserda(Request $request){
        $filter = [
            'type' => '',
            'year' => '',
            'quarter' => '',
            'period_id' => '',
            'region_id' => '',
            'price_base' => '',
        ];
        
        $pdrb = Pdrb::all();
        $year = Period::select('year')->distinct()->get();
        $cat = Category::pluck('code')->toArray();
        $catString = implode(", ", $cat);
        $subsectors = Subsector::all();
        $test = count($subsectors);
        return view('rekonsiliasi.konserda', [
            'years' => $year,
            'pdrb' => $pdrb,
            'subsectors' => $subsectors,
            'test' => $test,
            'cat' => $catString,
        ]);
    }

    public function rekonsiliasi(Request $request)
    {       
        $filter = [
            'type' => '',
            'year' => '',
            'quarter' => '',
            'period_id' => '',
            'region_id' => '',
            'price_base' => '',
        ];

        if ($request->filter) {
            $filter = [
                'type' => $request->filter['type'],
                'year' => $request->filter['year'],
                'quarter' => $request->filter['quarter'],
                'period_id' => $request->filter['period_id'],
                'region_id' => $request->filter['region_id'],
                'price_base' => $request->filter['price_base'],
            ];
            $years = Period::where('type', $filter['type'])->groupBy('year')->get('year');
            $quarters = Period::where('year', $filter['year'])->groupBy('quarter')->get('quarter');
            $periods = Period::where('type', $filter['type'])->where('year', $filter['year'])->where('quarter', $filter['quarter'])->get();
            $data = Pdrb::where('period_id', $filter['period_id'])->where('region_id', $filter['region_id'])->get();
        }else {

            $filter = [
                'type' => '',
                'year' => '',
                'quarter' => '',
                'period_id' => '',
                'region_id' => '',
                'price_base' => '',
            ];
            $years = NULL;
            $quarters = NULL;
            $periods = NULL;
        }

        $cat = Category::pluck('code')->toArray();
        $catString = implode(", ", $cat);
        $regions = Region::all();
        $categories = Category::all();
        $sectors = Sector::all();
        $subsectors = Subsector::all();
        return view('rekonsiliasi.view', [
            'cat' => $catString,
            'regions' => $regions,
            'categories' => $categories,
            'sectors' => $sectors,
            'subsectors' => $subsectors,
            'years' => $years,
            'quarters'  => $quarters,
            'periods' => $periods,
            'filter' => $filter,
        ]);
    }

    public function getFullData($filter) {
        //
    }

    public function getSingleData($filter) {
        //
    }

    public function saveSingleData($filter){
        //
    }

    public function saveFullData($filter){
        //
    }
}
