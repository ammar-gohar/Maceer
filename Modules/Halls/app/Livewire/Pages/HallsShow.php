<?php

namespace Modules\Halls\Livewire\Pages;

use Livewire\Component;
use Modules\Halls\Models\Hall;

class HallsShow extends Component
{

    public Hall $hall;

    public function mount(string $id)
    {
        $this->hall = Hall::findOrFail($id);
    }

    public function render()
    {
        return view('halls::livewire.pages.halls-show')->title($this->hall->name);
    }
}
