<<<<<<< HEAD

<div class="p-6 md:p-8">

    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-bold text-gray-900">General Features</h3>
        <div class="flex items-center">
            <input id="master-select-all"
                   type="checkbox"
                   wire:click="masterSelectAll($event.target.checked)"
                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
            <label for="master-select-all" class="ml-2 text-sm font-medium text-gray-900">Select All</label>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 mb-4">
        @foreach ($labels['amenities_features'] as $key => $label)
            <div class="flex items-center">
                <input id="amenity-{{ $key }}" type="checkbox" wire:model="amenities_features.{{ $key }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                <label for="amenity-{{ $key }}" class="ml-2 text-sm font-medium text-gray-900">{{ $label }}</label>
            </div>
        @endforeach
    </div>

    <hr class="my-6 border-gray-200">

    <h3 class="text-lg font-bold text-gray-900 mb-4">Bedroom And Bedding</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 mb-4">
        @foreach ($labels['bedroom_bedding'] as $key => $label)
            <div class="flex items-center">
                <input id="bedding-{{ $key }}" type="checkbox" wire:model="bedroom_bedding.{{ $key }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                <label for="bedding-{{ $key }}" class="ml-2 text-sm font-medium text-gray-900">{{ $label }}</label>
            </div>
        @endforeach
    </div>

    <hr class="my-6 border-gray-200">

    <h3 class="text-lg font-bold text-gray-900 mb-4">Kitchen And Dining</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 mb-4">
        @foreach ($labels['kitchen_dining'] as $key => $label)
            <div class="flex items-center">
                <input id="kitchen-{{ $key }}" type="checkbox" wire:model="kitchen_dining.{{ $key }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                <label for="kitchen-{{ $key }}" class="ml-2 text-sm font-medium text-gray-900">{{ $label }}</label>
            </div>
        @endforeach
    </div>

    @if(count($labels['entertainment']) > 0)
        <hr class="my-6 border-gray-200">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Entertainment</h3>
        <div class="grid grid-cols-1 gap-x-8 gap-y-4 mb-4">
            @foreach ($labels['entertainment'] as $key => $label)
                <div class="flex items-center">
                    <input id="entertainment-{{ $key }}" type="checkbox" wire:model="entertainment.{{ $key }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                    <label for="entertainment-{{ $key }}" class="ml-2 text-sm font-medium text-gray-900">{{ $label }}</label>
                </div>
            @endforeach
        </div>
    @endif

    @if(count($labels['additional_items']) > 0)
        <hr class="my-6 border-gray-200">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Additional Items</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 mb-4">
            @foreach ($labels['additional_items'] as $key => $label)
                <div class="flex items-center">
                    <input id="additional-{{ $key }}" type="checkbox" wire:model="additional_items.{{ $key }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                    <label for="additional-{{ $key }}" class="ml-2 text-sm font-medium text-gray-900">{{ $label }}</label>
                </div>
            @endforeach
        </div>
    @endif

    @if(count($labels['consumables_provided']) > 0)
        <hr class="my-6 border-gray-200">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Consumables Provided</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 mb-4">
            @foreach ($labels['consumables_provided'] as $key => $label)
                <div class="flex items-center">
                    <input id="consumable-{{ $key }}" type="checkbox" wire:model="consumables_provided.{{ $key }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                    <label for="consumable-{{ $key }}" class="ml-2 text-sm font-medium text-gray-900">{{ $label }}</label>
                </div>
            @endforeach
        </div>
    @endif

    <hr class="my-6 border-gray-200">

    <h3 class="text-lg font-bold text-gray-900 mb-4">Property Amenities</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 mb-4">
        @foreach ($labels['property_amenities'] as $key => $label)
            <div class="flex items-center">
                <input id="property-{{ $key }}" type="checkbox" wire:model="property_amenities.{{ $key }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                <label for="property-{{ $key }}" class="ml-2 text-sm font-medium text-gray-90Welcome">{{ $label }}</label>
            </div>
        @endforeach
    </div>


    <div class="border-t border-gray-200 my-8"></div>

    <div class="flex justify-between items-center">
        <button
            wire:click="previousStep"
            class="px-8 py-3 text-base font-medium text-white bg-[#2469F5] rounded-lg hover:bg-[#1c55c0] transition-colors duration-200 shadow-md">
            Previous
        </button>

        @if ($currentStep < count($steps))
            <button wire:click="nextStep"
                class="px-10 py-3 text-base font-medium text-white bg-[#070642] rounded-lg hover:bg-[#22228e] transition-colors duration-200 shadow-md">
                Next
            </button>
        @else
            <button wire:click="finish" class="px-10 py-3 text-base font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors duration-200 shadow-md">Finish</button>
        @endif
=======
{{-- This view ONLY contains the fields for Step 2 --}}
<div class="p-6 md:p-8">

    <h3 class="text-lg font-semibold text-[#021C3F] mb-6">
        Unit Amenities (for Price Prediction)
    </h3>
    
    <div class="p-4 rounded-lg border border-[#D1E0FF] bg-[#F7FAFF]">
        {{-- This grid has 3 columns on large screens --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            
            {{-- This loops over all 18 amenities from your CSV file --}}
            @foreach ($amenity_labels as $key => $label)
                <div class="flex items-center bg-white p-4 rounded-lg border border-[#E8F0FE]">
                    <input id="amenity-{{ $key }}" type="checkbox" wire:model.defer="model_amenities.{{ $key }}" class="w-4 h-4 text-[#0030C5] bg-gray-100 border-gray-300 rounded focus:ring-[#0030C5]">
                    <label for="amenity-{{ $key }}" class="ml-2 text-sm font-medium text-gray-900">{{ $label }}</label>
                </div>
            @endforeach

        </div>
    </div>

    {{-- Navigation Buttons --}}
    <div class="flex justify-between items-center mt-8">
        <button
            wire:click="previousStep"
            class="py-2.5 px-6 font-medium text-sm rounded-lg shadow-md transition-colors duration-200 text-gray-700 bg-gray-200 hover:bg-gray-300">
            Previous
        </button>

        <button wire:click="nextStep"
            class="py-2.5 px-6 font-medium text-sm text-white bg-[#070642] rounded-lg hover:bg-[#22228e] transition-colors duration-200 shadow-md">
            Next
        </button>
>>>>>>> 29d4319 (modified docker compose for api)
    </div>
</div>