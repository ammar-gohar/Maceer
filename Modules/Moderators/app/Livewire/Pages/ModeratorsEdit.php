<?php

namespace Modules\Moderators\Livewire\Pages;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ModeratorsEdit extends Component
{

    public UserForm $form;

    #[Validate('bail|required|in:freshman,junior,senior-1,senior-2')]
    public $level;

    #[Validate('bail|required|decimal:1,2|min:0.00|max:4.00')]
    public $gpa;

    #[Validate('bail|required|integer|min:0|max:180')]
    public $earned_credits;

    public $status = false;

    public function mount(int $national_id)
    {
        $moderator = User::with(['moderator'])->where('national_id', $national_id)->firstOrFail();
        $this->level = $moderator->moderator->level;
        $this->gpa = $moderator->moderator->gpa;
        $this->earned_credits = $moderator->moderator->earned_credits;
        $this->form->fillVars($moderator);
    }

    public function update()
    {
        $data = $this->form->validate();

        $moderator = User::with(['moderator'])->findOrFail($this->form->id);

        $moderator->update($data);
        $moderator->moderator()->update([
            'level' => $this->level,
            'gpa' => $this->gpa,
            'earned_credits' => $this->earned_credits,
        ]);

        $this->status = true;

        return;

    }

    public function render()
    {
        return view('moderators::livewire.pages.moderators-edit');
    }
}
