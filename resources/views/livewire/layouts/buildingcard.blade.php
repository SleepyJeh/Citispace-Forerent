<div
    wire:click="$emitUp('selectProperty', {{ $property->property_id }})"
    class="bg-white rounded-2xl shadow-lg overflow-hidden flex-shrink-0 w-72 cursor-pointer border transition-colors duration-200
        {{ $selectedPropertyId === $property->property_id ? 'border-blue-600 ring-2 ring-blue-200' : 'border-transparent' }}">
<!-- Image Container -->
    <div class="relative h-48 overflow-hidden">
        <img
            src="{{ $image ?? 'default.jpg' }}"
            class="w-64 h-full object-cover"
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
