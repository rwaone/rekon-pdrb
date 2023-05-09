<?php

namespace App\Http\Livewire;

use App\Models\Period;
use App\Models\Region;
use App\Models\Sector;
use Livewire\Component;
use App\Models\Category;
use App\Models\Subsector;

class Rekonsiliasi extends Component
{
    
    public function render()
    {        
        $regions = Region::all();
        $categories = Category::all();
        $sectors = Sector::all();
        $subsectors = Subsector ::all();
        $periods = Period::all();
        return view('livewire.rekonsiliasifull',[
            'regions' => $regions,
            'categories' => $categories,
            'sectors' => $sectors,
            'subsectors' => $subsectors,
            'periods' => $periods
        ]);
    }
}
