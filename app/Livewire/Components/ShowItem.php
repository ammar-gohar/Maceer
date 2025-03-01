<?php

namespace App\Livewire\Components;

use Livewire\Component;

class ShowItem extends Component
{

    public $label;
    public $data;

    public function render()
    {
        return view('livewire.components.show-item');
    }
}
