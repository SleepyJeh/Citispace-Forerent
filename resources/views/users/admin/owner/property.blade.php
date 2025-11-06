@extends ('layouts.app')

@section('content')
    <div class="flex flex-row h-screen overflow-hidden">
        <nav class="w-0 md:w-64 flex-shrink-0 h-full overflow-y-auto bg-white">
            <livewire:navbars.side-bar />
        </nav>

        <section id="main-container" class="flex-1 h-full flex flex-col overflow-hidden">
            <div class="flex-shrink-0 bg-white z-30">
                <livewire:layouts.top-bar />
            </div>

            <div class="flex-1 overflow-y-auto ml-8">
                <div id="manager-container" class="w-full min-h-full rounded-tl-4xl bg-[#F4F7FC] flex flex-col px-4 md:px-8 lg:px-18 pt-9 pb-16 gap-6">

                    {{-- Header Section --}}
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="flex flex-col">
                            <span class="header-title text-2xl md:text-3xl text-blue-900 font-bold">PROPERTY MANAGEMENT</span>
                            <span class="sub-header text-sm md:text-base text-gray-600">View and record property or unit</span>
                        </div>
                    </div>

                    {{-- Admin Greeting --}}
                    @include('livewire.layouts.admingreeting')

                    {{-- Success Message --}}
                    @if (session()->has('message'))
                        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg relative" role="alert">
                            <span class="block sm:inline">{{ session('message') }}</span>
                        </div>
                    @endif

                    {{-- Main Content Grid: 70% Content + 30% Sidebar --}}
                    <div class="flex flex-col lg:flex-row gap-6">

                        {{-- Left Column: 70% --}}
                        <div class="w-full lg:w-[70%] flex flex-col gap-6">

                            {{-- Welcome Banner --}}
                            <div class="bg-gradient-to-r from-[#070642] to-[#2563eb] rounded-2xl p-6 text-white shadow-lg">
                                <h2 class="text-2xl font-bold">Hello, {{ auth()->user()->name ?? 'Adam' }}!</h2>
                                <p class="text-sm text-blue-100">{{ now()->format('F d, Y') }}</p>
                            </div>

                            {{-- Buildings Section --}}
<div>
    <livewire:building-cards-section
        :properties="$properties ?? []"
        :show-add-button="true"
        title="Buildings"
        add-button-event="openAddPropertyModal_property-dashboard"
    />
</div>

                            {{-- Units Section - ALWAYS SHOW --}}
                            <div class="mt-6">
                                <livewire:layouts.unit-accordion />
                            </div>

                        </div>

                        {{-- Right Sidebar: 30% --}}
                        <div class="w-full lg:w-[30%] flex flex-col gap-6">
                            <livewire:layouts.stats-sidebar />
                            <livewire:layouts.vacancy-metrics />
                        </div>

                    </div>

                </div>
            </div>
        </section>
    </div>

    {{-- Add Property Modal --}}
    <livewire:layouts.add-property-modal modal-id="property-dashboard" />

    {{-- Add Unit Modal --}}
    <livewire:layouts.add-unit-modal modal-id="property-dashboard" />

    @push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('buildingSelected', (event) => {
                console.log('Building selected:', event.buildingId);
            });

            // Listen for property creation to refresh the list
            Livewire.on('propertyCreated', (propertyId) => {
                console.log('Property created:', propertyId);
                // Refresh the property list
                Livewire.dispatch('refresh-property-list');
            });

            // Listen for unit creation to refresh the list
            Livewire.on('unitCreated', () => {
                console.log('Unit created');
                // Refresh the unit list
                Livewire.dispatch('refresh-unit-list');
            });

            // Listen for modal close events
            Livewire.on('propertyModalClosed', () => {
                console.log('Property modal closed');
            });

            Livewire.on('unitModalClosed', () => {
                console.log('Unit modal closed');
            });
        });
    </script>
    @endpush
@endsection
