<?php

namespace App\Livewire\Layouts;

use App\Models\Announcement;
use App\Models\Property;
use App\Models\User;
use App\Notifications\NewAnnouncement;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class AnnouncementModal extends Component
{
    public $showModal = false;
    public $showConfirmation = false;
    public $headline = '';
    public $details = '';
    public $selectedProperty = '';

    public $properties = [];

    protected $rules = [
        'headline' => 'required|min:3|max:200',
        'details' => 'required|min:10|max:1000',
        'selectedProperty' => 'required',
    ];

    protected $messages = [
        'headline.required' => 'Please enter a headline for your announcement.',
        'details.required' => 'Please enter details for your announcement.',
        'selectedProperty.required' => 'Please select a property for your announcement.',
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

        $isAll = false;

        if ($this->selectedProperty === 'all') {
            $this->selectedProperty = null;
            $isAll = true;
        }

        $recipient_role = auth()->user()->role === 'manager' ? 'tenant' : 'manager';

        // Create announcement
        $announcement = Announcement::create([
            'author_id'      => auth()->id(),
            'title'          => $this->headline,
            'description'    => $this->details,
            'property_id'    => $this->selectedProperty,
            'recipient_role' => $recipient_role,
        ]);

        // Fetch properties based on sender role
        $query = Property::query();

        if (auth()->user()->role === 'landlord') {
            $query->where('owner_id', auth()->id());
        } elseif (auth()->user()->role === 'manager') {
            $query->whereHas('units', fn($q) => $q->where('manager_id', auth()->id()));
        }

        if (! $isAll) {
            $query->where('property_id', $this->selectedProperty);
        }

        // Determine recipients
        if ($recipient_role === 'manager') {
            $properties = $query->with('units.manager')->get();

            $recipients = $properties->flatMap(fn ($property) =>
            $property->units->pluck('manager')
            )->filter()->unique('user_id')->values();

        } else {
            $properties = $query->with('units.beds.leases.tenant')->get();

            $recipients = $properties->flatMap(fn ($property) =>
            $property->units
                ->flatMap(fn ($unit) =>
                $unit->beds
                    ->flatMap(fn ($bed) =>
                    $bed->leases->pluck('tenant')
                    )
                )
            )->filter()->unique('user_id')->values();
        }

        // Send notifications
        if ($recipients->isNotEmpty()) {
            Notification::send($recipients, new NewAnnouncement($announcement));
        }

        session()->flash('message', 'Announcement posted successfully!');
        $this->closeModal();
        $this->dispatch('announcement-posted');
    }

    public function mount()
    {
        $user = auth()->user();

        if ($user->role === 'landlord') {
            $this->properties = Property::where('owner_id', $user->id)
                ->with('units')
                ->get();
        } elseif ($user->role === 'manager') {
            $this->properties = Property::with('units')
                ->get()
                ->filter(fn ($property) =>
                $property->units->contains(fn ($unit) =>
                    $unit->manager_id === $user->id
                )
                )
                ->values();
        } else {
            $this->properties = collect();
        }

    }

    public function render()
    {
        return view('livewire.layouts.announcement-modal');
    }
}
