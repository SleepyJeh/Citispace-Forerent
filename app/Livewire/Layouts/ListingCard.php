<?php

namespace App\Livewire\Layouts;

use Livewire\Component;

class ListingCard extends Component
{
    public string $title;
    public string $value;
    public ?string $subtitle = null;
    public string $bgColor = 'bg-gray-100';
    public string $textColor = 'text-gray-700';

    // New properties for the listing card
    public string $leaseType = 'Annually';
    public string $condition = 'Move-In Ready';
    public string $unitNumber = '';
    public string $address = '';
    public string $price = '';
    public string $vacantSince = '';
    public string $lostRevenue = '';

    public function mount(
        string $title = '',
        string $value = '',
        ?string $subtitle = null,
        string $bgColor = 'bg-gray-100',
        string $textColor = 'text-gray-700',
        string $leaseType = 'Annually',
        string $condition = 'Move-In Ready',
        string $unitNumber = '',
        string $address = '',
        string $price = '',
        string $vacantSince = '',
        string $lostRevenue = '₱ 0'
    ) {
        $this->title = $title;
        $this->value = $value;
        $this->subtitle = $subtitle;
        $this->bgColor = $bgColor;
        $this->textColor = $textColor;
        $this->leaseType = $leaseType;
        $this->condition = $condition;
        $this->unitNumber = $unitNumber;
        $this->address = $address;
        $this->price = $price;
        $this->vacantSince = $vacantSince;
        $this->lostRevenue = $lostRevenue;
    }

    public function getConditionBgColor(): string
    {
        return match ($this->condition) {
            'Move-In Ready' => 'bg-green-200',
            'Needs Repair' => 'bg-red-200',
            'Under Renovation' => 'bg-yellow-200',
            'Expiring Soon' => 'bg-red-100',
            default => 'bg-gray-200'
        };
    }

    public function getConditionTextColor(): string
    {
        return match ($this->condition) {
            'Move-In Ready' => 'text-green-800',
            'Needs Repair' => 'text-red-800',
            'Under Renovation' => 'text-yellow-800',
            'Expiring Soon' => 'text-red-800',
            default => 'text-gray-800'
        };
    }

    public function getConditionIcon(): string
    {
        if ($this->condition === 'Expiring Soon') {
            return '<svg width="13" height="14" viewBox="0 0 13 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.5 1L8.5 5L13 5.75L9.75 9L10.5 13.5L6.5 11.25L2.5 13.5L3.25 9L0 5.75L4.5 5L6.5 1Z"
                stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            </svg>';
        }

        return '<svg width="13" height="14" viewBox="0 0 13 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M8.52344 4.38938L9.89015 5.80682C10.0012 5.91973 10.1506 5.98298 10.3061 5.98298C10.4616 5.98298 10.611 5.91973 10.7221 5.80682L11.9699 4.51264C12.0788 4.39744 12.1398 4.24256 12.1398 4.08125C12.1398 3.91994 12.0788 3.76505 11.9699 3.64985L10.6032 2.23242" stroke="#066E17" stroke-width="0.96525" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M11.7905 1L6.08594 6.91624" stroke="#066E17" stroke-width="0.96525" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M3.76822 12.7092C5.57321 12.7092 7.03644 11.1917 7.03644 9.31969C7.03644 7.44771 5.57321 5.93018 3.76822 5.93018C1.96323 5.93018 0.5 7.44771 0.5 9.31969C0.5 11.1917 1.96323 12.7092 3.76822 12.7092Z" stroke="#066E17" stroke-width="0.96525" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>';
    }

    public function render()
    {
        return view('livewire.layouts.listingcard');
    }
}
