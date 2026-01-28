<div class="w-full min-h-full">
    {{-- Welcome Banner --}}
    <div class="mb-6 bg-gradient-to-r from-[#070642] to-[#1e3a8a] rounded-2xl p-8 shadow-lg">
        <h2 class="text-white text-2xl font-semibold">Hello, {{ auth()->user()->name ?? 'Adam' }}!</h2>
    </div>

    {{-- Dynamic Content Switcher --}}
    @if($currentView === 'reports')
        <livewire:layouts.financials.revenue-reports />

        @elseif($currentView === 'records')
        <livewire:layouts.financials.revenue-records />
    @endif
</div>
