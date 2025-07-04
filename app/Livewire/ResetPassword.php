<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password as FacadesPassword;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ResetPassword extends Component
{

    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public function rules()
    {
        return [
            'current_password' => ['bail', 'required', 'string', 'password'],
            'new_password' => ['bail', 'required', 'string', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ];
    }

    public function reset_password()
    {
        $data = $this->validate();

        Auth::user()->update([
            'password' => Hash::make($data['new_password']),
        ]);

        return notyf()->success(__('forms.password_reseted'));

    }

    public function render()
    {
        return view('livewire.reset-password');
    }
}
