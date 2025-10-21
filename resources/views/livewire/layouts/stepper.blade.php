<div class="w-full">

    {{-- Stepper Navigation Container (Centered with max-width) --}}
    <div class="max-w-4xl mx-auto">
        <ol class="flex items-center w-full pt-4 pb-12">
            @foreach ($steps as $step => $label)
                @php
                    $isActive = $currentStep == $step;
                    $isComplete = $currentStep > $step;
                    $isLast = $step == count($steps);
                @endphp

               <li class="flex items-center flex-1
                    {{ $isLast ? '' : "after:content-[''] after:w-full after:h-0.5 after:border-b after:inline-block" }}
                    {{-- 💡 UPDATED: Line color changes if step is complete --}}
                    {{ $isComplete ? 'text-[#0030C5] after:border-[#0030C5]' : 'text-gray-500 after:border-[#D4D4D4]' }}">

                    {{-- Step Circle and Label Container --}}
                    <div class="flex flex-col items-center">
                        {{-- Circle --}}
                        <div class="flex items-center justify-center w-10 h-10 rounded-full border-2
                            {{ $isActive ? 'bg-[#0030C5] border-[#0030C5]' : ($isComplete ? 'bg-[#0030C5] border-transparent' : 'bg-white border-[#D4D4D4]') }}
                            text-base font-semibold
                            {{ $isActive ? 'text-white' : ($isComplete ? 'text-white' : 'text-gray-500') }}
                            transition-colors duration-300">
                            {{ $step }}
                        </div>

                        {{-- Label --}}
                        <span class="mt-2 text-sm text-center transition-colors duration-300 whitespace-nowrap
                            {{ $isActive ? 'text-[#0030C5] font-semibold' : 'text-gray-500' }}">
                            {{ $label }}
                        </span>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>

    {{-- Step Content Container (White Card - Matches image style) --}}
    <div id="form_container" class="bg-white p-6 rounded-2xl shadow-xl min-h-[400px] border border-gray-200">

        {{-- Step 1 Content: Basic Info --}}
        @if ($currentStep == 1)
            <div class="p-4">
                {{-- Step Header --}}
                <h3 class="flex items-center text-xl font-semibold text-[#021C3F] mb-6">
                    <svg class="w-6 h-6 mr-3 text-[#0030C5]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Basic Info
                </h3>

                {{-- Form Fields --}}
                <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                    <div>
                        <label for="unit_number" class="block mb-2 text-sm font-medium text-gray-900">Unit Number</label>
                        <input type="text" id="unit_number" wire:model="unit_number" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#0030C5] focus:border-[#0030C5] block w-full p-3" placeholder="106">
                    </div>
                    <div>
                        <label for="property_type" class="block mb-2 text-sm font-medium text-gray-900">Property Type</label>
                        <select id="property_type" wire:model="property_type" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#0030C5] focus:border-[#0030C5] block w-full p-3">
                            <option>Condotel</option>
                            <option>Apartment</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label for="address" class="block mb-2 text-sm font-medium text-gray-900">Address</label>
                        <input type="text" id="address" wire:model="address" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#0030C5] focus:border-[#0030C5] block w-full p-3" placeholder="Fame Residences, Mandaluyong City">
                    </div>
                    <div>
                        <label for="floor_level" class="block mb-2 text-sm font-medium text-gray-900">Floor Level</label>
                        <input type="text" id="floor_level" wire:model="floor_level" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#0030C5] focus:border-[#0030C5] block w-full p-3" placeholder="eg. 12">
                    </div>
                    <div>
                        <label for="view_type" class="block mb-2 text-sm font-medium text-gray-900">View Type</label>
                        <select id="view_type" wire:model="view_type" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#0030C5] focus:border-[#0030C5] block w-full p-3">
                            <option>Select View</option>
                            <option>City View</option>
                        </select>
                    </div>
                    <div>
                        <label for="property_manager" class="block mb-2 text-sm font-medium text-gray-900">Property Manager</label>
                        <input type="text" id="property_manager" wire:model="property_manager" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#0030C5] focus:border-[#0030C5] block w-full p-3" placeholder="Ninole Candelaria">
                    </div>
                    <div class="flex items-end">
                        <div class="flex items-center h-full">
                            <input id="parking_available" type="checkbox" wire:model="parking_available" class="w-4 h-4 text-[#0030C5] bg-gray-100 border-gray-300 rounded focus:ring-[#0030C5]">
                            <label for="parking_available" class="ms-2 text-sm font-medium text-gray-900">Parking Available</label>
                        </div>
                    </div>
                </div>

                {{-- Horizontal Separator (Dotted Line) --}}
                <div class="border-t border-dashed border-gray-300 my-8"></div>

                {{-- Navigation Buttons --}}
                <div class="flex justify-between items-center">
                    @php
                        $isPrevDisabled = $currentStep == 1;
                    @endphp

                    <button
                        wire:click="previousStep"
                        {{ $isPrevDisabled ? 'disabled' : '' }}
                        class="px-8 py-3 text-base font-medium rounded-lg shadow-md transition-colors duration-200
                            {{ $isPrevDisabled
                                ? 'text-gray-400 bg-gray-100 cursor-not-allowed'
                                : 'text-gray-700 bg-gray-200 hover:bg-gray-300'
                            }}">
                        Previous
                    </button>

                    @if ($currentStep < count($steps))
                        <button wire:click="nextStep" class="px-10 py-3 text-base font-medium text-white bg-[#0030C5] rounded-lg hover:bg-indigo-700 transition-colors duration-200 shadow-md">Next</button>
                    @else
                        <button wire:click="finish" class="px-10 py-3 text-base font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors duration-200 shadow-md">Finish</button>
                    @endif
                </div>

            </div>

        {{-- Step 2 Content: Capacity --}}
        @elseif ($currentStep == 2)
            <div class="p-4">
                {{-- Step Header --}}
                <h3 class="flex items-center text-xl font-semibold text-[#021C3F] mb-6">
                    {{-- Icon for Capacity (using a generic Ruler/Area icon) --}}
                    <svg class="w-6 h-6 mr-3 text-[#0030C5]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2 2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Capacity
                </h3>

                {{-- Form Fields (Matches the grid and vertical layout of the image) --}}
                <div class="grid grid-cols-2 gap-x-8 gap-y-6">

                    {{-- Row 1: Square Area --}}
                    <div class="col-span-2">
                        <label for="square_area" class="block mb-2 text-sm font-medium text-gray-900">Square Area (Sqm)</label>
                        <input type="text" id="square_area" wire:model="square_area" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#0030C5] focus:border-[#0030C5] block w-full p-3" placeholder="Enter total floor area">
                    </div>

                    {{-- Row 2: Bedroom & Bathroom --}}
                    <div>
                        <label for="bedroom_count" class="block mb-2 text-sm font-medium text-gray-900">Bedroom</label>
                        <input type="number" id="bedroom_count" wire:model="bedroom_count" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#0030C5] focus:border-[#0030C5] block w-full p-3" value="0">
                    </div>
                    <div>
                        <label for="bathroom_count" class="block mb-2 text-sm font-medium text-gray-900">Bathroom</label>
                        <select id="bathroom_count" wire:model="bathroom_count" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#0030C5] focus:border-[#0030C5] block w-full p-3">
                            <option>0</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                        </select>
                    </div>

                    {{-- Row 3: Total Beds & Kitchen --}}
                    <div>
                        <label for="total_beds" class="block mb-2 text-sm font-medium text-gray-900">Total Beds</label>
                        <input type="number" id="total_beds" wire:model="total_beds" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#0030C5] focus:border-[#0030C5] block w-full p-3" placeholder="eg. 12">
                    </div>
                    <div>
                        <label for="kitchen_count" class="block mb-2 text-sm font-medium text-gray-900">Kitchen Count</label>
                         {{-- Using kitchen_count property from Livewire component --}}
                        <input type="number" id="kitchen_count" wire:model="kitchen_count" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#0030C5] focus:border-[#0030C5] block w-full p-3" placeholder="eg. 1">
                    </div>

                    {{-- Row 4: Maximum Occupancy --}}
                    <div class="col-span-2">
                        <label for="maximum_occupancy" class="block mb-2 text-sm font-medium text-gray-900">Maximum Occupancy</label>
                        <input type="number" id="maximum_occupancy" wire:model="maximum_occupancy" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#0030C5] focus:border-[#0030C5] block w-full p-3" placeholder="Maximum number of guests">
                    </div>

                </div>

                {{-- Horizontal Separator (Dotted Line) --}}
                <div class="border-t border-dashed border-gray-300 my-8"></div>

                {{-- Navigation Buttons --}}
                <div class="flex justify-between items-center">
                    @php
                        $isPrevDisabled = $currentStep == 1; // True only for step 1
                    @endphp

                    <button
                        wire:click="previousStep"
                        {{ $isPrevDisabled ? 'disabled' : '' }}
                        class="px-8 py-3 text-base font-medium rounded-lg shadow-md transition-colors duration-200
                            {{ $isPrevDisabled
                                ? 'text-gray-400 bg-gray-100 cursor-not-allowed'
                                : 'text-gray-700 bg-gray-200 hover:bg-gray-300'
                            }}">
                        Previous
                    </button>

                    @if ($currentStep < count($steps))
                        {{-- Changed Next button background to match the image --}}
                        <button wire:click="nextStep" class="px-10 py-3 text-base font-medium text-white bg-[#0030C5] rounded-lg hover:bg-indigo-700 transition-colors duration-200 shadow-md">Next</button>
                    @else
                        <button wire:click="finish" class="px-10 py-3 text-base font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors duration-200 shadow-md">Finish</button>
                    @endif
                </div>

            </div>

        {{-- Step 3 Content: Amenities --}}
        @elseif ($currentStep == 3)
            <div class="p-4">
                {{-- Step Header --}}
                <h3 class="flex items-center text-xl font-semibold text-[#021C3F] mb-6">
                    {{-- Icon for Amenities --}}
                    <svg class="w-6 h-6 mr-3 text-[#0030C5]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.55 23.55 0 0115.5 16.5c-2.43 0-4.735-.556-6.887-1.542l-2.67-1.111A3.493 3.493 0 002.5 15.5c0 1.933 1.567 3.5 3.5 3.5h.5m14.5-5.745l.235-.084m-4.664-2.887a1 1 0 00-1.789 0m-4.597 0a1 1 0 00-1.789 0m-4.597 0a1 1 0 00-1.789 0M21 14V7a2 2 0 00-2-2H5a2 2 0 00-2 2v7"></path>
                    </svg>
                    Amenities And Features
                </h3>

                <div class="flex flex-col gap-6">

                    {{-- Amenities And Features --}}
                    <div class="p-4 rounded-xl border border-[#D1E0FF] bg-[#F7FAFF]">
                        <h4 class="text-lg font-semibold text-[#021C3F] mb-4">Amenities And Features</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($amenities_features as $key => $label)
                                @php
                                    // Custom label for fast_wifi to match the image
                                    $displayLabel = $key === 'fast_wifi' ? 'Fast Wi-Fi (50Mbps Woofy Fiber)' : ucwords(str_replace('_', ' ', $key));
                                @endphp
                                <div class="flex items-center">
                                    {{-- Icon for the checkbox label (using a generic list icon that matches the image) --}}
                                    <svg class="w-5 h-5 mr-3 text-[#0030C5] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <input id="amenities-{{ $key }}" type="checkbox" wire:model="amenities_features.{{ $key }}" class="w-4 h-4 text-[#0030C5] bg-white border-[#D4D4D4] rounded-sm focus:ring-[#0030C5] ring-offset-white">
                                    <label for="amenities-{{ $key }}" class="ml-2 text-sm font-medium text-gray-900">{{ $displayLabel }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Bedroom And Bedding --}}
                    <div class="p-4 rounded-xl border border-[#D1E0FF] bg-[#F7FAFF]">
                        <h4 class="text-lg font-semibold text-[#021C3F] mb-4">Bedroom And Bedding</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($bedroom_bedding as $key => $label)
                                @php
                                    // Custom label for beddings_pillows_duvet to match the image
                                    $displayLabel = $key === 'beddings_pillows_duvet' ? 'Beddings, Pillows, Duvet' : ucwords(str_replace('_', ' ', $key));
                                @endphp
                                <div class="flex items-center">
                                     <svg class="w-5 h-5 mr-3 text-[#0030C5] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <input id="bedding-{{ $key }}" type="checkbox" wire:model="bedroom_bedding.{{ $key }}" class="w-4 h-4 text-[#0030C5] bg-white border-[#D4D4D4] rounded-sm focus:ring-[#0030C5] ring-offset-white">
                                    <label for="bedding-{{ $key }}" class="ml-2 text-sm font-medium text-gray-900">{{ $displayLabel }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Kitchen And Dining --}}
                    <div class="p-4 rounded-xl border border-[#D1E0FF] bg-[#F7FAFF]">
                        <h4 class="text-lg font-semibold text-[#021C3F] mb-4">Kitchen And Dining</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($kitchen_dining as $key => $label)
                                @php
                                    // Custom labels for clarity
                                    $displayLabel = ucwords(str_replace('_', ' ', $key));
                                @endphp
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-[#0030C5] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <input id="kitchen-{{ $key }}" type="checkbox" wire:model="kitchen_dining.{{ $key }}" class="w-4 h-4 text-[#0030C5] bg-white border-[#D4D4D4] rounded-sm focus:ring-[#0030C5] ring-offset-white">
                                    <label for="kitchen-{{ $key }}" class="ml-2 text-sm font-medium text-gray-900">{{ $displayLabel }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Entertainment --}}
                    <div class="p-4 rounded-xl border border-[#D1E0FF] bg-[#F7FAFF]">
                        <h4 class="text-lg font-semibold text-[#021C3F] mb-4">Entertainment</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($entertainment as $key => $label)
                                @php
                                    // Custom label to match the image
                                    $displayLabel = $key === 'smart_tv_disney_plus' ? '43" Smart TV With Free Disney+ Access' : ucwords(str_replace('_', ' ', $key));
                                @endphp
                                <div class="flex items-center col-span-2">
                                    <svg class="w-5 h-5 mr-3 text-[#0030C5] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <input id="entertainment-{{ $key }}" type="checkbox" wire:model="entertainment.{{ $key }}" class="w-4 h-4 text-[#0030C5] bg-white border-[#D4D4D4] rounded-sm focus:ring-[#0030C5] ring-offset-white">
                                    <label for="entertainment-{{ $key }}" class="ml-2 text-sm font-medium text-gray-900">{{ $displayLabel }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Additional Items --}}
                    <div class="p-4 rounded-xl border border-[#D1E0FF] bg-[#F7FAFF]">
                        <h4 class="text-lg font-semibold text-[#021C3F] mb-4">Additional Items</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($additional_items as $key => $label)
                                @php
                                    $displayLabel = ucwords(str_replace('_', ' ', $key));
                                @endphp
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-[#0030C5] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <input id="additional-{{ $key }}" type="checkbox" wire:model="additional_items.{{ $key }}" class="w-4 h-4 text-[#0030C5] bg-white border-[#D4D4D4] rounded-sm focus:ring-[#0030C5] ring-offset-white">
                                    <label for="additional-{{ $key }}" class="ml-2 text-sm font-medium text-gray-900">{{ $displayLabel }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Consumables Provided --}}
                    <div class="p-4 rounded-xl border border-[#D1E0FF] bg-[#F7FAFF]">
                        <h4 class="text-lg font-semibold text-[#021C3F] mb-4">Consumables Provided</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($consumables_provided as $key => $label)
                                @php
                                    // Custom labels for the two 'toothpaste' keys and others
                                    if ($key === 'toothpaste_1' || $key === 'toothpaste_2') {
                                        $displayLabel = 'Toothpaste';
                                    } else {
                                        $displayLabel = ucwords(str_replace('_', ' ', $key));
                                    }
                                @endphp
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-[#0030C5] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <input id="consumable-{{ $key }}" type="checkbox" wire:model="consumables_provided.{{ $key }}" class="w-4 h-4 text-[#0030C5] bg-white border-[#D4D4D4] rounded-sm focus:ring-[#0030C5] ring-offset-white">
                                    <label for="consumable-{{ $key }}" class="ml-2 text-sm font-medium text-gray-900">{{ $displayLabel }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                {{-- Horizontal Separator (Dotted Line) --}}
                <div class="border-t border-dashed border-gray-300 my-8"></div>

                {{-- Navigation Buttons --}}
                <div class="flex justify-between items-center">
                    @php
                        $isPrevDisabled = $currentStep == 1; // True only for step 1
                    @endphp

                    <button
                        wire:click="previousStep"
                        {{ $isPrevDisabled ? 'disabled' : '' }}
                        class="px-8 py-3 text-base font-medium rounded-lg shadow-md transition-colors duration-200
                            text-gray-700 bg-gray-200 hover:bg-gray-300">
                        Previous
                    </button>

                    @if ($currentStep < count($steps))
                        <button wire:click="nextStep" class="px-10 py-3 text-base font-medium text-white bg-[#0030C5] rounded-lg hover:bg-indigo-700 transition-colors duration-200 shadow-md">Next</button>
                    @else
                        <button wire:click="finish" class="px-10 py-3 text-base font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors duration-200 shadow-md">Finish</button>
                    @endif
                </div>

            </div>

        {{-- Step 4 Content: Review And Predict Price --}}
        @elseif ($currentStep == 4)
            <div class="p-4 flex flex-col gap-6">

                {{-- Step Header (Matches image style) --}}
                <h3 class="flex items-center text-xl font-semibold text-[#021C3F]">
                    {{-- Icon for Review/Prediction (using a generic Eye/Magnifying Glass icon) --}}
                    <svg class="w-6 h-6 mr-3 text-[#0030C5]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Review And Predict Price
                </h3>

                {{-- Property Details Summary (Retained from previous revision) --}}
                <div class="p-6 rounded-xl border border-[#D1E0FF] bg-[#F7FAFF]">
                    <h4 class="text-lg font-semibold text-[#021C3F] mb-4">Property Details</h4>
                    <div class="grid grid-cols-2 gap-y-2 text-sm">
                        <div class="text-gray-500">Unit:</div>
                        <div class="font-medium text-gray-900">{{ $unit_number ?? 'N/A' }}</div>
                        <div class="text-gray-500">Type:</div>
                        <div class="font-medium text-gray-900">{{ $property_type ?? 'N/A' }}</div>
                        <div class="text-gray-500">Address:</div>
                        <div class="font-medium text-gray-900">{{ $address ?? 'N/A' }}</div>
                        <div class="text-gray-500">Floor Level:</div>
                        <div class="font-medium text-gray-900">{{ $floor_level ?? 'N/A' }}</div>
                        <div class="text-gray-500">View Type:</div>
                        <div class="font-medium text-gray-900">{{ $view_type ?? 'N/A' }}</div>
                        <div class="text-gray-500">Property Manager:</div>
                        <div class="font-medium text-gray-900">{{ $property_manager ?? 'N/A' }}</div>
                        <div class="text-gray-500">Parking:</div>
                        <div class="font-medium text-gray-900">{{ $parking_available ? 'Available' : 'Unavailable' }}</div>
                    </div>
                </div>

                {{-- Capacity Summary (Retained from previous revision) --}}
                <div class="p-6 rounded-xl border border-[#D1E0FF] bg-[#F7FAFF]">
                    <h4 class="text-lg font-semibold text-[#021C3F] mb-4">Capacity</h4>
                    <div class="grid grid-cols-2 gap-y-2 text-sm">
                        <div class="text-gray-500">Square Area (Sqm):</div>
                        <div class="font-medium text-gray-900">{{ $square_area ?? 'N/A' }} Sqm</div>
                        <div class="text-gray-500">Bedroom:</div>
                        <div class="font-medium text-gray-900">{{ $bedroom_count ?? 'N/A' }}</div>
                        <div class="text-gray-500">Bathroom:</div>
                        <div class="font-medium text-gray-900">{{ $bathroom_count ?? 'N/A' }}</div>
                        <div class="text-gray-500">Total Beds:</div>
                        <div class="font-medium text-gray-900">{{ $total_beds ?? 'N/A' }}</div>
                        <div class="text-gray-500">Maximum Occupancy:</div>
                        <div class="font-medium text-gray-900">{{ $maximum_occupancy ?? 'N/A' }}</div>
                    </div>
                </div>

                {{-- 💡 UPDATED: Amenities and Features Summary (Formatted to match the new photo) --}}
                <div class="p-6 rounded-xl border border-[#D1E0FF] bg-[#F7FAFF] text-sm text-[#021C3F]">

                    @php
                        // Helper function to process amenities into an array of labels
                        function getCheckedLabels($items, $customLabels = []) {
                            $checked = [];
                            foreach ($items as $key => $value) {
                                if ($value) {
                                    $checked[] = $customLabels[$key] ?? ucwords(str_replace('_', ' ', $key));
                                }
                            }
                            return $checked;
                        }

                        // Define all checked items for each category (using data from AddUnit.php properties)
                        $amenitiesFeaturesLabels = getCheckedLabels($amenities_features, [
                            'fast_wifi' => 'Fast Wi-Fi (50Mbps Woofy Fiber)',
                            'air_conditioning' => 'Air Conditioning',
                            'hot_cold_shower' => 'Hot & Cold Shower'
                        ]);
                        $bedroomBeddingLabels = getCheckedLabels($bedroom_bedding, [
                            'beddings_pillows_duvet' => 'Beddings, Pillows, Duvet',
                        ]);
                        $entertainmentLabels = getCheckedLabels($entertainment, [
                            'smart_tv_disney_plus' => '43" Smart TV With Free Disney+ Access'
                        ]);
                        $additionalItemsLabels = getCheckedLabels($additional_items);
                        $consumablesProvidedLabels = getCheckedLabels($consumables_provided, [
                            'toothpaste_1' => 'Toothpaste',
                            'toothpaste_2' => 'Toothpaste',
                            'bath_towels' => 'Bath Towels',
                            'bathroom_tissue' => 'Bathroom Tissue',
                            'bath_soap' => 'Bath Soap',
                            'hand_soap' => 'Hand Soap',
                        ]);

                        // Ensure 'Toothpaste' is deduplicated for display if both are true
                        $consumablesProvidedLabels = array_unique($consumablesProvidedLabels);

                        // Function to render a category using grid layout
                        function renderCategory($title, $items, $cols = 3) {
                            if (empty($items)) {
                                return; // Skip if no items are checked
                            }
                            $output = "<h4 class='text-lg font-semibold text-[#021C3F] mb-4'>$title</h4>";
                            $output .= "<div class='grid grid-cols-$cols gap-y-4'>";
                            foreach ($items as $item) {
                                $output .= "<div class='text-sm'>$item</div>";
                            }
                            $output .= "</div>";
                            $output .= "<div class='border-t border-dashed border-gray-300 my-4'></div>"; // Dotted line separator
                            return $output;
                        }
                    @endphp

                    {{-- Amenities And Features (General) --}}
                    {!! renderCategory('Amenities And Features', $amenitiesFeaturesLabels) !!}

                    {{-- Bedroom And Bedding --}}
                    {!! renderCategory('Bedroom And Bedding', $bedroomBeddingLabels) !!}

                    {{-- Entertainment --}}
                    {!! renderCategory('Entertainment', $entertainmentLabels, 1) !!} {{-- Single column for TV --}}

                    {{-- Additional Items --}}
                    {!! renderCategory('Additional Items', $additionalItemsLabels, 3) !!}

                    {{-- Consumables Provided (Last category, no trailing dotted line) --}}
                    <h4 class='text-lg font-semibold text-[#021C3F] mb-4'>Consumables Provided</h4>
                    <div class='grid grid-cols-2 gap-y-4'>
                        {{-- Handle the 2-column, 4-row layout for consumables --}}
                        @php
                            // Manually map items to the two columns to match the image structure
                            $col1 = [];
                            $col2 = [];
                            $allConsumables = [
                                'Toothpaste', // Deduped, appears in both columns
                                'Bath Soap',
                                'Bathroom Tissue',
                                'Slippers',
                                'Hand Soap',
                                'Bath Towels',
                            ];
                            // Filter only the checked items, maintaining order for mapping
                            $checkedConsumables = array_intersect($allConsumables, $consumablesProvidedLabels);

                            // Map to 2 columns (up to 4 rows deep)
                            $count = 0;
                            foreach ($checkedConsumables as $item) {
                                if ($count < 4) {
                                    $col1[] = $item;
                                } else {
                                    $col2[] = $item;
                                }
                                $count++;
                            }
                            // To match the image: Toothpaste, Bath Soap, Tissue, Slippers (Col 1); Toothpaste, Hand Soap, Towels (Col 2)
                            // A simple grid of 2 columns with 7 rows will suffice if we map them correctly
                            $displayMap = [
                                ['Toothpaste', 'Toothpaste'],
                                ['Bath Soap', 'Hand Soap'],
                                ['Bathroom Tissue', 'Bath Towels'],
                                ['Slippers', null], // Slippers has no partner in the image
                            ];
                        @endphp

                        @foreach($displayMap as $row)
                            @foreach($row as $item)
                                <div class="text-sm">
                                    @if ($item && in_array($item, $consumablesProvidedLabels))
                                        {{ $item }}
                                    @endif
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                    <div class="border-t border-dashed border-gray-300 my-4"></div>
                </div>

                {{-- Horizontal Separator (Dotted Line) --}}
                <div class="border-t border-dashed border-gray-300 my-8"></div>

                {{-- Navigation Buttons --}}
                <div class="flex justify-start items-center">
                    {{-- Only the Previous button is needed here as Next is in the prediction banner --}}
                    <button
                        wire:click="previousStep"
                        class="px-8 py-3 text-base font-medium rounded-lg shadow-md transition-colors duration-200 text-gray-700 bg-gray-200 hover:bg-gray-300">
                        Previous
                    </button>
                </div>

            </div>

            {{-- AI Price Prediction Banner (Separate from the white card, positioned below) --}}
            <div class="w-full bg-[#0030C5] p-6 rounded-2xl flex flex-col md:flex-row justify-between items-center mt-6">
                <div class="flex flex-col text-white mb-4 md:mb-0">
                    <span class="text-base font-light opacity-80">AI Price Prediction</span>
                    <div class="flex items-end mt-1">
                        {{-- Placeholder for the predicted price (matches the image) --}}
                        <span class="text-4xl font-bold">₱ 24,000</span>
                    </div>
                    <span class="text-xs font-light opacity-60 mt-1">Based on location, sqm and amenities</span>
                </div>

                {{-- Predict Price Button (Final Action) --}}
                <button
                    wire:click="finish"
                    class="w-full md:w-auto px-10 py-3 text-base font-medium text-[#0030C5] bg-white rounded-lg hover:bg-gray-100 transition-colors duration-200 shadow-lg flex items-center justify-center">
                    {{-- Icon for Predict Price (generic graph/chart icon) --}}
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l2-2 2 2v13M9 19h6M9 19l-3 3M15 19l3 3M12 4v16"></path>
                    </svg>
                    Predict Price
                </button>
            </div>
        @endif

    </div>
</div>
