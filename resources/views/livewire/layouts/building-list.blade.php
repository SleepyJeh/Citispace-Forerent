<div>
    <span id="main-header" class="header-title text-xl md:text-2xl text-black-900 font-bold">Buildings</span>

    <div class="flex gap-4 overflow-x-auto py-4 mb-8 px-2 scroll-smooth [&::-webkit-scrollbar]:h-2 [&::-webkit-scrollbar-thumb]:bg-gray-400 [&::-webkit-scrollbar-track]:bg-gray-200 [&::-webkit-scrollbar-thumb]:rounded-full">
        @forelse ($properties as $property)
            <div
                wire:click="selectProperty({{ $property->property_id }})"
                class="bg-white rounded-2xl shadow-lg overflow-hidden flex-shrink-0 w-72 cursor-pointer border-2 transition-all duration-200 hover:shadow-xl
                    {{ $selectedPropertyId === $property->property_id ? 'border-blue-600 ring-2 ring-blue-200' : 'border-transparent hover:border-blue-300' }}">

                <!-- Image -->
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ asset('images/building_placeholder.png') }}" alt="{{ $property->building_name }}" class="w-full h-full object-cover">
                </div>

                <!-- Content -->
                <div class="p-6">
                    <h3 class="text-xl font-bold text-blue-900 mb-2">{{ $property->building_name }}</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $property->address }}</p>
                </div>
            </div>
        @empty
            <div class="w-full flex flex-col items-center justify-center text-center p-16 border-2 border-dashed border-gray-300 rounded-lg bg-white">
                <h3 class="text-xl font-semibold text-gray-700 mt-4">No properties found</h3>
                <p class="text-gray-500 mt-2">Get started by adding your first property.</p>
            </div>
        @endforelse
    </div>
</div>
