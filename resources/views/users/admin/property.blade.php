@extends ('layouts.app')

@section('content')

<div class="flex flex-row h-screen overflow-hidden">
    <nav class="w-0 md:w-64 flex-shrink-0 h-full overflow-y-auto bg-white">
        @include('livewire.layouts.adminnav')
    </nav>

    <section id="main-container" class="flex-1 h-full flex flex-col overflow-hidden">

        <div class="flex-shrink-0 bg-white z-30">
            <livewire:layouts.top-bar />
        </div>

         <div class="flex-1 overflow-y-auto ml-8">
            <div id="manager-container" class="page-container">

                {{-- Page Header --}}
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mt-6 mb-6">
                    <div class="flex flex-col">
                        <span id="main-header" class="header-title text-2xl md:text-3xl text-blue-900 font-bold">PROPERTY MANAGEMENT</span>
                        <span class="sub-header text-sm md:text-base text-gray-600">View and record property or unit</span>
                    </div>
                    <div>
                        {{-- 
                          CHANGED: Using route name for consistency.
                          Also, this should probably link to 'Add Property' not 'Add Unit'.
                        --}}
                        <a href="{{ route('properties.create') }}" 
                           class="py-3 px-6 font-medium text-sm text-white bg-[#070642] rounded-lg hover:bg-[#22228e] transition-colors duration-200 shadow-md">
                           + Add Property 
                        </a>
                        {{-- <x-ui.button-add href="{{ route('properties.create') }}" text="Add Property" /> --}}
                    </div>
                </div>

                <div id="main-layout-container" class="flex flex-col lg:flex-row gap-6 mb-8">

                    <div class="w-full lg:w-[70%] flex flex-col gap-8">

<<<<<<< HEAD
                        @include('livewire.layouts.admingreeting')

                        <div>
                            <span class="com-header text-lg md:text-xl text-blue-900 font-bold mb-4">BUILDINGS</span>
                            <div id="building-sort" class="flex gap-4 overflow-x-auto pb-4 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                                <livewire:layouts.Buildings
                                    title="Building 1"
                                    address="3360 Ibarra St., Palanan, Makati" />
                                <livewire:layouts.Buildings
                                    image="https://media.istockphoto.com/id/1467597986/photo/professionally-landscaped-garden-flower-bed.jpg?s=2048x2048&w=is&k=20&c=EkSeVR74NXBQAgY7xgrUt27JP1sIJk51L3vUKT7RmvQ="
                                    title="Building 1"
                                    address="3360 Ibarra St., Palanan, Makati" />
                                <livewire:layouts.Buildings
                                    title="Building 1"
                                    address="3360 Ibarra St., Palanan, Makati" />
                                <livewire:layouts.Buildings
                                    title="Building 1"
                                    address="3360 Ibarra St., Palanan, Makati" />
                                <livewire:layouts.Buildings
                                    title="Building 1"
                                    address="3360 Ibarra St., Palanan, Makati" />
                            </div>
                        </div>

                        <div class="w-full">
                            <livewire:layouts.unit-accordion />
                        </div>

                    </div>

                    <div class="w-full lg:w-[30%] flex-shrink-0">
                        <livewire:layouts.stats-sidebar />
                    </div>

=======
                {{-- 
                  CHANGED: Building List with Empty State
                  This replaces your hard-coded list of <livewire:layouts.Buildings />
                --}}
                <div id="building-sort" class="flex gap-4 overflow-x-auto pb-4 mb-8 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                    
                    @forelse ($properties as $property)
                        {{-- Assuming 'livewire:layouts.Buildings' is your building card component --}}
                        {{-- You need to pass the actual property data to it --}}
                        <livewire:layouts.Buildings 
                            :key="$property->property_id" 
                            :property="$property" {{-- Pass the whole object --}}
                            {{-- Or pass individual attributes: --}}
                            {{-- image="some-default-image.jpg" --}} 
                            {{-- title="{{ $property->building_name }}" --}} 
                            {{-- address="{{ $property->address }}" --}}
                        />
                    @empty
                        {{-- Show the "empty state" message if $properties is empty --}}
                        <div class="w-full flex flex-col items-center justify-center text-center p-16 border-2 border-dashed border-gray-300 rounded-lg bg-white">
                             
                            <h3 class="text-xl font-semibold text-gray-700 mt-4">No properties found</h3>
                            <p class="text-gray-500 mt-2">Get started by adding your first property.</p>
                        </div>
                    @endforelse
>>>>>>> 29d4319 (modified docker compose for api)
                </div>
                {{-- End Building List --}}


                {{-- 
                  Conditional Display for Unit Sections
                  Only show unit navigation and detail if there are properties.
                --}}
                @if ($properties->isNotEmpty())
                    <div id="units-container" class="flex flex-col lg:flex-row gap-6 mb-8">
                        
                        <div id="unit-navigation-sidebar" class="w-full lg:w-[30%] flex-shrink-0 h-[750px]">
                            {{-- This component needs to know which property is selected --}}
                            <livewire:layouts.unit-navigation /> 
                        </div>

                        <div id="unit-detail-card" class="w-full lg:w-[70%] h-[750px]">
                            {{-- This component needs to know which unit is selected --}}
                            <livewire:layouts.unit-detail /> 
                        </div>
                    </div>
                @endif 
                {{-- End Conditional Unit Display --}}

            </div>
        </div>
    </section>
</div>

@endsection
