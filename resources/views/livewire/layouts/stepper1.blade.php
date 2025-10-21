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
        <button wire:click="nextStep" class="px-10 py-3 text-base font-medium text-white bg-[#070642] rounded-lg hover:bg-[#22228e] transition-colors duration-200 shadow-md">Next</button>
    @else
        <button wire:click="finish" class="px-10 py-3 text-base font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors duration-200 shadow-md">Finish</button>
    @endif
</div>
