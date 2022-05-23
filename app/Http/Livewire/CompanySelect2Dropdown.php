<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Companies;

class CompanySelect2Dropdown extends Component
{
    public $CompanyData = Companies::all();
    public function render()
    {
        return view('livewire.company-select2-dropdown');
    }
}
