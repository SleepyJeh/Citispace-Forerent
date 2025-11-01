<div class="p-6 md:p-8">

    <h3 class="text-lg font-semibold text-[#021C3F] mb-6">
        Unit Identification
    </h3>

    {{-- Form Fields --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">

        <div class="relative md:col-span-2">
            <input type="text" id="building_name" wire:model="building_name" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer" placeholder=" " />
            <label for="building_name" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">Building Name</label>
        </div>

        <div class="relative">
            <input type="text" id="address" wire:model="address" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer" placeholder=" " />
            <label for="address" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">Address</label>
        </div>

        <div class="relative">
            <input type="number" id="floor_number" wire:model="floor_number" min="0" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer" placeholder=" " />
            <label for="floor_number" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">Floor Number</label>
        </div>

        <div class="relative">
            <input type="text" id="unit_number" wire:model="unit_number" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer" placeholder=" " />
            <label for="unit_number" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">Unit Number</label>
        </div>

        <div class="relative">
            <input type="text" id="room_number" wire:model="room_number" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer" placeholder=" " />
            <label for="room_number" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">Room Number</label>
        </div>

        <div class="relative">
            <select id="dorm_type" wire:model="dorm_type" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer">
                <option value="" selected></option>
                <option value="All Female">All Female</option>
                <option value="All Male">All Male</option>
                <option value="Co-ed">Co-ed</option>
            </select>
            <label for="dorm_type" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">Dorm Type</label>
        </div>

        <div class="relative">
            <select id="room_type" wire:model="room_type" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer">
                <option value="" selected></option>
                <option value="Shared">Shared</option>
                <option value="Private">Private</option>
            </select>
            <label for="room_type" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">Room Type</label>
        </div>

        {{-- Bed Type --}}
        <div class="relative">
            <select id="bed_type" wire:model="bed_type" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer">
                <option value="" selected></option>
                <option value="Single">Single</option>
                <option value="Double Deck">Double Deck</option>
                <option value="Queen">Queen</option>
            </select>
            <label for="bed_type" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">Bed Type</label>
        </div>

        {{-- Bed Number --}}
        <div class="relative">
            <input type="text" id="bed_number" wire:model="bed_number" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer" placeholder=" " />
            <label for="bed_number" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">Bed Number</label>
        </div>

        {{-- Utility Subsidy Checkbox --}}
        <div class="flex items-center md:col-span-2">
            <input id="utility_subsidy" type="checkbox" wire:model="utility_subsidy" class="w-4 h-4 text-[#0030C5] bg-gray-100 border-gray-300 rounded focus:ring-[#0030C5]">
            <label for="utility_subsidy" class="ms-2 text-sm font-medium text-gray-900">Utility Subsidy</label>
        </div>

    </div>

    {{-- Horizontal Separator (Dotted Line) --}}
    <div class="border-t border-dashed border-gray-300 my-8"></div>

    {{-- Section 2: Capacity --}}
    <h3 class="text-lg font-semibold text-[#021C3F] mb-6">
        Capacity
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
        <div class="relative">
            <input type="number" id="unit_capacity" wire:model="unit_capacity" min="0" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer" placeholder=" " />
            <label for="unit_capacity" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">Unit Capacity</label>
        </div>

        {{-- Room Capacity --}}
        <div class="relative">
            <input type="number" id="room_capacity" wire:model="room_capacity" min="0" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer" placeholder=" " />
            <label for="room_capacity" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">Room Capacity</label>
        </div>
    </div>


    <div class="border-t border-dashed border-gray-300 my-8"></div>

    {{-- Navigation Buttons --}}
    <div class="flex justify-between items-center">
        @php
            $isPrevDisabled = $currentStep == 1;
        @endphp

        <button
            wire:click="previousStep"
            {{ $isPrevDisabled ? 'disabled' : '' }}
            class="py-2.5 px-6 font-medium text-sm rounded-lg shadow-md transition-colors duration-200
            {{ $isPrevDisabled
                ? 'text-gray-500 bg-gray-200 cursor-not-allowed'
                : 'text-gray-700 bg-gray-200 hover:bg-gray-300'
                }}">
            Previous
        </button>

       @if ($currentStep < count($steps))
        <button wire:click="nextStep"
            class="py-2.5 px-6 font-medium text-sm text-white bg-[#070642] rounded-lg hover:bg-[#22228e] transition-colors duration-200 shadow-md">
            Next
        </button>
    @else
        <button wire:click="finish" class="py-2.5 px-6 font-medium text-sm text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors duration-200 shadow-md">Finish</button>
    @endif
    </div>
</div>
