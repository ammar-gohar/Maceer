<?php

namespace Modules\Moderators\Livewire\Pages;

use App\Livewire\Forms\UserForm;
use App\Mail\SendingPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Modules\Levels\Models\Level;

class ModeratorsCreate extends Component
{

    public UserForm $form;

    public function store()
    {
        $data = $this->form->validate();
        $password = \Illuminate\Support\Str::password(12);
        $data['password'] = Hash::make($password);
        $data['username'] = $this->form->last_name . '.' . $this->form->first_name . random_int(001, 999);

        $moderator = User::create($data);
        $moderator->assignRole('staff');
        $moderator->moderator()->create();

        Mail::to($moderator->email)->queue((new SendingPassword($data['first_name'] . ' ' . $data['last_name'], $password))->onQueue('emails'));

        $this->reset();

        notyf()->success(__('modules.moderators.success.store'));

    }

    public function render()
    {
        return view('moderators::livewire.pages.moderators-create')
                ->title(__('sidebar.moderators.create'));
    }
}
