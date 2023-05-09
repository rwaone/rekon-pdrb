<?php

namespace App\Http\Livewire;

use App\Models\Sector;
use Livewire\Component;
use App\Models\Category;
use App\Models\Subsector;

class SingleForm extends Component
{
    public $view = 'livewire.single-form';

    protected $listeners = ['showForm'];

    public function render()
    {
        $categories = Category::all();
        $sectors = Sector::all();
        $subsectors = Subsector::all();
        return view( $this->view, [
            'categories' => $categories,
            'sectors' => $sectors,
            'subsectors' => $subsectors,
        ]);
    }

    public function showForm($formType)
    {
        ($formType == 'F') ? $this->view = 'livewire.full-form' : $this->view = 'livewire.single-form';
    }
}
