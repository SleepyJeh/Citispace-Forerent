<?php

namespace App\Livewire\Layouts;

use Livewire\Component;

class AnnouncementModal extends Component
{
    public $showModal = false;
    public $showConfirmation = false;
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
        $this->showConfirmation = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->headline = '';
        $this->details = '';
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();
        $this->showConfirmation = true;
    }

    public function cancelConfirmation()
    {
        $this->showConfirmation = false;
    }

    public function confirmPost()
    {
        $this->validate();

        // Save to database
        // Announcement::create([
        //     'headline' => $this->headline,
        //     'details' => $this->details,
        //     'posted_at' => now(),
        // ]);

        session()->flash('message', 'Announcement posted successfully!');

        $this->closeModal();
        $this->dispatch('announcement-posted');
    }

    public function render()
    {
        return view('livewire.layouts.announcement-modal');
    }
}
