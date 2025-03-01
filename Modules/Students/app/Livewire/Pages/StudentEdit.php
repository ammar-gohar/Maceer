<?php

namespace Modules\Students\Livewire\Pages;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;

class StudentEdit extends Component
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
        $student = User::with(['student'])->where('national_id', $national_id)->firstOrFail();
        $this->level = $student->student->level;
        $this->gpa = $student->student->gpa;
        $this->earned_credits = $student->student->earned_credits;
        $this->form->fillVars($student);
    }

    public function update()
    {
        $data = $this->form->validate();

        $student = User::with(['student'])->findOrFail($this->form->id);

        $student->update($data);
        $student->student()->update([
            'level' => $this->level,
            'gpa' => $this->gpa,
            'earned_credits' => $this->earned_credits,
        ]);

        $this->status = true;

        return;

    }

    public function render()
    {
        return view('students::livewire.pages.student-edit');
    }
}
