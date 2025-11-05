<?php

namespace App\Livewire\Forms;

use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AddUserForm extends Form
{
    public $firstName = '';
    public $lastName = '';
    public $phoneNumber = '';
    public $email = '';

    /** Track if editing (used for unique rule exceptions) */
    public ?int $userId = null;

    /**
     * ✅ Dynamic validation rules (Livewire 3 reads rules())
     */
    public function rules(): array
    {
        return [
            'firstName' => 'required|string|min:2|max:50',
            'lastName' => 'required|string|min:2|max:50',
            'phoneNumber' => [
                'required',
                'regex:/^[0-9]{10}$/',
                Rule::unique('users', 'contact')
                    ->ignore($this->userId, 'user_id')
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
                    ->ignore($this->userId, 'user_id')
            ],
        ];
    }

    /**
     * ✅ Custom error messages (Livewire 3 reads messages())
     */
    public function messages(): array
    {
        return [
            'firstName.required' => 'First name is required.',
            'firstName.min' => 'First name must be at least 2 characters.',
            'firstName.max' => 'First name must not exceed 50 characters.',
            'lastName.required' => 'Last name is required.',
            'lastName.min' => 'Last name must be at least 2 characters.',
            'lastName.max' => 'Last name must not exceed 50 characters.',
            'phoneNumber.required' => 'Phone number is required.',
            'phoneNumber.regex' => 'Phone number must be exactly 10 digits.',
            'phoneNumber.unique' => 'This phone number is already registered.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
        ];
    }

    /**
     * ✅ Custom attribute names for cleaner error messages
     */
    public function validationAttributes(): array
    {
        return [
            'firstName' => 'first name',
            'lastName' => 'last name',
            'phoneNumber' => 'phone number',
            'email' => 'email address',
        ];
    }
}
