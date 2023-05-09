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

    public function mount()
    {
        ($this->selectedPdrb != null) ? $this->years = Period::where('type', $this->selectedPdrb)->groupBy('year')->get('year') : $this->years = [];        
        ($this->selectedYear != null) ? $this->quarters = Period::where('year', $this->selectedYear)->groupBy('quarter')->get('quarter') : $this->quarters = [];
        ($this->selectedQuarter != null) ? $this->periods = Period::where('year', $this->selectedYear)->where('quarter', $this->selectedQuarter)->get() : $this->periods = [];
    }

    public function render()
    {
        $this->mount();
        $regions = Region::all();
        return view('livewire.rekonsiliasi', [
            'regions' => $regions,
        ]);
    }

    public function showForm()
    {
        $this->formType = $this->selectedQuarter;
        dd($this->formType);
    }
}
