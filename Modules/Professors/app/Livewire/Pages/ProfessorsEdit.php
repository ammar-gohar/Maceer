<?php

namespace Modules\Professors\Livewire\Pages;

use Livewire\Component;

class ProfessorsEdit extends Component
{
    public function render()
    {
        return view('professors::livewire.pages.professors-edit')->title(__('sidebar.professors.edit'));
    }
}
