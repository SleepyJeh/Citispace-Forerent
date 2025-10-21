<div class="p-4 flex flex-col gap-6">
    {{-- Step Header --}}
    <h3 class="flex items-center text-xl font-semibold text-[#021C3F]">
        <svg class="w-6 h-6 mr-3 text-[#0030C5]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        </svg>
        Review And Predict Price
    </h3>

    {{-- Property Details Summary --}}
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

    {{-- Capacity Summary --}}
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

    {{-- Amenities and Features Summary --}}
    <div class="p-6 rounded-xl border border-[#D1E0FF] bg-[#F7FAFF]">
        <h4 class="text-lg font-semibold text-[#021C3F] mb-4">Amenities And Features</h4>

        {{-- General Amenities --}}
        @if(count(array_filter($amenities_features)) > 0)
        <div class="mb-6">
            <h5 class="text-md font-semibold text-[#021C3F] mb-3">General Amenities</h5>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                @foreach($amenities_features as $key => $value)
                    @if($value)
                        @php
                            $label = match($key) {
                                'air_conditioning' => 'Air Conditioning',
                                'hot_cold_shower' => 'Hot & Cold Shower',
                                'fast_wifi' => 'Fast Wi-Fi (50Mbps Woofy Fiber)',
                                default => ucwords(str_replace('_', ' ', $key))
                            };
                        @endphp
                        <div class="flex items-center text-sm text-gray-700">
                            <svg class="w-4 h-4 mr-2 text-[#0030C5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ $label }}
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        {{-- Bedroom And Bedding --}}
        @if(count(array_filter($bedroom_bedding)) > 0)
        <div class="mb-6">
            <h5 class="text-md font-semibold text-[#021C3F] mb-3">Bedroom And Bedding</h5>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                @foreach($bedroom_bedding as $key => $value)
                    @if($value)
                        @php
                            $label = match($key) {
                                'queen_bed' => 'Queen Bed',
                                'sofa_bed' => 'Sofa Bed',
                                'beddings_pillows_duvet' => 'Beddings, Pillows, Duvet',
                                default => ucwords(str_replace('_', ' ', $key))
                            };
                        @endphp
                        <div class="flex items-center text-sm text-gray-700">
                            <svg class="w-4 h-4 mr-2 text-[#0030C5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ $label }}
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        {{-- Kitchen And Dining --}}
        @if(count(array_filter($kitchen_dining)) > 0)
        <div class="mb-6">
            <h5 class="text-md font-semibold text-[#021C3F] mb-3">Kitchen And Dining</h5>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                @foreach($kitchen_dining as $key => $value)
                    @if($value)
                        @php
                            $label = match($key) {
                                'refrigerator' => 'Refrigerator',
                                'microwave_oven' => 'Microwave Oven',
                                'oven_toaster' => 'Oven Toaster',
                                'water_kettle' => 'Water Kettle',
                                'coffee_table_chairs' => 'Coffee Table & Chairs',
                                default => ucwords(str_replace('_', ' ', $key))
                            };
                        @endphp
                        <div class="flex items-center text-sm text-gray-700">
                            <svg class="w-4 h-4 mr-2 text-[#0030C5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ $label }}
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        {{-- Entertainment --}}
        @if(count(array_filter($entertainment)) > 0)
        <div class="mb-6">
            <h5 class="text-md font-semibold text-[#021C3F] mb-3">Entertainment</h5>
            <div class="grid grid-cols-1 gap-2">
                @foreach($entertainment as $key => $value)
                    @if($value)
                        @php
                            $label = match($key) {
                                'smart_tv_disney_plus' => '43" Smart TV With Free Disney+ Access',
                                default => ucwords(str_replace('_', ' ', $key))
                            };
                        @endphp
                        <div class="flex items-center text-sm text-gray-700">
                            <svg class="w-4 h-4 mr-2 text-[#0030C5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ $label }}
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        {{-- Additional Items --}}
        @if(count(array_filter($additional_items)) > 0)
        <div class="mb-6">
            <h5 class="text-md font-semibold text-[#021C3F] mb-3">Additional Items</h5>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                @foreach($additional_items as $key => $value)
                    @if($value)
                        @php
                            $label = match($key) {
                                'flat_iron' => 'Flat Iron',
                                'blower' => 'Blower',
                                default => ucwords(str_replace('_', ' ', $key))
                            };
                        @endphp
                        <div class="flex items-center text-sm text-gray-700">
                            <svg class="w-4 h-4 mr-2 text-[#0030C5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ $label }}
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        {{-- Consumables Provided --}}
        @if(count(array_filter($consumables_provided)) > 0)
        <div class="mb-6">
            <h5 class="text-md font-semibold text-[#021C3F] mb-3">Consumables Provided</h5>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                @foreach($consumables_provided as $key => $value)
                    @if($value)
                        @php
                            $label = match($key) {
                                'toothpaste_1' => 'Toothpaste',
                                'toothpaste_2' => 'Toothpaste',
                                'bath_soap' => 'Bath Soap',
                                'hand_soap' => 'Hand Soap',
                                'bathroom_tissue' => 'Bathroom Tissue',
                                'bath_towels' => 'Bath Towels',
                                'slippers' => 'Slippers',
                                default => ucwords(str_replace('_', ' ', $key))
                            };
                        @endphp
                        <div class="flex items-center text-sm text-gray-700">
                            <svg class="w-4 h-4 mr-2 text-[#0030C5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ $label }}
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        {{-- Show message if no amenities selected --}}
        @if(
            count(array_filter($amenities_features)) === 0 &&
            count(array_filter($bedroom_bedding)) === 0 &&
            count(array_filter($kitchen_dining)) === 0 &&
            count(array_filter($entertainment)) === 0 &&
            count(array_filter($additional_items)) === 0 &&
            count(array_filter($consumables_provided)) === 0
        )
            <div class="text-center text-gray-500 py-4">
                No amenities selected
            </div>
        @endif
    </div>


     {{-- AI Price Prediction Banner (Outside the white card) --}}
<div class="w-full p-8 rounded-2xl flex flex-col md:flex-row justify-between items-center mt-6 prediction-banner-gradient mx-auto max-w-4xl">
    <div class="flex flex-col text-white mb-4 md:mb-0">
        <span class="text-base font-light opacity-80">AI Price Prediction</span>
        <span class="text-xs font-light opacity-60 mt-1">Predicted Monthly Rate</span>
        <div class="flex items-end mt-1">
            <span class="text-4xl font-bold">₱ 24,000</span>
        </div>
        <span class="text-xs font-light opacity-60 mt-1">Based on location, sqm and amenities</span>
    </div>

    {{-- Predict Price Button (Final Action) --}}
    <button
        wire:click="finish"
        class="w-full md:w-auto px-10 py-3 text-base font-medium text-[#0030C5] bg-white rounded-lg hover:bg-gray-100 transition-colors duration-200 shadow-lg flex items-center justify-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l2-2 2 2v13M9 19h6M9 19l-3 3M15 19l3 3M12 4v16"></path>
        </svg>
        Predict Price
    </button>
</div>

{{-- Horizontal Separator (Dotted Line) --}}
    <div class="border-t border-dashed border-gray-300 my-8"></div>

    {{-- Navigation Buttons --}}
    <div class="flex justify-start items-center">
    <button
        wire:click="previousStep"
        class="px-8 py-3 text-base font-medium text-white bg-[#0300A0] rounded-lg hover:bg-[#0c0ab8] transition-colors duration-200 shadow-md">
        Previous
    </button>
</div>


</div>

