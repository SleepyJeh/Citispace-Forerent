<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout; // 1. Import this

class ForgotPassword extends Component
{
    public $email = '';
    public $status = null;

    public function sendResetLink()
    {
        $this->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            $this->status = __($status);
            session()->flash('success', 'We have emailed your password reset link.');
            $this->email = '';
        } else {
            $this->addError('email', __($status));
        }
    }

    // 2. Use the #[Layout] attribute OR the ->layout() method.
    // This is the cleanest way in Livewire 3.
    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
