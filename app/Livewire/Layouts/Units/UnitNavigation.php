<?php

namespace App\Livewire\Layouts\Units;
use Livewire\Component;
use Illuminate\Support\Collection;

class UnitNavigation extends Component
{
    /**
     * MODIFIED: This will hold the MASTER list of all units.
     * @var Collection
     */
    public Collection $allUnits;

    /**
     * MODIFIED: This will now hold the FILTERED list of units.
     * @var Collection
     */
    public Collection $units;

    /**
     * The ID of the currently selected unit.
     * @var int|null
     */
    public $activeUnitId = null;

    /**
     * The currently selected gender tab.
     * @var string
     */
    public string $activeGender = 'female'; // Default to 'female'

    // --- Pagination Properties ---
    public int $currentPage = 1;
    public int $itemsPerPage = 15;
    public int $totalPages;
    // ---------------------------

    /**
     * This method runs when the component is first initialized.
     */
    public function mount()
    {
        /**
         * MODIFIED:
         * 1. Populate the master $allUnits list.
         * 2. Added 'gender' property to each unit for filtering.
         */
        $this->allUnits = collect([
            ['id' => 1, 'name' => 'UNIT 1', 'gender' => 'female'],
            ['id' => 2, 'name' => 'UNIT 2', 'gender' => 'male'],
            ['id' => 3, 'name' => 'UNIT 3', 'gender' => 'female'],
            ['id' => 4, 'name' => 'UNIT 4', 'gender' => 'male'],
            ['id' => 5, 'name' => 'UNIT 5', 'gender' => 'female'],
            ['id' => 6, 'name' => 'UNIT 6', 'gender' => 'female'],
            ['id' => 7, 'name' => 'UNIT 7', 'gender' => 'male'],
            ['id' => 8, 'name' => 'UNIT 8', 'gender' => 'female'],
            ['id' => 9, 'name' => 'UNIT 9', 'gender' => 'male'],
            ['id' => 10, 'name' => 'UNIT 10', 'gender' => 'female'],
            ['id' => 11, 'name' => 'UNIT 11', 'gender' => 'female'],
            ['id' => 12, 'name' => 'UNIT 12', 'gender' => 'male'],
            ['id' => 13, 'name' => 'UNIT 13', 'gender' => 'female'],
            ['id' => 14, 'name' => 'UNIT 14', 'gender' => 'male'],
            ['id' => 15, 'name' => 'UNIT 15', 'gender' => 'female'],
            ['id' => 16, 'name' => 'UNIT 16', 'gender' => 'male'],
            ['id' => 17, 'name' => 'UNIT 17', 'gender' => 'female'],
            ['id' => 18, 'name' => 'UNIT 18', 'gender' => 'male'],
            ['id' => 19, 'name' => 'UNIT 19', 'gender' => 'female'],
            ['id' => 20, 'name' => 'UNIT 20', 'gender' => 'male'],
        ]);

        // MODIFIED: Perform the initial filter based on the default activeGender
        $this->filterUnits();
    }

    /**
     * NEW: Helper function to filter units based on $activeGender
     */
    private function filterUnits()
    {
        // Filter the master list and re-index the collection
        $this->units = $this->allUnits->where('gender', $this->activeGender)->values();

        // Recalculate total pages for the filtered list
        $this->totalPages = (int) ceil($this->units->count() / $this->itemsPerPage);

        // Reset pagination to page 1
        $this->currentPage = 1;

        // Get the first unit from the *newly filtered* list
        $firstUnit = $this->units->first();

        // Set the active unit ID
        $this->activeUnitId = $firstUnit ? $firstUnit['id'] : null;

        // Dispatch an event to update the UnitDetail component
        // Send 0 or null if the list is empty, getUnitById() in UnitDetail will handle it.
        $this->dispatch('unitSelected', unitId: $this->activeUnitId ?? 0);
    }

    /**
     * Sets the clicked unit as the active one.
     */
    public function selectUnit(int $unitId)
    {
        $this->activeUnitId = $unitId;
        $this->dispatch('unitSelected', unitId: $unitId);
    }

    /**
     * MODIFIED: This method now triggers the filtering logic.
     */
    public function selectGender(string $gender)
    {
        $this->activeGender = $gender;

        // Call the new helper function to re-filter the list
        $this->filterUnits();
    }

    // --- Pagination Methods (Unchanged) ---

    /**
     * Go to a specific page.
     */
    public function gotoPage(int $page)
    {
        // Ensure page is within valid range
        $page = max(1, min($page, $this->totalPages));
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
     */
    public function render()
    {
        // MODIFIED: Paginate the *filtered* $this->units collection
        $paginatedUnits = $this->units->skip(($this->currentPage - 1) * $this->itemsPerPage)
            ->take($this->itemsPerPage);

        return view('livewire.layouts.units.unit-navigation', [
            'paginatedUnits' => $paginatedUnits
        ]);
    }
}
