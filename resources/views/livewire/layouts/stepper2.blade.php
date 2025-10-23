<div class="p-6 md:p-8">

    {{-- Main Title --}}
    <h3 class="text-2xl font-semibold text-[#021C3F] mb-6">Unit Amenities</h3>

    <div class="flex flex-col gap-6">

        {{-- Group 1: Amenities And Features --}}
        <div class="p-4 rounded-lg border border-[#D1E0FF] bg-[#F7FAFF]">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-lg font-semibold text-[#021C3F]">Amenities And Features</h4>
                <div class="flex items-center">
                    <input id="select-all-amenities" type="checkbox" wire:click="selectAll('amenities_features', $event.target.checked)" class="w-4 h-4 text-[#0030C5] bg-gray-100 border-gray-300 rounded focus:ring-[#0030C5]">
                    <label for="select-all-amenities" class="ml-2 text-sm font-medium text-gray-900">Select All</label>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <div class="flex items-center bg-white p-4 rounded-lg border border-[#E8F0FE]">
                    <input id="amenity-air_conditioning" type="checkbox" wire:model="amenities_features.air_conditioning" class="w-4 h-4 text-[#0030C5] bg-gray-100 border-gray-300 rounded focus:ring-[#0030C5]">
                    <svg class="w-5 h-5 ml-2 text-[#0030C5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5c4.7 0 8.5 3.8 8.5 8.5s-3.8 8.5-8.5 8.5-8.5-3.8-8.5-8.5 3.8-8.5 8.5-8.5zM12 15.5a3.5 3.5 0 100-7 3.5 3.5 0 000 7z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M12 2.5v2M12 19.5v2M21.5 12h-2M4.5 12h-2M18.4 5.6l-1.4 1.4M7 7l-1.4-1.4M18.4 18.4l-1.4-1.4M7 17l-1.4 1.4"></path></svg>
                    <label for="amenity-air_conditioning" class="ml-2 text-sm font-medium text-gray-900">{{ $labels['amenities_features']['air_conditioning'] }}</label>
                </div>
                
                <div class="flex items-center bg-white p-4 rounded-lg border border-[#E8F0FE]">
                    <input id="amenity-hot_cold_shower" type="checkbox" wire:model="amenities_features.hot_cold_shower" class="w-4 h-4 text-[#0030C5] bg-gray-100 border-gray-300 rounded focus:ring-[#0030C5]">
                    <label for="amenity-hot_cold_shower" class="ml-2 text-sm font-medium text-gray-900">{{ $labels['amenities_features']['hot_cold_shower'] }}</label>
                </div>
                
                <div class="flex items-center bg-white p-4 rounded-lg border border-[#E8F0FE] md:col-span-2">
                    <input id="amenity-fast_wifi" type="checkbox" wire:model="amenities_features.fast_wifi" class="w-4 h-4 text-[#0030C5] bg-gray-100 border-gray-300 rounded focus:ring-[#0030C5]">
                    <svg class="w-5 h-5 ml-2 text-[#0030C5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 12.5a.5.5 0 100-1 .5.5 0 000 1zM12 12.5a.5.5 0 100-1 .5.5 0 000 1zM15.5 12.5a.5.5 0 100-1 .5.5 0 000 1zM4.7 8.3C7.5 5.5 12.1 4 17 5.5s8.1 6.6 8.1 6.6M5.8 10.4c2.1-2 5-3 8.3-2.1s5.9 4.3 5.9 4.3"></path></svg>
                    <label for="amenity-fast_wifi" class="ml-2 text-sm font-medium text-gray-900">{{ $labels['amenities_features']['fast_wifi'] }}</label>
                </div>

            </div>
        </div>

        {{-- Group 2: Bedroom And Bedding --}}
        <div class="p-4 rounded-lg border border-[#D1E0FF] bg-[#F7FAFF]">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-lg font-semibold text-[#021C3F]">Bedroom And Bedding</h4>
                <div class="flex items-center">
                    <input id="select-all-bedding" type="checkbox" wire:click="selectAll('bedroom_bedding', $event.target.checked)" class="w-4 h-4 text-[#0030C5] bg-gray-100 border-gray-300 rounded focus:ring-[#0030C5]">
                    <label for="select-all-bedding" class="ml-2 text-sm font-medium text-gray-900">Select All</label>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($labels['bedroom_bedding'] as $key => $label)
                    <div class="flex items-center bg-white p-4 rounded-lg border border-[#E8F0FE]">
                        <input id="bedding-{{ $key }}" type="checkbox" wire:model="bedroom_bedding.{{ $key }}" class="w-4 h-4 text-[#0030C5] bg-gray-100 border-gray-300 rounded focus:ring-[#0030C5]">
                        <label for="bedding-{{ $key }}" class="ml-2 text-sm font-medium text-gray-900">{{ $label }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Group 3: Kitchen And Dining --}}
        <div class="p-4 rounded-lg border border-[#D1E0FF] bg-[#F7FAFF]">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-lg font-semibold text-[#021C3F]">Kitchen And Dining</h4>
                <div class="flex items-center">
                    <input id="select-all-kitchen" type="checkbox" wire:click="selectAll('kitchen_dining', $event.target.checked)" class="w-4 h-4 text-[#0030C5] bg-gray-100 border-gray-300 rounded focus:ring-[#0030C5]">
                    <label for="select-all-kitchen" class="ml-2 text-sm font-medium text-gray-900">Select All</label>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($labels['kitchen_dining'] as $key => $label)
                    <div class="flex items-center bg-white p-4 rounded-lg border border-[#E8F0FE]">
                        <input id="kitchen-{{ $key }}" type="checkbox" wire:model="kitchen_dining.{{ $key }}" class="w-4 h-4 text-[#0030C5] bg-gray-100 border-gray-300 rounded focus:ring-[#0030C5]">
                        <label for="kitchen-{{ $key }}" class="ml-2 text-sm font-medium text-gray-900">{{ $label }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Group 4: Entertainment --}}
        <div class="p-4 rounded-lg border border-[#D1E0FF] bg-[#F7FAFF]">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-lg font-semibold text-[#021C3F]">Entertainment</h4>
                {{-- 💡 ADDED: Select All checkbox for Entertainment --}}
                <div class="flex items-center">
                    <input id="select-all-entertainment" type="checkbox" wire:click="selectAll('entertainment', $event.target.checked)" class="w-4 h-4 text-[#0030C5] bg-gray-100 border-gray-300 rounded focus:ring-[#0030C5]">
                    <label for="select-all-entertainment" class="ml-2 text-sm font-medium text-gray-900">Select All</label>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4">
                @foreach ($labels['entertainment'] as $key => $label)
                    <div class="flex items-center bg-white p-4 rounded-lg border border-[#E8F0FE]">
                        <input id="entertainment-{{ $key }}" type="checkbox" wire:model="entertainment.{{ $key }}" class="w-4 h-4 text-[#0030C5] bg-gray-100 border-gray-300 rounded focus:ring-[#0030C5]">
                        <label for="entertainment-{{ $key }}" class="ml-2 text-sm font-medium text-gray-900">{{ $label }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Group 5: Additional Items --}}
        <div class="p-4 rounded-lg border border-[#D1E0FF] bg-[#F7FAFF]">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-lg font-semibold text-[#021C3F]">Additional Items</h4>
                <div class="flex items-center">
                    <input id="select-all-additional" type="checkbox" wire:click="selectAll('additional_items', $event.target.checked)" class="w-4 h-4 text-[#0030C5] bg-gray-100 border-gray-300 rounded focus:ring-[#0030C5]">
                    <label for="select-all-additional" class="ml-2 text-sm font-medium text-gray-900">Select All</label>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($labels['additional_items'] as $key => $label)
                    <div class="flex items-center bg-white p-4 rounded-lg border border-[#E8F0FE]">
                        <input id="additional-{{ $key }}" type="checkbox" wire:model="additional_items.{{ $key }}" class="w-4 h-4 text-[#0030C5] bg-gray-100 border-gray-300 rounded focus:ring-[#0030C5]">
                        <label for="additional-{{ $key }}" class="ml-2 text-sm font-medium text-gray-900">{{ $label }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Group 6: Consumables Provided --}}
        <div class="p-4 rounded-lg border border-[#D1E0FF] bg-[#F7FAFF]">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-lg font-semibold text-[#021C3F]">Consumables Provided</h4>
                <div class="flex items-center">
                    <input id="select-all-consumables" type="checkbox" wire:click="selectAll('consumables_provided', $event.target.checked)" class="w-4 h-4 text-[#0030C5] bg-gray-100 border-gray-300 rounded focus:ring-[#0030C5]">
                    <label for="select-all-consumables" class="ml-2 text-sm font-medium text-gray-900">Select All</label>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($labels['consumables_provided'] as $key => $label)
                    <div class="flex items-center bg-white p-4 rounded-lg border border-[#E8F0FE]">
                        <input id="consumable-{{ $key }}" type="checkbox" wire:model="consumables_provided.{{ $key }}" class="w-4 h-4 text-[#0030C5] bg-gray-100 border-gray-300 rounded focus:ring-[#0030C5]">
                        <label for="consumable-{{ $key }}" class="ml-2 text-sm font-medium text-gray-900">{{ $label }}</label>
                    </div>
                @endforeach
            </div>
        </div>

    </div> {{-- End Unit Amenities --}}


    {{-- Main Title 2 --}}
    <h3 class="text-2xl font-semibold text-[#021C3F] my-6">Property Amenities</h3>

    <div class="flex flex-col gap-6">
        {{-- Group 7: Property Amenities --}}
        <div class="p-4 rounded-lg border border-[#D1E0FF] bg-[#F7FAFF]">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-lg font-semibold text-[#021C3F]">Amenities And Features</h4>
                <div class="flex items-center">
                    <input id="select-all-property" type="checkbox" wire:click="selectAll('property_amenities', $event.target.checked)" class="w-4 h-4 text-[#0030C5] bg-gray-100 border-gray-300 rounded focus:ring-[#0030C5]">
                    <label for="select-all-property" class="ml-2 text-sm font-medium text-gray-900">Select All</label>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($labels['property_amenities'] as $key => $label)
                    <div class="flex items-center bg-white p-4 rounded-lg border border-[#E8F0FE]">
                        <input id="property-{{ $key }}" type="checkbox" wire:model="property_amenities.{{ $key }}" class="w-4 h-4 text-[#0030C5] bg-gray-100 border-gray-300 rounded focus:ring-[#0030C5]">
                        <label for="property-{{ $key }}" class="ml-2 text-sm font-medium text-gray-900">{{ $label }}</label>
                    </div>
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
            {{-- 💡 REVISED: Previous button color --}}
            class="px-8 py-3 text-base font-medium text-white bg-[#2469F5] rounded-lg hover:bg-[#1c55c0] transition-colors duration-200 shadow-md">
            Previous
        </button>

        @if ($currentStep < count($steps))
            <button wire:click="nextStep"
                {{-- 💡 REVISED: Next button color --}}
                class="px-10 py-3 text-base font-medium text-white bg-[#070642] rounded-lg hover:bg-[#22228e] transition-colors duration-200 shadow-md">
                Next
            </button>
        @else
            <button wire:click="finish" class="px-10 py-3 text-base font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors duration-200 shadow-md">Finish</button>
        @endif
    </div>
</div>
