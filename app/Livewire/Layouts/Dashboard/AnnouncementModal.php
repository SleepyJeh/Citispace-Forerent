<?php

namespace App\Livewire\Layouts\Dashboard;

use Livewire\Component;

class AnnouncementModal extends Component
{
    public $showModal = false;
    // Removed: public $showConfirmation = false; (No longer needed)

    public $headline = '';
    public $details = '';

    protected $rules = [
        'headline' => 'required|min:3|max:200',
        'details' => 'required|min:10|max:1000',
    ];

    protected $messages = [
        'headline.required' => 'Please enter a headline for your announcement.',
        'details.required' => 'Please enter details for your announcement.',
    ];

    protected $listeners = ['open-announcement-modal' => 'openModal'];

    public function openModal()
    {
        $this->showModal = true;
        $this->resetForm();
    }

    public function closeModal()
    {
        $this->showModal = false;
        // Removed: $this->showConfirmation = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->headline = '';
        $this->details = '';
        $this->resetValidation();
    }

    // This is the final action called by the <x-ui.modal-confirm> component
    public function confirmPost()
    {
        $this->validate();

        // Save logic (Example)
        // Announcement::create([...]);

        session()->flash('message', 'Announcement posted successfully!');

        $this->closeModal();
        $this->dispatch('announcement-posted');
    }

    public function render()
    {
        return view('livewire.layouts.dashboard.announcement-modal');
    }
}
