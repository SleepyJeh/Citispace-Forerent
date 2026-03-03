<?php

namespace App\Livewire\Actions;

use App\Enums\Role;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;



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

    public function mount()
    {
        if (Cookie::has('email')) {
            $this->email = Cookie::get('email');
            $this->remember = true; // Auto-check the box
        }
    }

    public function login()
    {
        $this->validate();

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials, $this->remember)) {
            // Store email in cookie for 30 days if "remember me" is checked
            if ($this->remember) {
                Cookie::queue('email', $this->email, 43200); // 43200 minutes = 30 days
            } else {
                Cookie::queue(Cookie::forget('email'));
            }

            session()->flash('success', 'Login successful!');

            $role = auth()->user()->role;
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
