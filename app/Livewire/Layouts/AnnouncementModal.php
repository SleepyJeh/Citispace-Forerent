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
            // Fixed: Use property_id (the primary key stored in selectedProperty)
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

        // Send notifications asynchronously after response
        if ($recipients->isNotEmpty()) {
            dispatch(function () use ($recipients, $announcement) {
                // Process in chunks of 50 users to avoid memory issues
                $recipients->chunk(50)->each(function ($chunk) use ($announcement) {
                    Notification::send($chunk, new NewAnnouncement($announcement));
                });
            })->afterResponse();
        }

        session()->flash('message', 'Announcement posted successfully!');
        $this->closeModal();
        $this->dispatch('announcement-posted');
    }

    public function mount()
    {
        $user = auth()->user();

        if ($user->role === 'landlord') {
            // Get all properties owned by the landlord
            $this->properties = Property::where('owner_id', $user->user_id)
                ->with('units')
                ->get();
        } elseif ($user->role === 'manager') {
            // Get all properties where the manager manages at least one unit
            $this->properties = Property::whereHas('units', function($query) use ($user) {
                $query->where('manager_id', $user->user_id);
            })
                ->with('units')
                ->get();
        } else {
            $this->properties = collect();
        }
    }

    public function render()
    {
        return view('livewire.layouts.announcement-modal');
    }
}
