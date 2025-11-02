<div class="w-full min-h-full">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div class="flex flex-col">
            <span class="text-2xl md:text-3xl text-blue-900 font-bold">REVENUE</span>
            <span class="text-sm md:text-base text-gray-600">Track and manage property income</span>
        </div>
    </div>

    {{-- Welcome Banner --}}
    <div class="mb-6 bg-gradient-to-r from-[#070642] to-[#1e3a8a] rounded-2xl p-8 shadow-lg">
        <h2 class="text-white text-2xl font-semibold">Hello, {{ auth()->user()->name ?? 'Adam' }}!</h2>
    </div>

    {{-- Dynamic Content Switcher --}}
    @if($currentView === 'reports')
        <livewire:layouts.revenue-reports />
    @elseif($currentView === 'records')
        <livewire:layouts.revenue-records />
    @endif
</div>
