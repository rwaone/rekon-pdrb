<?php

namespace App\Http\Controllers;

use App\Models\Pdrb;
use App\Models\Region;
use App\Models\Satker;
use App\Http\Requests\StorepdrbRequest;
use App\Http\Requests\UpdatepdrbRequest;
use App\Models\Category;
use App\Models\Sector;
use App\Models\Subsector;
use Illuminate\Http\Request;

class PdrbController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request){
            $request->quarter == 'F' ? $formType = 'full-form' : $formType = 'single-form';
        }else {
            $formType = NULL;
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
            'formType' => $formType,
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
     * @param  \App\Http\Requests\StorepdrbRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorepdrbRequest $request)
    {
        //
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

    public function rekonsiliasi(Request $request)
    {        
        return view('livewire.rekonsiliasi', [
        ]);
    }
}
