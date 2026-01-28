<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AddUserForm extends Form
{
    public $firstName = '';
    public $lastName = '';
    public $phoneNumber = '';
    public $email = '';

    public ?int $userId = null;

    public function rules(): array
    {
        return [
            'firstName' => 'required|string|min:2|max:50',
            'lastName' => 'required|string|min:2|max:50',
            'phoneNumber' => [
                'required',
                'regex:/^[0-9]{10,11}$/',
                Rule::unique('users', 'contact')->ignore($this->userId, 'user_id')
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->userId, 'user_id')
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'firstName.required' => 'First name is required.',
            'phoneNumber.unique' => 'This phone number is already registered.',
            'email.unique' => 'This email address is already registered.',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'firstName' => 'first name',
            'lastName' => 'last name',
            'phoneNumber' => 'phone number',
            'email' => 'email address',
        ];
    }

    public function setUser(User $user)
    {
        $this->userId = $user->user_id;  
        $this->firstName = $user->first_name;
        $this->lastName = $user->last_name;
        $this->phoneNumber = $user->contact;
        $this->email = $user->email;
    }

    public function store($role = 'manager')
    {
        $this->validate();

        return User::create([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'contact' => $this->phoneNumber,
            'email' => $this->email,
            'role' => $role,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }

    public function update(User $user)
    {
        $this->validate();

        $user->update([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'contact' => $this->phoneNumber,
            'email' => $this->email,
        ]);

        return $user;
    }
}
