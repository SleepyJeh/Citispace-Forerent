<div class="bg-white rounded-lg shadow-md overflow-hidden flex-shrink-0">
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
