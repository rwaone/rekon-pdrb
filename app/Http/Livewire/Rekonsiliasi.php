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
    public $message;
    public $selectedYear;
    public $quarter;
    public $type;
    public $period;
    public $region_id;
    public $price_base;
    
    public function mount()
    {
        $this->selectedYear = null;
    }

    public function render()
    {        
        $regions = Region::all();
        $categories = Category::all();
        $sectors = Sector::all();
        $subsectors = Subsector ::all();
        $periods = Period::all();
        return view('livewire.rekonsiliasi',[
            'regions' => $regions,
            'categories' => $categories,
            'sectors' => $sectors,
            'subsector' => $subsectors,
            'periods' => $periods
        ]);
    }
}
