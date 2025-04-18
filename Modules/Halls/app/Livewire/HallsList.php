<?php

namespace Modules\Halls\Livewire;

use Livewire\Component;
use Modules\Halls\Models\Hall;

class HallsList extends Component
{

    public $loop;

    public Hall $hall;

    public function render()
    {
        return view('halls::livewire.halls-list');
    }
}
