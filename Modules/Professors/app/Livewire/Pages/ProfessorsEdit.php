<?php

namespace Modules\Professors\Livewire\Pages;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ProfessorsEdit extends Component
{
    public UserForm $form;

    public $status = false;

    public function mount(int $national_id)
    {
        $professor = User::with(['professor'])->where('national_id', $national_id)->firstOrFail();
        $this->form->fillVars($professor);
    }

    public function update()
    {
        $data = $this->form->validate();

        $professor = User::with(['professor'])->findOrFail($this->form->id);

        $professor->update($data);

        $this->status = true;

        return;

    }
    public function render()
    {
        return view('professors::livewire.pages.professors-edit')->title(__('sidebar.professors.edit'));
    }
}
