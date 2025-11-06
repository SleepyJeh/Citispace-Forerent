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

    <!-- Content Container -->
    <div class="p-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-1">
            {{ $property->building_name }}
        </h3>
        <p class="text-sm text-gray-600">
            {{ $property->address }}
        </p>
    </div>
</div>
