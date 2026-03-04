<div class="w-full min-h-full">
    {{-- Dynamic Content Switcher --}}
    @if($currentView === 'reports')
    <livewire:layouts.financials.revenue-reports />
    <livewire:layouts.revenue-forecast />
    <livewire:layouts.maint-forecast />

    @elseif($currentView === 'records')
    <livewire:layouts.financials.revenue-records />
    @endif
</div>