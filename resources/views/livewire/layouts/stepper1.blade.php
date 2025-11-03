<<<<<<< HEAD
=======
{{-- This view ONLY contains the fields for Step 1 --}}
>>>>>>> 29d4319 (modified docker compose for api)
<div class="p-6 md:p-8">

    <h3 class="text-lg font-semibold text-[#021C3F] mb-6">
        Unit Details
    </h3>

    {{-- Form Fields --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">

<<<<<<< HEAD
=======
        {{-- Property (Building) --}}
>>>>>>> 29d4319 (modified docker compose for api)
        <div class="relative md:col-span-2">
            <select id="property_id" wire:model.defer="property_id" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer">
                <option value="" selected>Select a Building...</option>
                @foreach($properties as $property)
                    <option value="{{ $property->property_id }}">{{ $property->building_name }}</option>
                @endforeach
            </select>
            <label for="property_id" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">Property / Building</label>
            @error('property_id') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
        </div>
<<<<<<< HEAD

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
=======
        
        {{-- Floor Number --}}
        <div class="relative">
            <input type="number" id="floor_number" wire:model.defer="floor_number" min="0" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer" placeholder=" " />
            <label for="floor_number" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] ...">Floor Number</label>
            @error('floor_number') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
        </div>

        {{-- Dorm Type (M/F) --}}
        <div class="relative">
            <select id="m_f" wire:model.defer="m_f" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer">
>>>>>>> 29d4319 (modified docker compose for api)
                <option value="Co-ed">Co-ed</option>
                <option value="Male">All Male</option>
                <option value="Female">All Female</option>
            </select>
            <label for="m_f" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 ...">Dorm Type (M/F)</label>
            @error('m_f') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
        </div>

<<<<<<< HEAD
        <div class="relative">
            <select id="room_type" wire:model="room_type" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer">
                <option value="" selected></option>
                <option value="Shared">Shared</option>
                <option value="Private">Private</option>
=======
        {{-- Room Type (Must match your ENUM) --}}
        <div class="relative">
            <select id="room_type" wire:model.defer="room_type" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer">
                <option value="" selected>Select room type...</option>
                <option value="Standard">Standard</option>
                <option value="Deluxe">Deluxe</option>
                <option value="Suite">Suite</option>
>>>>>>> 29d4319 (modified docker compose for api)
            </select>
            <label for="room_type" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 ...">Room Type</label>
            @error('room_type') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
        </div>

        {{-- Bed Type (Must match your ENUM) --}}
        <div class="relative">
<<<<<<< HEAD
            <select id="bed_type" wire:model="bed_type" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer">
                <option value="" selected></option>
=======
            <select id="bed_type" wire:model.defer="bed_type" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer">
                <option value="" selected>Select bed type...</option>
>>>>>>> 29d4319 (modified docker compose for api)
                <option value="Single">Single</option>
                <option value="Bunk">Bunk</option>
                <option value="Twin">Twin</option>
            </select>
            <label for="bed_type" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 ...">Bed Type</label>
            @error('bed_type') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
        </div>

        {{-- Unit Capacity (unit_cap) --}}
        <div class="relative">
            <input type="number" id="unit_cap" wire:model.defer="unit_cap" min="1" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer" placeholder=" " />
            <label for="unit_cap" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 ...">Total Unit Capacity</label>
            @error('unit_cap') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
        </div>

        {{-- Room Capacity (room_cap) --}}
        <div class="relative">
            <input type="number" id="room_cap" wire:model.defer="room_cap" min="1" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer" placeholder=" " />
            <label for="room_cap" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 ...">Room Capacity</label>
            @error('room_cap') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
        </div>

    </div>

<<<<<<< HEAD
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

=======
>>>>>>> 29d4319 (modified docker compose for api)
    {{-- Navigation Buttons --}}
    <div class="flex justify-between items-center mt-8">
        <button
            wire:click="previousStep"
<<<<<<< HEAD
            {{ $isPrevDisabled ? 'disabled' : '' }}
            class="py-2.5 px-6 font-medium text-sm rounded-lg shadow-md transition-colors duration-200
            {{ $isPrevDisabled
                ? 'text-gray-500 bg-gray-200 cursor-not-allowed'
                : 'text-gray-700 bg-gray-200 hover:bg-gray-300'
                }}">
=======
            disabled
            class="py-2.5 px-6 font-medium text-sm rounded-lg shadow-md transition-colors duration-200 text-gray-500 bg-gray-200 cursor-not-allowed">
>>>>>>> 29d4319 (modified docker compose for api)
            Previous
        </button>

        <button wire:click="nextStep"
            class="py-2.5 px-6 font-medium text-sm text-white bg-[#070642] rounded-lg hover:bg-[#22228e] transition-colors duration-200 shadow-md">
            Next
        </button>
    </div>
</div>