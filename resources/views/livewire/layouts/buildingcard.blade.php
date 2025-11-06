<div
    wire:click="$emitUp('selectProperty', {{ $property->property_id }})"
    class="bg-white rounded-2xl shadow-lg overflow-hidden flex-shrink-0 w-72 cursor-pointer border transition-colors duration-200
        {{ $selectedPropertyId === $property->property_id ? 'border-blue-600 ring-2 ring-blue-200' : 'border-transparent' }}">

    <!-- Image -->
    <div class="relative h-56 overflow-hidden">
        <img src="{{ $image }}" class="w-full h-full object-cover">
    </div>

    <!-- Content -->
    <div class="p-6">
        <h3 class="text-xl font-bold text-blue-900 mb-2">{{ $property->building_name }}</h3>
        <p class="text-sm text-gray-600 leading-relaxed">{{ $property->address }}</p>
    </div>
</div>
