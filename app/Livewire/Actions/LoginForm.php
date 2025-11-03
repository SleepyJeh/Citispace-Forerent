<?php

namespace App\Livewire\Actions;

use App\Enums\Role;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;


class LoginForm extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function updated($propertyName)
    {
        // Real-time validation
        $this->validateOnly($propertyName);
    }

    public function login()
    {
        $this->validate();

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials, $this->remember)) {
            session()->flash('success', 'Login successful!');

            $role = auth()->user()->role;

            // Check the role of user and redirect them to respective
            return match ($role) {
                Role::Landlord->value => redirect()->route('landlord.dashboard'),
                Role::Manager->value => redirect()->route('manager.dashboard'),
                Role::Tenant->value => redirect()->route('tenant.dashboard'),
                default => redirect()->route('landing.home'),
            };
        }

        session()->flash('error', 'Invalid email or password.');
    }
    public function render()
    {
        return view('livewire.forms.login');
    }
}
