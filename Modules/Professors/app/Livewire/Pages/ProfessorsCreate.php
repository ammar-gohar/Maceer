<?php

namespace Modules\Professors\Livewire\Pages;

use App\Livewire\Forms\UserForm;
use App\Mail\SendingPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Modules\Levels\Models\Level;

class ProfessorsCreate extends Component
{
    public UserForm $form;

    public function store()
    {
        $data = $this->form->validate();
        $password = \Illuminate\Support\Str::password(12);
        $data['password'] = Hash::make($password);
        $data['username'] = $this->form->last_name . '.' . $this->form->first_name . random_int(001, 999);

        $professor = User::create($data);
        $professor->assignRole('professor');
        $professor->professor()->create();

        Mail::to($professor->email)->queue((new SendingPassword($data['first_name'] . ' ' . $data['last_name'], $password))->onQueue('emails'));

        notyf()->success(__('modules.professors.success.store'));

        $this->reset();

        return;

    }

    public function reset_inputs()
    {
        return $this->reset();
    }

    public function render()
    {
        return view('professors::livewire.pages.professors-create')->title(__('sidebar.professors.create'));
    }
}
