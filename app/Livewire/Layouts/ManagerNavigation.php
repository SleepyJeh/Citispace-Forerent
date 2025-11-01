<?php

namespace App\Livewire\Layouts;

use Livewire\Component;
use Livewire\Attributes\On;

class ManagerNavigation extends Component
{
    /**
     * @var array
     */
    public array $managers;

    /**
     * @var int|null
     */
    public $activeManagerId = null;

    public function mount()
    {
        $this->loadManagers();
    }


    public function loadManagers()
    {

        $this->managers = [
            ['id' => 1, 'name' => 'Ninole Candelaria'],
            ['id' => 2, 'name' => 'Conrad Rivera'],
            ['id' => 3, 'name' => 'Conrad Rivera'],
            ['id' => 4, 'name' => 'Ninole Candelaria'],
            ['id' => 5, 'name' => 'Ninole Candelaria'],
            ['id' => 6, 'name' => 'Conrad Rivera'],
        ];

        if (count($this->managers) > 0 && $this->activeManagerId === null) {
            $this->activeManagerId = $this->managers[0]['id'];
        }
    }


    #[On('refresh-manager-list')]
    public function refreshManagerList()
    {
        $this->loadManagers();
    }

    /**
     *
     * @param int $managerId
     * @return void
     */
    public function selectManager(int $managerId)
    {
        $this->activeManagerId = $managerId;

        $this->dispatch('managerSelected', managerId: $managerId);
    }

    public function render()
    {
        return view('livewire.layouts.manager-navigation');
    }
}
