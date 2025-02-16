<?php

namespace Modules\Students\Livewire\Pages;

use App\Livewire\Forms\UserForm;
use App\Mail\SendingPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class StudentsCreate extends Component
{

    public UserForm $form;

    public $status = false;

    public function create_student()
    {
        $data = $this->form->validate();
        $password = \Illuminate\Support\Str::password(12);
        $data['password'] = Hash::make($password);

        $student = User::create($data);
        $student->assignRole('student');

        Mail::to($student->email)->send(new SendingPassword($data['first_name'] . ' ' . $data['last_name'], $password));

        $this->status = true;

        return;

    }

    public function render()
    {
        return view('students::livewire.pages.students-create');
    }
}
