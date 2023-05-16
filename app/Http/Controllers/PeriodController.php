<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Period;
use App\Http\Requests\StoreperiodRequest;
use App\Http\Requests\UpdateperiodRequest;

class PeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periods = Period::all();
        return view('period.view', [
            'periods' => $periods,
            'years' => range(date('Y'), 2010),
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
     * @param  \App\Http\Requests\StoreperiodRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreperiodRequest $request)
    {
        //$this->authorize('admin');
        $range = explode(" - ",$request['date_range']);
        $validatedData = $request->validate([
            'type' => 'required',
            'year' => 'required',
            'quarter' => 'required',
            'description' => 'required',
        ]);

        $validatedData['started_at'] = $range[0];
        $validatedData['ended_at'] = $range[1];
        $validatedData['status'] = 'Aktif';
        
        //dd($validatedData);
        
        if(Period::create($validatedData)){
            return redirect('/period')->with('notif',  'Data telah berhasil disimpan!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\period  $period
     * @return \Illuminate\Http\Response
     */
    public function show(period $period)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\period  $period
     * @return \Illuminate\Http\Response
     */
    public function edit(period $period)
    {
        return view('period.edit', [
            'period' => $period,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateperiodRequest  $request
     * @param  \App\Models\period  $period
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateperiodRequest $request, period $period)
    {
        $range = explode(" - ",$request['date_range']);
        $validatedData = $request->validate([
            'type' => 'required',
            'year' => 'required',
            'quarter' => 'required',
            'description' => 'required',
        ]);

        $validatedData['started_at'] = $range[0];
        $validatedData['ended_at'] = $range[1];
        $validatedData['status'] = 'Aktif';
        
        //dd($validatedData);
        
        Period::where('id', $period->id)->update($validatedData);
        return redirect('/period')->with('notif',  'Data telah berhasil disimpan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\period  $period
     * @return \Illuminate\Http\Response
     */
    public function destroy(period $period)
    {
        Period::destroy($period->id);
        return redirect('period')->with('notif', 'Data berhasil dihapus!');
    }

    public function fetchYear(Request $request)
    {
        $data['years'] = Period::where('type',$request->type)->groupBy('year')->get('year');
        return response()->json($data);
    }

    public function fetchQuarter(Request $request)
    {
        $data['quarters'] = Period::where('type', $request->type)->where('year',$request->year)->groupBy('quarter')->get('quarter');
        return response()->json($data);
    }
    
    public function fetchPeriod(Request $request)
    {
        $data['periods'] = Period::where('type', $request->type)->where('year',$request->year)->where('quarter', $request->quarter)->get();
        return response()->json($data);
    }
}
