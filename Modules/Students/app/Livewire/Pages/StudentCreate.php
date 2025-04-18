<?php

namespace Modules\Students\Livewire\Pages;

use App\Livewire\Forms\UserForm;
use App\Mail\SendingPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Validate;
use Livewire\Component;

class StudentCreate extends Component
{

    public UserForm $form;

    #[Validate('bail|required|in:freshman,junior,senior-1,senior-2')]
    public $level = 'freshman';

    #[Validate('bail|required|decimal:0,2|min:0.00|max:4.00')]
    public $gpa = 0.00;

    #[Validate('bail|required|integer|min:0|max:180')]
    public $earned_credits = 0;

    public $status = false;

    public function store()
    {
        $data = $this->form->validate();
        $password = \Illuminate\Support\Str::password(12);
        $data['password'] = Hash::make($password);

        $student = User::create($data);
        $student->assignRole('student');
        $student->student()->create([
            'level' => $this->level,
            'gpa' => $this->gpa,
        ]);

        Mail::to($student->email)->queue(new SendingPassword($data['first_name'] . ' ' . $data['last_name'], $password))->onQueue('emails');

        notyf()->success(__('modules.students.success.store'));

    }

    public function render()
    {
        return view('students::livewire.pages.student-create')->title(__('modules.students.create'));
    }
}
