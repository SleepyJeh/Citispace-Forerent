<?php

namespace App\Livewire\Layouts;

use Livewire\Component;

class TopBar extends Component
{
    public $searchQuery = '';

    public function updatedSearchQuery()
    {
        // Emit event when search query changes
        $this->dispatch('search-updated', search: $this->searchQuery);
    }

    public function clearSearch()
    {
        $this->searchQuery = '';
        $this->dispatch('search-updated', search: '');
    }

    public function render()
    {
        return view('livewire.layouts.top-bar');
    }
}
