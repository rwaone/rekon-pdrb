<?php

namespace App\Http\Livewire;

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
        return view('livewire.rekonsiliasi',[
            'regions' => $regions,
            'categories' => $categories,
            'sectors' => $sectors,
            'subsectors' => $subsectors,
        ]);
    }
}
