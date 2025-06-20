<?php

namespace Modules\Moderators\Livewire\Pages;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ModeratorsEdit extends Component
{

    public UserForm $form;

    public $status = false;

    public function mount(int $national_id)
    {
        $moderator = User::with(['moderator'])->where('national_id', $national_id)->firstOrFail();
        $this->form->fillVars($moderator);
    }

    public function update()
    {
        $data = $this->form->validate();

        $moderator = User::with(['moderator'])->findOrFail($this->form->id);

        $moderator->update($data);

        $this->status = true;

        return;

    }

    public function render()
    {
        return view('moderators::livewire.pages.moderators-edit');
    }
}
