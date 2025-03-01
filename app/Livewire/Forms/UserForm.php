<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{

    public $id;

    public $first_name;

    public $middle_name;

    public $last_name;

    public $national_id;

    public $phone;

    public $email;

    public $gender = '';

    public function rules()
    {
        return [
            'first_name'  => 'bail|required|string|max:50',
            'middle_name' => 'bail|required|string|max:50',
            'last_name'   => 'bail|required|string|max:50',
            'national_id' => 'bail|required|digits:14|integer|regex:/[0-9]/|unique:users,national_id,' . $this->id ?? '',
            'phone'       => 'bail|required|digits:11|regex:/[0-9]/|unique:users,phone,' . $this->id ?? '',
            'email'       => 'bail|required|email|max:255|unique:users,email,' . $this->id ?? '',
            'gender'      => 'bail|required|string|in:m,f',
        ];
    }

    public function fillVars(User $user)
    {
        $this->id = $user->id;
        $this->first_name = $user->first_name;
        $this->middle_name = $user->middle_name;
        $this->last_name = $user->last_name;
        $this->national_id = $user->national_id;
        $this->phone = $user->phone;
        $this->email = $user->email;
        $this->gender = $user->gender;
    }

}
