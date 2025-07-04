<?php

namespace Modules\Reports\Livewire\Pages;

use Livewire\Component;

class GpaCalculator extends Component
{
    public function render()
    {
        return view('reports::livewire.pages.gpa-calculator')->title(__('modules.reports.gpa_calculator'));
    }
}
