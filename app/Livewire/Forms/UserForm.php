<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    #[Validate('bail|required|string|max:50|regex:/[A-z]/')]
    public $first_name;

    #[Validate('bail|required|string|max:50|regex:/[A-z]/')]
    public $middle_name;

    #[Validate('bail|required|string|max:50|regex:/[A-z]/')]
    public $last_name;

    #[Validate('bail|required|digits:14|unique:users,national_id|integer|regex:/[0-9]/')]
    public $national_id;

    #[Validate('bail|required|digits:11|unique:users,phone|regex:/[0-9]/')]
    public $phone;

    #[Validate('bail|required|email|max:255|unique:users,email')]
    public $email;

    #[Validate('bail|required|string|in:m,f')]
    public $gender = 'm';

}
