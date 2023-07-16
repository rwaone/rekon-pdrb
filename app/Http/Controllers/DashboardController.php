<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $periods = Period::where('status', 'Aktif')->get();
        return view('dashboard', [
            'periods' => $periods,
        ]);
    }
}
