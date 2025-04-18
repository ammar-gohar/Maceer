<?php

namespace Modules\Halls\Livewire\Pages;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Modules\Halls\Models\Hall;

class HallsEdit extends Component
{

    public Hall $hall;

    #[Validate('bail|required|string')]
    public $name;

    #[Validate('bail|required|string')]
    public $building;

    #[Validate('bail|required|string')]
    public $floor;

    #[Validate('bail|required|integer|min:0')]
    public $capacity;

    #[Validate('bail|required|in:theatre,lab')]
    public $type;

    #[Validate('bail|required|in:available,under_maintenance,reserved')]
    public $status;


    public function mount(string $id)
    {
        $hall = Hall::findOrFail($id);
        $this->hall = $hall;
        $this->name = $hall->name;
        $this->building = $hall->building;
        $this->floor = $hall->floor;
        $this->capacity = $hall->capacity;
        $this->type = $hall->type;
        $this->status = $hall->status;
    }

    public function resetBtn()
    {
        $this->name = $this->hall->name;
        $this->building = $this->hall->building;
        $this->floor = $this->hall->floor;
        $this->capacity = $this->hall->capacity;
        $this->type = $this->hall->type;
        $this->status = $this->hall->status;
    }

    public function update()
    {
        $data = $this->validate();

        $this->hall->update($data);

        notyf()->success(__('modules.halls.success.update'));
    }

    public function render()
    {
        return view('halls::livewire.pages.halls-edit')->title($this->hall->name . ' - ' . __('modules.halls.edit'));
    }
}
