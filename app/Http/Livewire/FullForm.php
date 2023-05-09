<?php

namespace App\Http\Livewire;

use App\Models\Sector;
use Livewire\Component;
use App\Models\Category;
use App\Models\Subsector;

class FullForm extends Component
{
    public function render()
    {
        $categories = Category::all();
        $sectors = Sector::all();
        $subsectors = Subsector::all();
        return view('livewire.full-form', [
            'categories' => $categories,
            'sectors' => $sectors,
            'subsectors' => $subsectors,
        ]);
    }
}
