<div class="p-4">
    {{-- Step Header --}}
    <h3 class="flex items-center text-xl font-semibold text-[#021C3F] mb-6">
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
                        $displayLabel = $key === 'fast_wifi' ? 'Fast Wi-Fi (50Mbps Woofy Fiber)' : ucwords(str_replace('_', ' ', $key));
                    @endphp
                    <div class="flex items-center bg-[#FBFCFF] p-3 rounded-lg border border-[#E8F0FE]">
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
                        $displayLabel = $key === 'beddings_pillows_duvet' ? 'Beddings, Pillows, Duvet' : ucwords(str_replace('_', ' ', $key));
                    @endphp
                    <div class="flex items-center bg-[#FBFCFF] p-3 rounded-lg border border-[#E8F0FE]">
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
                        $displayLabel = ucwords(str_replace('_', ' ', $key));
                    @endphp
                    <div class="flex items-center bg-[#FBFCFF] p-3 rounded-lg border border-[#E8F0FE]">
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
                        $displayLabel = $key === 'smart_tv_disney_plus' ? '43" Smart TV With Free Disney+ Access' : ucwords(str_replace('_', ' ', $key));
                    @endphp
                    <div class="flex items-center col-span-2 bg-[#FBFCFF] p-3 rounded-lg border border-[#E8F0FE]">
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
                    <div class="flex items-center bg-[#FBFCFF] p-3 rounded-lg border border-[#E8F0FE]">
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
                        if ($key === 'toothpaste_1' || $key === 'toothpaste_2') {
                            $displayLabel = 'Toothpaste';
                        } else {
                            $displayLabel = ucwords(str_replace('_', ' ', $key));
                        }
                    @endphp
                    <div class="flex items-center bg-[#FBFCFF] p-3 rounded-lg border border-[#E8F0FE]">
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
        <button
            wire:click="previousStep"
            class="px-8 py-3 text-base font-medium text-white bg-[#0300A0] rounded-lg hover:bg-[#2e2be7] transition-colors duration-200 shadow-md">
            Previous
        </button>

        @if ($currentStep < count($steps))
            <button wire:click="nextStep" class="px-10 py-3 text-base font-medium text-white bg-[#070642] rounded-lg hover:bg-[#22228e] transition-colors duration-200 shadow-md">Next</button>
        @else
            <button wire:click="finish" class="px-10 py-3 text-base font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors duration-200 shadow-md">Finish</button>
        @endif
    </div>
</div>
