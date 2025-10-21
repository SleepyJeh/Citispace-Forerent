<div class="p-4">
    {{-- Step Header --}}
    <h3 class="flex items-center text-xl font-semibold text-[#021C3F] mb-6">
        <svg class="w-6 h-6 mr-3 text-[#0030C5]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2 2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
        Capacity
    </h3>

    {{-- Form Fields --}}
    <div class="grid grid-cols-2 gap-x-8 gap-y-6">
        <div class="col-span-2">
            <label for="square_area" class="block mb-2 text-sm font-medium text-gray-900">Square Area (Sqm)</label>
            <input type="text" id="square_area" wire:model="square_area" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#0030C5] focus:border-[#0030C5] block w-full p-3" placeholder="Enter total floor area">
        </div>

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

        <div>
            <label for="total_beds" class="block mb-2 text-sm font-medium text-gray-900">Total Beds</label>
            <input type="number" id="total_beds" wire:model="total_beds" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#0030C5] focus:border-[#0030C5] block w-full p-3" placeholder="eg. 12">
        </div>
        <div>
            <label for="kitchen_count" class="block mb-2 text-sm font-medium text-gray-900">Kitchen Count</label>
            <input type="number" id="kitchen_count" wire:model="kitchen_count" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#0030C5] focus:border-[#0030C5] block w-full p-3" placeholder="eg. 1">
        </div>

        <div class="col-span-2">
            <label for="maximum_occupancy" class="block mb-2 text-sm font-medium text-gray-900">Maximum Occupancy</label>
            <input type="number" id="maximum_occupancy" wire:model="maximum_occupancy" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#0030C5] focus:border-[#0030C5] block w-full p-3" placeholder="Maximum number of guests">
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
