{{--
    ADDED 'cursor-pointer' AND the 'onclick' event dispatcher.
    This now sends the event that UnitAccordion is listening for.
--}}
<div class="bg-white rounded-lg shadow-md overflow-hidden flex-shrink-0 w-64 transition-all hover:shadow-lg cursor-pointer"
     onclick="Livewire.dispatch('buildingSelected', { buildingId: {{ $property->property_id }} })">

    {{-- Image Container --}}
    <div class="relative h-48 overflow-hidden">
        <img
            src="{{ $property->image ?? asset('images/default-building.jpg') }}"
            alt="{{ $property->building_name }}"
            class="w-full h-full object-cover"
        >
    </div>

    {{-- Content Container --}}
    <div class="p-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-1 truncate">
            {{ $property->building_name }}
        </h3>
        <p class="text-sm text-gray-600 flex items-start gap-1">
            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
            </svg>
            <span class="line-clamp-2">{{ $property->address }}</span>
        </p>
    </div>
</div>
