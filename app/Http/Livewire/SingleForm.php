<?php

namespace App\Http\Livewire;

use App\Models\Sector;
use Livewire\Component;
use App\Models\Category;
use App\Models\Subsector;

class SingleForm extends Component
{
    public bool $singleForm = false;
    protected $listeners = ['showSingle'];

    public function render()
    {
        $categories = Category::all();
        $sectors = Sector::all();
        $subsectors = Subsector::all();
        return view('livewire.single-form', [
            'categories' => $categories,
            'sectors' => $sectors,
            'subsectors' => $subsectors,
        ]);
    }
    
    public function showSingle()
    {
        $this->singleForm = true;
    }
}
