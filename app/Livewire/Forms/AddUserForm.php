<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class AddUserForm extends Form
{
    #[Validate('required|string|min:2|max:50')]
    public $firstName = '';

    #[Validate('required|string|min:2|max:50')]
    public $lastName = '';

    #[Validate('required|regex:/^\+63[0-9]{10}$/|unique:user,contact')]
    public $phoneNumber = '';

    #[Validate('required|email|unique:users,email')]
    public $email = '';
}
