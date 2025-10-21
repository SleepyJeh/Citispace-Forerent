<?php

namespace App\Livewire\Layouts;

use Livewire\Component;
use Illuminate\Support\Collection;

class UnitNavigation extends Component
{
    /**
     * A collection of units to display in the navigation.
     * @var Collection
     */
    public Collection $units;

    /**
     * The ID of the currently selected unit.
     * @var int|null
     */
    public $activeUnitId = null;

    // --- Pagination Properties ---
    public int $currentPage = 1;

    /**
     * MODIFIED:
     * I've increased the items per page to 15.
     * This will force the list to be long enough to
     * activate the scrollbar in your h-[750px] container.
     */
    public int $itemsPerPage = 15; // Was 6

    public int $totalPages;
    // ---------------------------

    /**
     * This method runs when the component is first initialized.
     */
    public function mount()
    {
        /**
         * MODIFIED:
         * I've added more units (up to 20) to ensure
         * the list is long and that pagination still appears.
         */
        $this->units = collect([
            ['id' => 1, 'name' => 'UNIT 1'],
            ['id' => 2, 'name' => 'UNIT 2'],
            ['id' => 3, 'name' => 'UNIT 3'],
            ['id' => 4, 'name' => 'UNIT 4'],
            ['id' => 5, 'name' => 'UNIT 5'],
            ['id' => 6, 'name' => 'UNIT 6'],
            ['id' => 7, 'name' => 'UNIT 7'],
            ['id' => 8, 'name' => 'UNIT 8'],
            ['id' => 9, 'name' => 'UNIT 9'],
            ['id' => 10, 'name' => 'UNIT 10'],
            ['id' => 11, 'name' => 'UNIT 11'],
            ['id' => 12, 'name' => 'UNIT 12'],
            ['id' => 13, 'name' => 'UNIT 13'],
            ['id' => 14, 'name' => 'UNIT 14'], // <-- Added
            ['id' => 15, 'name' => 'UNIT 15'], // <-- Added
            ['id' => 16, 'name' => 'UNIT 16'], // <-- Added
            ['id' => 17, 'name' => 'UNIT 17'], // <-- Added
            ['id' => 18, 'name' => 'UNIT 18'], // <-- Added
            ['id' => 19, 'name' => 'UNIT 19'], // <-- Added
            ['id' => 20, 'name' => 'UNIT 20'], // <-- Added
        ]);

        // Calculate total pages
        $this->totalPages = (int) ceil($this->units->count() / $this->itemsPerPage);

        // Set the first unit as active by default if the list is not empty
        if ($this->units->isNotEmpty()) {
            $this->activeUnitId = $this->units->first()['id'];
        }
    }

    /**
     * Sets the clicked unit as the active one.
     *
     * @param int $unitId
     * @return void
     */
    public function selectUnit(int $unitId)
    {
        $this->activeUnitId = $unitId;
        $this->dispatch('unitSelected', unitId: $unitId);
    }

    // --- Pagination Methods ---

    /**
     * Go to a specific page.
     */
    public function gotoPage(int $page)
    {
        // Add boundary checks
        if ($page < 1) {
            $page = 1;
        } elseif ($page > $this->totalPages) {
            $page = $this->totalPages;
        }
        $this->currentPage = $page;
    }

    /**
     * Go to the next page.
     */
    public function nextPage()
    {
        $this->gotoPage($this->currentPage + 1);
    }

    /**
     * Go to the previous page.
     */
    public function previousPage()
    {
        $this->gotoPage($this->currentPage - 1);
    }
    // --------------------------

    /**
     * Renders the component's view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // Paginate the units collection
        $paginatedUnits = $this->units->skip(($this->currentPage - 1) * $this->itemsPerPage)
            ->take($this->itemsPerPage);

        return view('livewire.layouts.unit-navigation', [
            'paginatedUnits' => $paginatedUnits
        ]);
    }
}
