<?php

namespace App\Livewire\Layouts\Dashboard;

use Livewire\Component;

class AnnouncementList extends Component
{
    public $announcements = [];
    public $isLandlord = false; 

    public function mount($isLandlord = false)
    {
        $this->isLandlord = $isLandlord;

        $this->announcements = [
            [
                'date' => 'October 1, 2025',
                'title' => 'Rent Increase Notification',
                'description' => 'This is a notification that the monthly rent for all units will be increased effective December 1, 2025.'
            ],
            [
                'date' => 'October 15, 2025',
                'title' => 'Maintenance Scheduled',
                'description' => 'Regular maintenance checks for all units.'
            ]
        ];
    }

    public function render()
    {
        return view('livewire.layouts.dashboard.announcement-list');
    }
}
