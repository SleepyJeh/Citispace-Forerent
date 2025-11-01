<?php

namespace App\Livewire\Layouts;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AddManagerModal extends Component
{
    use WithFileUploads;

    public $isOpen = false;
    public $modalId;

    public $profilePicture = null;
    public $firstName = '';
    public $lastName = '';
    public $phone = '';
    public $email = '';

    public $profilePicturePreview = null;

    protected function rules()
    {
        return [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'phone' => ['required', 'string', 'regex:/^9\d{9}$/'],
            'email' => 'required|email|max:255|unique:users,email',
            'profilePicture' => 'nullable|image|max:2048',
        ];
    }

    protected $messages = [
        'phone.regex' => 'Please enter a valid phone number starting with 9 (e.g., 9123456789)',
        'phone.required' => 'Phone number is required',
    ];

    public function mount($modalId = null)
    {
        $this->modalId = $modalId ?? uniqid('add_manager_modal_');
    }

    protected function getListeners()
    {
        return [
            "openAddManagerModal_{$this->modalId}" => 'open',
        ];
    }

    public function open()
    {
        $this->resetForm();
        $this->isOpen = true;
    }

    public function close()
    {
        $this->isOpen = false;
        $this->resetForm();
        $this->resetValidation();
    }

    public function updatedProfilePicture()
    {
        $this->validate([
            'profilePicture' => 'nullable|image|max:2048',
        ]);
    }

    public function save()
    {
        $this->validate();

        // Generate random password
        $password = Str::random(12);

        // Add +63 prefix to phone number for storage
        $fullPhoneNumber = '+63' . $this->phone;

        // Store profile picture if uploaded
        $profilePicturePath = null;
        if ($this->profilePicture) {
            $profilePicturePath = $this->profilePicture->store('profile-pictures', 'public');
        }

        $user = User::create([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'phone' => $fullPhoneNumber,
            'email' => $this->email,
            'password' => Hash::make($password),
            'profile_picture' => $profilePicturePath,
            'role' => 'manager',
        ]);

        session()->flash('message', 'Manager created successfully. Login credentials have been sent to their email.');

        $this->dispatch('managerCreated');
        $this->dispatch('refresh-manager-list');

        $this->close();
    }

    private function resetForm()
    {
        $this->firstName = '';
        $this->lastName = '';
        $this->phone = '';
        $this->email = '';
        $this->profilePicture = null;
        $this->profilePicturePreview = null;
    }

    public function render()
    {
        return view('livewire.layouts.add-manager-modal');
    }
}
