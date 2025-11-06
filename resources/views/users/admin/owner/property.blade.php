@extends('layouts.app')

@section('content')

    <div class="flex flex-row h-screen overflow-hidden">
        {{-- Sidebar --}}
        <livewire:navbars.side-bar />

        {{-- Main Content --}}
        <section id="main-container" class="flex-1 h-full flex flex-col overflow-hidden">

            {{-- Top Bar --}}
            <div class="flex-shrink-0 bg-white z-30">
                <livewire:layouts.top-bar />
            </div>

            {{-- Page Content --}}
            <div class="flex-1 overflow-y-auto ml-8">
                <div id="manager-container" class="page-container">

                    {{-- Page Header --}}
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mt-6 mb-6">
                        <div class="flex flex-col">
                        <span id="main-header" class="header-title text-2xl md:text-3xl text-blue-900 font-bold">
                            PROPERTY MANAGEMENT
                        </span>
                            <span class="sub-header text-sm md:text-base text-gray-600">
                            View and record property or unit
                        </span>
                        </div>
                        <div>
                            <a href="{{ route('landlord.property.create') }}"
                               class="py-3 px-6 font-medium text-sm text-white bg-[#070642] rounded-lg hover:bg-[#22228e] transition-colors duration-200 shadow-md">
                                + Add Property
                            </a>
                        </div>
                    </div>

                    {{-- Main Layout: Buildings and Units --}}
                    <div id="main-layout-container" class="flex flex-col lg:flex-row gap-6 mb-8">

                        {{-- Building List --}}
                        <div class="w-full lg:w-[70%] flex flex-col gap-8">
                            <div id="building-sort"
                                 class="flex gap-4 overflow-x-auto pb-4 mb-8 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                                @forelse ($properties as $property)
                                    <livewire:layouts.Buildings
                                        :key="$property->property_id"
                                        :property="$property"
                                    />
                                @empty
                                    <div class="w-full flex flex-col items-center justify-center text-center p-16 border-2 border-dashed border-gray-300 rounded-lg bg-white">
                                        <h3 class="text-xl font-semibold text-gray-700 mt-4">No properties found</h3>
                                        <p class="text-gray-500 mt-2">Get started by adding your first property.</p>
                                    </div>
                                @endforelse
                            </div>
                            {{-- End Building List --}}

                            {{-- Units Section --}}
                            @if ($properties->isNotEmpty())
                                <div id="units-container" class="flex flex-col lg:flex-row gap-6 mb-8">

                                    {{-- Unit Navigation Sidebar --}}
                                    <div id="unit-navigation-sidebar" class="w-full lg:w-[30%] flex-shrink-0 h-[750px]">
                                        <livewire:layouts.unit-navigation />
                                    </div>

                                    {{-- Unit Detail Card --}}
                                    <div id="unit-detail-card" class="w-full lg:w-[70%] h-[750px]">
                                        <livewire:layouts.unit-detail />
                                    </div>

                                </div>
                            @endif
                            {{-- End Units Section --}}

                        </div>
                    </div>
                    {{-- End Main Layout --}}

                </div> {{-- End #manager-container --}}
            </div> {{-- End Page Content --}}
        </section>
    </div> {{-- End Flex Container --}}

@endsection
