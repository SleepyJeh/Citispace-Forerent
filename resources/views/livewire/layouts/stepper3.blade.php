{{-- This view ONLY contains the fields for Step 3 --}}
<div class="p-6 md:p-8">

    <h3 class="text-lg font-semibold text-[#021C3F] mb-6">
        Review & Predict Price
    </h3>
    
    {{-- Success/Error Messages --}}
    @if (session('success'))
        <div class="p-3 bg-green-100 text-green-800 rounded-lg mb-6 text-sm" wire:key="success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="p-3 bg-red-100 text-red-800 rounded-lg mb-6 text-sm" wire:key="error">
            {{ session('error') }}
        </div>
    @endif

    {{-- Review Details (Unchanged) --}}
    <div class="space-y-4 mb-6">
        <h4 class="text-md font-semibold text-gray-700">Unit Details:</h4>
        <ul class="list-disc list-inside text-sm text-gray-600">
            <li><strong>Building:</strong> {{ $properties->find($property_id)?->building_name ?? 'N/A' }}</li>
            <li><strong>Floor:</strong> {{ $floor_number }}</li>
            <li><strong>Room Type:</strong> {{ $room_type }}</li>
            <li><strong>Bed Type:</strong> {{ $bed_type }}</li>
            <li><strong>Dorm Type:</strong> {{ $m_f }}</li>
            <li><strong>Room Capacity:</strong> {{ $room_cap }}</li>
            <li><strong>Unit Capacity:</strong> {{ $unit_cap }}</li>
        </ul>
        
        <h4 class="text-md font-semibold text-gray-700">Selected Amenities:</h4>
        <div class="flex flex-wrap gap-2">
            @forelse (array_keys(array_filter($model_amenities)) as $amenityKey)
                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">{{ $amenity_labels[$amenityKey] }}</span>
            @empty
                <span class="text-xs text-gray-500">No amenities selected.</span>
            @endforelse
        </div>
    </div>
    
    {{-- 
      💡
      PREDICTION SECTION - SIMPLIFIED
      All loading logic is GONE.
      💡
    --}}
    <div class="border-t border-dashed border-gray-300 my-8 pt-8">
        
        {{-- Show this section *only* if a prediction has been made --}}
        @if ($predicted_price)
            <div class="text-center">
                <span class="text-lg text-gray-600">Predicted Monthly Price:</span>
                <h3 class="text-4xl font-bold text-[#070642]">
                    ₱ {{ number_format($predicted_price, 2) }}
                </h3>
            </div>

            {{-- The "Actual Price" input field --}}
            <div class="mt-8 max-w-sm mx-auto">
                <label for="actual_price" class="block text-sm font-medium text-gray-700 mb-1">Set Actual Price:</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">₱</span>
                    <input type="number" step="0.01" id="actual_price" wire:model.defer="actual_price"
                           class="block w-full pl-7 pr-3 py-2.5 text-lg rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           placeholder="0.00">
                </div>
                @error('actual_price') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
        @else
            {{-- Fallback message if something went wrong --}}
            <div class="text-center">
                <p class="text-gray-500">Could not calculate prediction. Please go back.</p>
            </div>
        @endif
    </div>


    {{-- Navigation Buttons --}}
    <div class="flex justify-between items-center mt-8">
        <button
            wire:click="previousStep"
            class="py-2.5 px-6 font-medium text-sm rounded-lg shadow-md transition-colors duration-200 text-gray-700 bg-gray-200 hover:bg-gray-300">
            Previous
        </button>

        {{-- Show Save button only if prediction exists --}}
        @if ($predicted_price)
            <button wire:click="saveUnit"
                class="py-2.5 px-6 font-medium text-sm text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors duration-200 shadow-md">
                Save Unit
            </button>
        @endif
    </div>
</div>