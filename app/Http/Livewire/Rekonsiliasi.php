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
    public $years;
    public $quarters;
    public $periods;
    public $region_id;
    public $price_base;
    public $selectedPdrb = NULL;
    public $selectedYear = NULL;
    public $selectedQuarter = NULL;
    public $selectedPeriod = NULL;
    public $formType;
    public $showFormComponent;

    public function mount()
    {
        ($this->selectedPdrb != null) ? $this->years = Period::where('type', $this->selectedPdrb)->groupBy('year')->get('year') : $this->years = [];        
        ($this->selectedYear != null) ? $this->quarters = Period::where('year', $this->selectedYear)->groupBy('quarter')->get('quarter') : $this->quarters = [];
        ($this->selectedQuarter != null) ? $this->periods = Period::where('year', $this->selectedYear)->where('quarter', $this->selectedQuarter)->get() : $this->periods = [];
        $this->formType = null;
    }

    // public function render()
    // {
    //     $this->mount();
    //     $regions = Region::all();
    //     $categories = Category::all();
    //     $sectors = Sector::all();
    //     $subsectors = Subsector::all();
    //     return view('livewire.rekonsiliasi', [
    //         'regions' => $regions,
    //         'categories' => $categories,
    //         'sectors' => $sectors,
    //         'subsectors' => $subsectors,
    //     ]);
    // }

    public function render()
    {
        $this->mount();
        $regions = Region::all();
        $categories = Category::all();
        $sectors = Sector::all();
        $subsectors = Subsector::all();
        return view('livewire.rekonsiliasi', [
            'regions' => $regions,
            'categories' => $categories,
            'sectors' => $sectors,
            'subsectors' => $subsectors,
        ]);
    }

    public function showForm()
    {   
        if($this->selectedQuarter == 'F'){
            $this->showFormComponent = 'showFull';
        } else {
            $this->showFormComponent= 'showSingle';
        }
    }
}
