<div class="p-6 md:p-8">

    {{-- Main Title --}}
    <h3 class="text-2xl font-semibold text-[#021C3F] mb-6">Review And Predict Price</h3>

    <div class="flex flex-col gap-6">

        {{-- 1. Property Details Section --}}
        <div class="p-6 rounded-lg border border-[#D1E0FF] bg-[#F7FAFF]">
            <h4 class="text-lg font-semibold text-[#021C3F] mb-4">Property Details</h4>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-3 text-sm">
                
                <div class="flex flex-col gap-y-3 font-medium text-gray-500">
                    <span>Building Name</span>
                    <span>Floor Number</span>
                    <span>Room Number</span>
                    <span>Utility Subsidy</span>
                </div>
                
                <div class="flex flex-col gap-y-3 font-semibold text-gray-900">
                    <span>{{ $building_name ?? 'ridgewood tower 3' }}</span>
                    <span>{{ $floor_number ?? '12' }}</span>
                    <span>{{ $room_number ?? 'R1' }}</span>
                    <span>{{ $utility_subsidy ? 'Yes' : 'No' }}</span>
                </div>
                
                <div class="flex flex-col gap-y-3 font-medium text-gray-500">
                    <span>Address</span>
                    <span>Unit Number</span>
                    <span>Bed Type</span>
                </div>
                
                <div class="flex flex-col gap-y-3 font-semibold text-gray-900">
                    <span>{{ $address ?? 'Bonifacio Global City, Fort Bonifacio, Taguig City' }}</span>
                    <span>{{ $unit_number ?? 'Unit 101' }}</span>
                    <span>{{ $dorm_type ?? 'All Male' }}</span>
                </div>
            </div>
        </div>

        {{-- 2. AI Price Prediction Section --}}
        <div class="p-6 rounded-lg bg-[#2469F5] text-white shadow-lg">
            
            {{-- Top Part (Prediction + Price) --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center pb-4 border-b border-white/30">
                {{-- Left Side: Details --}}
                <div class="flex flex-col">
                    <h4 class="text-xl font-semibold">AI Price Prediction</h4>
                    <span class="text-base font-light">Predicted Monthly Rate: ₱29,000</span>
                    <span class="text-xs font-extralight opacity-80">Based on property features and amenities</span>
                </div>
                
                {{-- 💡 REVISED: Right Side Price (Now an input) --}}
                <div class="flex flex-col items-end mt-4 md:mt-0">
                    
                    {{-- This is the new input box styled like your image --}}
                    <div class="relative flex items-center bg-blue-500 rounded-2xl px-5 py-3"> {{-- Used bg-blue-500 to match image --}}
                        <span class="text-4xl font-bold text-white">₱</span>
                        <input type="number" wire:model.lazy="predicted_price"
                               class="bg-transparent text-white text-4xl font-bold w-48 ml-2 border-0 focus:ring-0 p-0 placeholder-white/70"
                               style="appearance: textfield; -moz-appearance: textfield;"
                               placeholder="29000">
                    </div>
                    <span class="text-sm opacity-90 mt-1">per month</span>
                </div>
            </div>
            
            {{-- Bottom Part (Stats) --}}
            <div class="grid grid-cols-3 gap-4 pt-4 text-center">
                <div>
                    <span class="text-3xl font-bold">{{ $amenityCount }}</span>
                    <span class="block text-sm opacity-90">Amenities</span>
                </div>
                <div>
                    <span class="text-3xl font-bold">{{ $unit_capacity ?? '4' }}</span>
                    <span class="block text-sm opacity-90">Unit Capacity</span>
                </div>
                <div>
                    <span class="text-3xl font-bold">{{ $room_capacity ?? '4' }}</span>
                    <span class="block text-sm opacity-90">Room Capacity</span>
                </div>
            </div>
        </div>
        
        {{-- 3. Selected Amenities Section --}}
        <div class="p-6 rounded-lg border border-[#D1E0FF] bg-[#F7FAFF]">
            <h4 class="text-lg font-semibold text-[#021C3F] mb-4">Selected Amenities</h4>
            
            <div class="flex flex-wrap gap-2">
                @foreach (['amenities_features', 'bedroom_bedding', 'kitchen_dining', 'entertainment', 'additional_items', 'consumables_provided', 'property_amenities'] as $group)
                    @if (isset($$group) && is_array($$group))
                        @foreach ($$group as $key => $isSelected)
                            @if ($isSelected && isset($labels[$group][$key]))
                                <span class="py-1.5 px-4 bg-white text-[#2469F5] border border-[#2469F5] rounded-full text-sm font-medium">
                                    {{ $labels[$group][$key] }}
                                </span>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>
        </div>

    </div>

    {{-- Horizontal Separator (Dotted Line) --}}
    <div class="border-t border-dashed border-gray-300 my-8"></div>

    {{-- Navigation Buttons --}}
    <div class="flex justify-between items-center">
        <button
            wire:click="previousStep"
            class="px-8 py-3 text-base font-medium text-white bg-[#2469F5] rounded-lg hover:bg-[#1c55c0] transition-colors duration-200 shadow-md">
            Previous
        </button>

        <button wire:click="finish" 
            class="px-10 py-3 text-base font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors duration-200 shadow-md">
            Finish
        </button>
    </div>

</div>