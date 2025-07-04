<?php

namespace App\Livewire\Components;

use Livewire\Component;

class ShowItem extends Component
{

    public $label;
    public $data;
    public $span = 6;

    public function render()
    {
        return view('livewire.components.show-item');
    }
}
