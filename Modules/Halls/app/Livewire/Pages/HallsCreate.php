<?php

namespace Modules\Halls\Livewire\Pages;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Modules\Halls\Models\Hall;

class HallsCreate extends Component
{

    #[Validate('bail|required|string')]
    public $name;

    #[Validate('bail|required|string')]
    public $building;

    #[Validate('bail|required|string')]
    public $floor;

    #[Validate('bail|required|integer|min:0')]
    public $capacity;

    #[Validate('bail|required|in:theatre,lab')]
    public $type = 'theatre';

    #[Validate('bail|required|in:available,under_maintenance,reserved')]
    public $status = 'available';


    public function store()
    {
        $data = $this->validate();

        Hall::create($data);

        notyf()->success(__('modules.halls.success.store'));

        $this->reset();
    }

    public function render()
    {
        return view('halls::livewire.pages.halls-create')->title(__('modules.halls.create'));
    }
}
